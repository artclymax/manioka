<?php
/**
 * Plugin Name:       Artcly Consent Logger & Validator
 * Plugin URI:        https://github.com/max-kot
 * Description:       Серверный модуль аудита и валидации согласий на обработку персональных данных (Закон РБ № 99-З). Журнал согласий с настраиваемым сроком хранения (мин. 1 год), серверная проверка форм (AJAX/POST/JSON), совместимость с WooCommerce и Contact Form 7.
 * Version:           1.2.0
 * Author:            max-kot / Арт Клай
 * License:           GPLv2 or later
 * Text Domain:       artcly-consent-logger
 * Requires at least: 5.6
 * Requires PHP:      7.4
 */
defined('ABSPATH') || exit;
define('ARTCLY_CL_VERSION', '1.2.0');
define('ARTCLY_CL_PATH', plugin_dir_path(__FILE__));
define('ARTCLY_CL_URL', plugin_dir_url(__FILE__));

/* =========================================================
 * 1. БЕЗОПАСНОЕ ОПРЕДЕЛЕНИЕ IP-АДРЕСА КЛИЕНТА
 * ========================================================= */
function artcly_cl_get_client_ip()
{
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
	if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
		return sanitize_text_field($_SERVER['HTTP_CF_CONNECTING_IP']);
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$parts = array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		$candidate = end($parts);
		if (filter_var($candidate, FILTER_VALIDATE_IP)) {
			return sanitize_text_field($candidate);
		}
	}
	return sanitize_text_field($ip);
}

/* =========================================================
 * 2. СОЗДАНИЕ И ОБНОВЛЕНИЕ ТАБЛИЦЫ БД (С УНИВЕРСАЛЬНОЙ МИГРАЦИЕЙ)
 * ========================================================= */
function artcly_cl_ensure_table_exists()
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$table = $wpdb->prefix . 'artcly_consent_form_logs';

	// 1. Создаём таблицу, если её нет
	dbDelta("CREATE TABLE IF NOT EXISTS {$table} (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        created_at datetime NOT NULL,
        ip_address varchar(45) NOT NULL,
        page_url text NOT NULL,
        order_id varchar(50) DEFAULT NULL,
        consent_version varchar(10) NOT NULL,
        consent_pd tinyint(1) DEFAULT 0 NOT NULL,
        consent_order tinyint(1) DEFAULT 0 NOT NULL,
        consent_ads tinyint(1) DEFAULT 0 NOT NULL,
        consent_offer tinyint(1) DEFAULT 0 NOT NULL,
        PRIMARY KEY  (id),
        KEY created_at (created_at),
        KEY order_id (order_id)
    ) {$charset_collate};");

	// 2. УНИВЕРСАЛЬНАЯ МИГРАЦИЯ: добавляем ВСЕ недостающие колонки
	$columns = $wpdb->get_col("DESCRIBE {$table}");

	$columns_map = array(
		'order_id' => "varchar(50) DEFAULT NULL",
		'consent_version' => "varchar(10) NOT NULL",
		'consent_pd' => "tinyint(1) DEFAULT 0 NOT NULL",
		'consent_order' => "tinyint(1) DEFAULT 0 NOT NULL",
		'consent_ads' => "tinyint(1) DEFAULT 0 NOT NULL",
		'consent_offer' => "tinyint(1) DEFAULT 0 NOT NULL",
	);

	$columns_order = array(
		'order_id' => 'page_url',
		'consent_version' => 'order_id',
		'consent_pd' => 'consent_version',
		'consent_order' => 'consent_pd',
		'consent_ads' => 'consent_order',
		'consent_offer' => 'consent_ads',
	);

	foreach ($columns_map as $col_name => $col_type) {
		if (is_array($columns) && !in_array($col_name, $columns, true)) {
			$after_col = isset($columns_order[$col_name]) ? " AFTER `{$columns_order[$col_name]}`" : '';
			$wpdb->query("ALTER TABLE {$table} ADD COLUMN `{$col_name}` {$col_type}{$after_col}");
		}
	}
}

/* =========================================================
 * 3. АКТИВАЦИЯ: создание таблицы + крон
 * ========================================================= */
register_activation_hook(__FILE__, 'artcly_cl_activate');
function artcly_cl_activate()
{
	artcly_cl_ensure_table_exists();
	if (get_option('artcly_cl_retention_years') === false) {
		update_option('artcly_cl_retention_years', 3);
	}
	if (!wp_next_scheduled('artcly_cl_daily_retention_event')) {
		wp_schedule_event(time(), 'daily', 'artcly_cl_daily_retention_event');
	}
}

/* =========================================================
 * 4. АВТО-ПРОВЕРКА ТАБЛИЦЫ ПРИ КАЖДОЙ ЗАГРУЗКЕ (страховка)
 * ========================================================= */
add_action('plugins_loaded', 'artcly_cl_ensure_table_exists');

/* =========================================================
 * 5. ДЕАКТИВАЦИЯ: только снятие крона. БД НЕ трогаем.
 * ========================================================= */
register_deactivation_hook(__FILE__, 'artcly_cl_deactivate');
function artcly_cl_deactivate()
{
	wp_clear_scheduled_hook('artcly_cl_daily_retention_event');
}

/* =========================================================
 * 6. РЕГИСТРАЦИЯ НАСТРОЕК (Срок хранения)
 * ========================================================= */
add_action('admin_init', 'artcly_cl_register_settings');
function artcly_cl_register_settings()
{
	register_setting(
		'artcly_cl_settings_group',
		'artcly_cl_retention_years',
		array(
			'type' => 'integer',
			'sanitize_callback' => 'artcly_cl_sanitize_retention_years',
			'default' => 3,
		)
	);
}

function artcly_cl_sanitize_retention_years($input)
{
	$years = intval($input);
	return max(1, $years);
}

/* =========================================================
 * 7. КРОН: удаление записей старше заданного количества лет
 * ========================================================= */
add_action('artcly_cl_daily_retention_event', 'artcly_cl_cron_cleanup');
function artcly_cl_cron_cleanup()
{
	global $wpdb;
	$retention_years = max(1, intval(get_option('artcly_cl_retention_years', 3)));
	$retention_date = gmdate('Y-m-d H:i:s', strtotime("-{$retention_years} years", current_time('timestamp')));
	$table = $wpdb->prefix . 'artcly_consent_form_logs';
	$wpdb->query($wpdb->prepare("DELETE FROM {$table} WHERE created_at < %s", $retention_date));
}

/* =========================================================
 * 8. УНИВЕРСАЛЬНАЯ ФУНКЦИЯ ЗАПИСИ В ЖУРНАЛ
 * ========================================================= */
function artcly_cl_insert_log($args)
{
	global $wpdb;
	$defaults = array(
		'ip_address' => artcly_cl_get_client_ip(),
		'page_url' => isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : home_url(),
		'order_id' => null,
		'consent_version' => '1.0',
		'consent_pd' => 0,
		'consent_order' => 0,
		'consent_ads' => 0,
		'consent_offer' => 0,
	);
	$data = wp_parse_args($args, $defaults);

	// Rate-limit: не более 30 записей в минуту с одного IP.
	$transient_key = 'artcly_cl_rl_' . md5($data['ip_address']);
	$count = (int) get_transient($transient_key);
	if ($count > 30) {
		return false;
	}
	set_transient($transient_key, $count + 1, 60);

	$table = $wpdb->prefix . 'artcly_consent_form_logs';
	return $wpdb->insert(
		$table,
		array(
			'created_at' => current_time('mysql'),
			'ip_address' => $data['ip_address'],
			'page_url' => $data['page_url'],
			'order_id' => $data['order_id'],
			'consent_version' => $data['consent_version'],
			'consent_pd' => (int) $data['consent_pd'],
			'consent_order' => (int) $data['consent_order'],
			'consent_ads' => (int) $data['consent_ads'],
			'consent_offer' => (int) $data['consent_offer'],
		),
		array('%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d')
	);
}

/* =========================================================
 * 9. УНИВЕРСАЛЬНЫЙ ПЕРЕХВАТЧИК POST (кастомные формы, AJAX, JSON)
 * ========================================================= */
add_action('init', 'artcly_cl_intercept_form_submissions', 1);
function artcly_cl_intercept_form_submissions()
{
	if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
		return;
	}
	if (isset($_POST['_wpcf7']) || isset($_POST['_wpcf7_container_post'])) {
		return; // У CF7 свои хуки
	}
	if (
		isset($_POST['woocommerce_checkout_place_order'])
		|| (isset($_GET['wc-ajax']) && $_GET['wc-ajax'] === 'checkout')
		|| (isset($_POST['wc-ajax']) && $_POST['wc-ajax'] === 'checkout')
	) {
		return; // У стандартного WC свои хуки
	}
	if (is_admin() && !wp_doing_ajax()) {
		return;
	}

	$post_data = $_POST;
	$json_data = array();
	$content_type = $_SERVER['CONTENT_TYPE'] ?? '';
	if (stripos($content_type, 'application/json') !== false) {
		$raw = file_get_contents('php://input');
		$decoded = json_decode($raw, true);
		if (is_array($decoded)) {
			$json_data = $decoded;
		}
	}

	$pick = function ($key) use ($post_data, $json_data) {
		if (isset($post_data[$key]))
			return $post_data[$key];
		if (isset($json_data[$key]))
			return $json_data[$key];
		return '';
	};

	$to_bool = function ($value) {
		if (is_array($value))
			$value = end($value);
		return in_array(strtolower(trim((string) $value)), array('1', 'on', 'yes', 'true'), true);
	};

	if ($pick('consent_version') === '' && $pick('consent_pd') === '' && $pick('consent_order') === '' && $pick('accept_offer') === '') {
		return;
	}

	$consent_pd = $to_bool($pick('consent_pd'));
	$consent_order = $to_bool($pick('consent_order'));
	$consent_ads = $to_bool($pick('consent_ads'));
	$consent_offer = $to_bool($pick('accept_offer'));
	$version = sanitize_text_field($pick('consent_version') ?: '1.0');

	// Серверная валидация
	$is_checkout = ($pick('action') === 'process_custom_checkout');
	$error = '';

	if ($is_checkout) {
		if (!$consent_pd && !$consent_order) {
			$error = 'Необходимо дать согласие на обработку персональных данных.';
		} elseif (!$consent_offer) {
			$error = 'Необходимо принять условия публичной оферты.';
		}
	} elseif (!$consent_pd && !$consent_order) {
		$error = 'Чтобы отправить заявку, подтвердите согласие на обработку персональных данных.';
	}

	if ($error !== '') {
		if (wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) {
			wp_send_json_error(array('message' => $error, 'error_code' => 'consent_required'), 400);
		}
		wp_die($error, 'Отказ в обработке', array('response' => 400));
	}

	artcly_cl_insert_log(array(
		'page_url' => !empty($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : home_url('/checkout/'),
		'order_id' => null,
		'consent_version' => $version,
		'consent_pd' => $consent_pd ? 1 : 0,
		'consent_order' => $consent_order ? 1 : 0,
		'consent_ads' => $consent_ads ? 1 : 0,
		'consent_offer' => $consent_offer ? 1 : 0,
	));
}

/* =========================================================
 * 10. CONTACT FORM 7: ВАЛИДАЦИЯ ЧЕКБОКСА
 * ========================================================= */
add_filter('wpcf7_validate', 'artcly_cl_cf7_validate', 20, 2);
function artcly_cl_cf7_validate($result, $tag)
{
	if (!is_object($result) || !method_exists($result, 'invalidate') || !is_object($tag)) {
		return $result;
	}

	if ($tag->name === 'consent_pd' || $tag->basetype === 'acceptance') {
		$submission = class_exists('WPCF7_Submission') ? WPCF7_Submission::get_instance() : null;
		$data = $submission ? (array) $submission->get_posted_data() : array();
		$consent_value = isset($data['consent_pd']) ? $data['consent_pd'] : '';

		if (empty($consent_value) || $consent_value === '0') {
			$result->invalidate($tag, 'Чтобы отправить заявку, подтвердите согласие на обработку персональных данных.');
		}
	}
	return $result;
}

/* =========================================================
 * 11. CONTACT FORM 7: ЛОГИРОВАНИЕ
 * ========================================================= */
add_action('wpcf7_before_send_mail', 'artcly_cl_cf7_log', 10, 3);
function artcly_cl_cf7_log($contact_form, &$abort = null, $submission = null)
{
	if (!$submission && class_exists('WPCF7_Submission')) {
		$submission = WPCF7_Submission::get_instance();
	}
	if (!$submission) {
		return;
	}

	$data = (array) $submission->get_posted_data();
	$consent_value = isset($data['consent_pd']) ? $data['consent_pd'] : '';

	if (empty($consent_value) || $consent_value === '0') {
		return;
	}

	$version = !empty($data['consent_version']) ? sanitize_text_field($data['consent_version']) : '1.0';
	$consent_ads = (!empty($data['consent_ads']) && $data['consent_ads'] !== '0') ? 1 : 0;
	$consent_offer = (!empty($data['accept_offer']) && $data['accept_offer'] !== '0') ? 1 : 0;

	$page_url = home_url();
	if (!empty($data['_wp_http_referer'])) {
		$page_url = esc_url_raw($data['_wp_http_referer']);
	} elseif (!empty($_SERVER['HTTP_REFERER'])) {
		$page_url = esc_url_raw($_SERVER['HTTP_REFERER']);
	}

	artcly_cl_insert_log(array(
		'page_url' => $page_url,
		'order_id' => null,
		'consent_version' => $version,
		'consent_pd' => 1,
		'consent_order' => 0,
		'consent_ads' => $consent_ads,
		'consent_offer' => $consent_offer,
	));
}

/* =========================================================
 * 12. WOOCOMMERCE: ВАЛИДАЦИЯ СТАНДАРТНОГО ЧЕКАУТА
 * ========================================================= */
add_action('woocommerce_checkout_process', 'artcly_cl_wc_checkout_validate');
function artcly_cl_wc_checkout_validate()
{
	if (empty($_POST['consent_order']) && empty($_POST['consent_pd'])) {
		wc_add_notice('Для оформления заказа необходимо подтвердить согласие на обработку персональных данных.', 'error');
	}
	if (empty($_POST['accept_offer'])) {
		wc_add_notice('Для оформления заказа необходимо принять условия публичной оферты.', 'error');
	}
}

/* =========================================================
 * 13. WOOCOMMERCE: ЛОГИРОВАНИЕ ЗАКАЗА (shortcode-чекаут)
 * ========================================================= */
add_action('woocommerce_checkout_order_processed', 'artcly_cl_wc_log_order', 10, 3);
function artcly_cl_wc_log_order($order_id, $posted_data, $order)
{
	if (empty($_POST['consent_order']) && empty($_POST['consent_pd'])) {
		return;
	}

	$version = !empty($_POST['consent_version']) ? sanitize_text_field($_POST['consent_version']) : '1.0';
	$consent_ads = !empty($_POST['consent_ads']) ? 1 : 0;
	$consent_offer = !empty($_POST['accept_offer']) ? 1 : 0;
	$page_url = !empty($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : (function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url());

	artcly_cl_insert_log(array(
		'page_url' => $page_url,
		'order_id' => (string) $order_id,
		'consent_version' => $version,
		'consent_pd' => !empty($_POST['consent_pd']) ? 1 : 0,
		'consent_order' => !empty($_POST['consent_order']) ? 1 : 0,
		'consent_ads' => $consent_ads,
		'consent_offer' => $consent_offer,
	));
}

/* =========================================================
 * 14. WOOCOMMERCE: ЛОГИРОВАНИЕ ЗАКАЗА (Store API / блочный чекаут)
 * ========================================================= */
add_action('woocommerce_store_api_checkout_order_processed', 'artcly_cl_wc_store_api_log', 10, 2);
function artcly_cl_wc_store_api_log($order, $request = null)
{
	if (!$order || !is_object($order)) {
		return;
	}

	$order_id = $order->get_id();
	$extensions = array();
	if ($request && is_callable(array($request, 'get_param'))) {
		$extensions = (array) $request->get_param('extensions');
	}

	$consent_order = !empty($extensions['artcly-consent']['consent_order'])
		|| !empty($_POST['consent_order'])
		|| !empty($_REQUEST['consent_order']);

	if (!$consent_order && empty($extensions['artcly-consent']['consent_pd'])) {
		return;
	}

	$version = !empty($extensions['artcly-consent']['consent_version'])
		? sanitize_text_field($extensions['artcly-consent']['consent_version'])
		: (!empty($_POST['consent_version']) ? sanitize_text_field($_POST['consent_version']) : '1.0');

	$consent_ads = !empty($extensions['artcly-consent']['consent_ads']) || !empty($_POST['consent_ads']);
	$consent_offer = !empty($extensions['artcly-consent']['accept_offer']) || !empty($_POST['accept_offer']);
	$page_url = !empty($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : (function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url());

	artcly_cl_insert_log(array(
		'page_url' => $page_url,
		'order_id' => (string) $order_id,
		'consent_version' => $version,
		'consent_pd' => !empty($extensions['artcly-consent']['consent_pd']) ? 1 : 0,
		'consent_order' => $consent_order ? 1 : 0,
		'consent_ads' => $consent_ads ? 1 : 0,
		'consent_offer' => $consent_offer ? 1 : 0,
	));
}

/* =========================================================
 * 15. ПРИВЯЗКА ORDER_ID К ПОСЛЕДНЕМУ ЛОГУ (для кастомных AJAX)
 * ========================================================= */
add_action('woocommerce_new_order', 'artcly_cl_bind_order_to_recent_log', 20, 2);
function artcly_cl_bind_order_to_recent_log($order_id, $order = null)
{
	if (!$order_id) {
		return;
	}

	global $wpdb;
	$table = $wpdb->prefix . 'artcly_consent_form_logs';
	$ip = artcly_cl_get_client_ip();
	$since = gmdate('Y-m-d H:i:s', strtotime('-15 minutes'));

	$log_id = $wpdb->get_var($wpdb->prepare(
		"SELECT id FROM {$table}
         WHERE ip_address = %s
           AND created_at >= %s
           AND (order_id IS NULL OR order_id = '' OR order_id = '0')
         ORDER BY id DESC
         LIMIT 1",
		$ip,
		$since
	));

	if ($log_id) {
		$wpdb->update(
			$table,
			array('order_id' => (string) $order_id),
			array('id' => (int) $log_id),
			array('%s'),
			array('%d')
		);
	}
}

/* =========================================================
 * 16. АДМИН-МЕНЮ
 * ========================================================= */
add_action('admin_menu', 'artcly_cl_admin_menu');
function artcly_cl_admin_menu()
{
	add_options_page(
		'Журнал согласий (99-З)',
		'Журнал согласий',
		'manage_options',
		'artcly-consent-logger',
		'artcly_cl_render_admin_page'
	);
}

/* =========================================================
 * 17. ССЫЛКА «ЖУРНАЛ» В СПИСКЕ ПЛАГИНОВ
 * ========================================================= */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'artcly_cl_plugin_action_links');
function artcly_cl_plugin_action_links($links)
{
	$url = admin_url('options-general.php?page=artcly-consent-logger');
	array_unshift($links, '<a href="' . esc_url($url) . '">' . esc_html__('Журнал', 'artcly-consent-logger') . '</a>');
	return $links;
}

/* =========================================================
 * 18. ЭКСПОРТ ЖУРНАЛА В CSV
 * ========================================================= */
add_action('admin_init', 'artcly_cl_export_csv');
function artcly_cl_export_csv()
{
	if (!isset($_GET['artcly_cl_export']) || !current_user_can('manage_options')) {
		return;
	}
	check_admin_referer('artcly_cl_export_action');

	global $wpdb;
	$table = $wpdb->prefix . 'artcly_consent_form_logs';
	$type = sanitize_key($_GET['artcly_cl_export']);
	if ($type !== 'forms') {
		return;
	}

	$filename = 'consent-log-forms-' . gmdate('Y-m-d-His') . '.csv';
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=' . $filename);
	header('Pragma: no-cache');
	header('Expires: 0');

	$out = fopen('php://output', 'w');
	fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM для Excel
	fputcsv($out, array(
		'ID',
		'Дата и время',
		'IP-адрес',
		'URL страницы',
		'Номер заказа',
		'Версия согласия',
		'Согласие ПД',
		'Согласие на заказ',
		'Рекламная рассылка',
		'Принятие оферты',
	), ';');

	$rows = $wpdb->get_results("SELECT * FROM {$table} ORDER BY id DESC", ARRAY_A);
	foreach ($rows as $r) {
		fputcsv($out, array_map('artcly_cl_escape_csv', array(
			$r['id'],
			$r['created_at'],
			$r['ip_address'],
			$r['page_url'],
			$r['order_id'] ?: '',
			$r['consent_version'],
			$r['consent_pd'] ? 'Да' : 'Нет',
			$r['consent_order'] ? 'Да' : 'Нет',
			$r['consent_ads'] ? 'Да' : 'Нет',
			$r['consent_offer'] ? 'Да' : 'Нет',
		)), ';');
	}
	fclose($out);
	exit;
}

/* =========================================================
 * 19. ЗАЩИТА ОТ CSV-ИНЪЕКЦИЙ
 * ========================================================= */
function artcly_cl_escape_csv($val)
{
	$val = (string) $val;
	if ($val !== '' && in_array($val[0], array('=', '+', '-', '@', "\t", "\r"), true)) {
		return "'" . $val;
	}
	return $val;
}

/* =========================================================
 * 20. РЕНДЕР СТРАНИЦЫ АДМИНКИ (С ОБНОВЛЕННОЙ ИНСТРУКЦИЕЙ)
 * ========================================================= */
function artcly_cl_render_admin_page()
{
	if (!current_user_can('manage_options')) {
		return;
	}

	global $wpdb;
	$table = $wpdb->prefix . 'artcly_consent_form_logs';

	// 🛠 БЛОК ДИАГНОСТИКИ ЗАПИСИ В БД
	$test_result = null;
	if (isset($_GET['artcly_test_db']) && check_admin_referer('artcly_test_db_action')) {
		$test_data = array(
			'created_at' => current_time('mysql'),
			'ip_address' => '127.0.0.1',
			'page_url' => 'ADMIN_DIAGNOSTIC_TEST',
			'order_id' => 'TEST-000',
			'consent_version' => '9.9.9',
			'consent_pd' => 1,
			'consent_order' => 1,
			'consent_ads' => 1,
			'consent_offer' => 1,
		);

		$result = $wpdb->insert($table, $test_data, array('%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d'));
		$test_result = array(
			'success' => $result !== false,
			'insert_id' => $wpdb->insert_id,
			'last_error' => $wpdb->last_error,
			'last_query' => $wpdb->last_query,
		);
		echo '<script>window.history.replaceState({}, document.title, window.location.pathname);</script>';
	}

	$table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table}'") === $table;
	$columns = $table_exists ? $wpdb->get_col("DESCRIBE {$table}") : [];
	$retention_years = max(1, intval(get_option('artcly_cl_retention_years', 3)));

	$per_page = 50;
	$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
	$offset = ($current_page - 1) * $per_page;
	$total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
	$logs = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$table} ORDER BY id DESC LIMIT %d OFFSET %d", $per_page, $offset));
	$total_pages = ceil($total / $per_page);
	?>
	<div class="wrap" style="max-width: 1400px;">
		<h1 style="display:flex; align-items:center; gap:12px; margin-bottom: 8px;">
			<span>Журнал согласий на обработку персональных данных</span>
			<span
				style="font-size: 12px; background: #008a20; color: #fff; padding: 3px 10px; border-radius: 12px; font-weight: 600;">Закон
				99-З</span>
		</h1>
		<p style="font-size: 14px; color: #50575e; margin-top: 0; margin-bottom: 20px;">
			Серверный журнал всех фактов получения согласий. Автоматическая очистка старых записей — ежедневно.
		</p>

		<!-- 🛠 НАЧАЛО БЛОКА ДИАГНОСТИКИ -->
		<div
			style="background: #fff; border-left: 4px solid #2271b1; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
			<h3 style="margin-top: 0; font-size: 15px;">🛠 Экстренная диагностика базы данных</h3>
			<p style="font-size: 13px; color: #50575e; margin-bottom: 15px;">
				Таблица <code><?php echo esc_html($table); ?></code>
				<?php echo $table_exists ? '<span style="color:green;">✅ существует</span>' : '<span style="color:red;">❌ НЕ СУЩЕСТВУЕТ</span>'; ?>.
				Найдено колонок: <?php echo count($columns); ?> (ожидалось 10).
			</p>
			<a href="<?php echo wp_nonce_url(admin_url('options-general.php?page=artcly-consent-logger&artcly_test_db=1'), 'artcly_test_db_action'); ?>"
				class="button button-primary" style="background: #d63638; border-color: #d63638; color: #fff;">
				⚠️ Сделать тестовую запись в БД
			</a>
			<?php if ($test_result !== null): ?>
				<div
					style="margin-top: 15px; padding: 15px; border-radius: 6px; background: <?php echo $test_result['success'] ? '#edfaef' : '#fcf0f1'; ?>; border: 1px solid <?php echo $test_result['success'] ? '#00a32a' : '#d63638'; ?>;">
					<?php if ($test_result['success']): ?>
						<strong style="color: #00a32a; font-size: 14px;">✅ УСПЕХ!</strong>
						<p style="margin: 5px 0 0; font-size: 13px;">Запись успешно добавлена. ID записи:
							<strong><?php echo esc_html($test_result['insert_id']); ?></strong>.</p>
					<?php else: ?>
						<strong style="color: #d63638; font-size: 14px;">❌ ОШИБКА ЗАПИСИ!</strong>
						<p
							style="margin: 5px 0 0; font-size: 13px; font-family: monospace; background: #fff; padding: 10px; border-radius: 4px;">
							<strong>Ошибка MySQL:</strong> <?php echo esc_html($test_result['last_error']); ?><br>
							<strong>Последний запрос:</strong> <?php echo esc_html($test_result['last_query']); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<!-- 🛠 КОНЕЦ БЛОКА ДИАГНОСТИКИ -->

		<form method="post" action="options.php">
			<?php settings_fields('artcly_cl_settings_group'); ?>
			<div
				style="background:#ffffff; border:1px solid #ccd0d4; border-radius:8px; padding:20px 24px; margin-bottom:20px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
				<h2
					style="margin-top:0; font-size:16px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
					⚙️ Настройки хранения журнала</h2>
				<table class="form-table" style="margin: 0;">
					<tr>
						<th scope="row" style="width: 250px;">
							<label for="artcly_cl_retention_years">Срок хранения записей (лет)</label>
						</th>
						<td>
							<input name="artcly_cl_retention_years" type="number" id="artcly_cl_retention_years"
								value="<?php echo esc_attr($retention_years); ?>" class="small-text" min="1" max="15" step="1">
							<p class="description" style="margin-top: 8px;">
								Укажите срок хранения в годах. Минимально допустимый срок — <strong>1 год</strong>.
								Текущее активное значение: <strong
									style="color: #2271b1;"><?php echo esc_html($retention_years); ?> г.</strong>
							</p>
						</td>
					</tr>
				</table>
				<?php submit_button('Сохранить настройки', 'primary', 'submit', false); ?>
			</div>
		</form>

		<div
			style="background:#ffffff; border:1px solid #ccd0d4; border-radius:8px; padding:20px 24px; margin-bottom:20px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
			<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
				<div>
					<strong style="font-size:15px;">Всего записей в журнале:</strong>
					<span
						style="font-size:18px; color:#2271b1; font-weight:600;"><?php echo number_format($total, 0, ',', ' '); ?></span>
				</div>
				<a href="<?php echo wp_nonce_url(admin_url('admin.php?artcly_cl_export=forms'), 'artcly_cl_export_action'); ?>"
					class="button button-primary">📥 Экспорт в CSV</a>
			</div>
		</div>

		<?php if ($total_pages > 1): ?>
			<div class="tablenav top" style="margin-bottom: 10px;">
				<div class="tablenav-pages">
					<?php echo paginate_links(array('base' => add_query_arg('paged', '%#%'), 'format' => '', 'current' => $current_page, 'total' => $total_pages, 'prev_text' => '«', 'next_text' => '»')); ?>
				</div>
			</div>
		<?php endif; ?>

		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th width="150">Дата и время</th>
					<th width="130">IP-адрес</th>
					<th>Страница</th>
					<th width="90">Заказ #</th>
					<th width="70">Версия</th>
					<th width="60">ПД</th>
					<th width="60">Заказ</th>
					<th width="60">Реклама</th>
					<th width="60">Оферта</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($logs)): ?>
					<tr>
						<td colspan="10" style="text-align:center; padding:20px;">Записей пока нет</td>
					</tr>
				<?php else: ?>
					<?php foreach ($logs as $log): ?>
						<tr>
							<td><?php echo esc_html($log->id); ?></td>
							<td><?php echo esc_html($log->created_at); ?></td>
							<td><code><?php echo esc_html($log->ip_address); ?></code></td>
							<td>
								<?php if (!empty($log->page_url)): ?>
									<a href="<?php echo esc_url($log->page_url); ?>" target="_blank"
										rel="noopener"><?php echo esc_html(wp_trim_words($log->page_url, 10, '…')); ?></a>
								<?php else: ?>—<?php endif; ?>
							</td>
							<td><strong><?php echo $log->order_id ? esc_html($log->order_id) : '—'; ?></strong></td>
							<td><?php echo esc_html($log->consent_version); ?></td>
							<td><?php echo $log->consent_pd ? '✅' : '—'; ?></td>
							<td><?php echo $log->consent_order ? '✅' : '—'; ?></td>
							<td><?php echo $log->consent_ads ? '✅' : '—'; ?></td>
							<td><?php echo $log->consent_offer ? '✅' : '—'; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<?php if ($total_pages > 1): ?>
			<div class="tablenav bottom" style="margin-top: 10px;">
				<div class="tablenav-pages">
					<?php echo paginate_links(array('base' => add_query_arg('paged', '%#%'), 'format' => '', 'current' => $current_page, 'total' => $total_pages, 'prev_text' => '«', 'next_text' => '»')); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- =========================================================
			  ОБНОВЛЕННЫЙ БЛОК ИНСТРУКЦИЙ
			  ========================================================= -->
		<div style="background:#fff; border:1px solid #ccd0d4; border-radius:8px; padding:20px 24px; margin-top:30px;">
			<h2 style="margin-top:0; font-size:17px; border-bottom:1px solid #eee; padding-bottom:10px;">📋 Краткая инструкция
				по внедрению</h2>
			<p style="font-size:13.5px; line-height:1.6; color:#333; margin-bottom: 20px;">
				Плагин автоматически перехватывает формы, если в них есть поле <code>consent_version</code> и хотя бы одно из
				полей: <code>consent_pd</code>, <code>consent_order</code> или <code>accept_offer</code>.
			</p>

			<!-- 1. Contact Form 7 -->
			<h3 style="font-size:14px; margin:14px 0 6px; color: #d63638;">1. Для Contact Form 7 (Рекомендуемый способ)</h3>
			<p style="font-size:13px; color:#555; margin-bottom: 8px;">Добавьте этот код в шаблон формы в админке CF7:</p>
			<pre
				style="background:#f6f7f7; border:1px solid #dcdcde; padding:12px; border-radius:4px; font-size:12px; overflow:auto; line-height: 1.5;">[acceptance consent_pd class:form-checkbox]
	Я даю <a href="/consent/" target="_blank" rel="noopener">согласие на обработку персональных данных</a>
	[/acceptance]
	[hidden consent_version "1.0"]</pre>

			<!-- 2. Обычные формы -->
			<h3 style="font-size:14px; margin:20px 0 6px; color: #2271b1;">2. Для обычных HTML / AJAX форм (Лендинги, не
				интернет-магазины)</h3>
			<p style="font-size:13px; color:#555; margin-bottom: 8px;">Добавьте чекбокс и скрытое поле внутрь тега
				<code>&lt;form&gt;</code>:</p>
			<pre
				style="background:#f6f7f7; border:1px solid #dcdcde; padding:12px; border-radius:4px; font-size:12px; overflow:auto; line-height: 1.5;">&lt;label class="form-consent"&gt;
		 &lt;input type="checkbox" name="consent_pd" value="1" required&gt;
		 &lt;span&gt;Я даю <a href="/consent/" target="_blank" rel="noopener">согласие на обработку персональных данных</a>&lt;/span&gt;
	&lt;/label&gt;
	&lt;input type="hidden" name="consent_version" value="1.0"&gt;</pre>

			<!-- 3. Интернет-магазины -->
			<h3 style="font-size:14px; margin:20px 0 6px; color: #008a20;">3. Для кастомного чекаута (Интернет-магазины)</h3>
			<p style="font-size:13px; color:#555; margin-bottom: 8px;">Используйте два отдельных согласия (ПД и Оферта):</p>
			<pre
				style="background:#f6f7f7; border:1px solid #dcdcde; padding:12px; border-radius:4px; font-size:12px; overflow:auto; line-height: 1.5;">&lt;label class="form-consent"&gt;
		 &lt;input type="checkbox" name="consent_pd" value="1" required&gt;
		 &lt;span&gt;Я даю <a href="/consent/" target="_blank" rel="noopener">согласие на обработку персональных данных</a> для оформления заказа&lt;/span&gt;
	&lt;/label&gt;
	&lt;label class="form-consent"&gt;
		 &lt;input type="checkbox" name="accept_offer" value="1" required&gt;
		 &lt;span&gt;Я принимаю условия <a href="/oferta/" target="_blank" rel="noopener">публичной оферты</a>&lt;/span&gt;
	&lt;/label&gt;
	&lt;input type="hidden" name="consent_version" value="1.0"&gt;</pre>

			<p
				style="font-size:13px; color:#d63638; margin:20px 0 0; background: #fcf0f1; padding: 12px; border-radius: 4px; border-left: 3px solid #d63638;">
				<strong>⚠️ Важно:</strong> Атрибут <code>checked</code> у чекбоксов <strong>запрещён</strong> законом (согласие
				должно быть осознанным действием пользователя). Поля должны находиться внутри тега <code>&lt;form&gt;</code>
				или явно добавляться в объект <code>FormData</code> при AJAX-отправке.
			</p>
		</div>

		<div
			style="margin-top: 20px; font-size: 13px; color: #888; display:flex; justify-content:space-between; align-items:center; border-top: 1px solid #e0e0e0; padding-top: 15px;">
			<span>Artcly Consent Logger & Validator v<?php echo esc_html(ARTCLY_CL_VERSION); ?>. Соответствует Закону РБ №
				99-З.</span>
			<span>Автор: <a href="https://github.com/max-kot" target="_blank" rel="noopener"
					style="color:#2271b1; text-decoration:none; font-weight:600;">max-kot</a></span>
		</div>
	</div>
	<?php
}