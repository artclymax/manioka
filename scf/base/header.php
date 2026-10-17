<?php
add_action('acf/init', function () {

	if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'page_title' => 'Шапка',
			'menu_title' => 'Шапка',
			'menu_slug' => 'opt-header',
			'position' => 21,
		]);
	}

	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group([
		'key' => 'group_header',
		'title' => 'Шапка сайта',
		'fields' => [
			[
				'key' => 'field_header_info_message',
				'label' => 'Инструкция',
				'name' => '',
				'type' => 'message',
				'message' => '<b>Логотип</b> и <b>меню</b> настраиваются в настройках темы: ' .
					'<a href="' . esc_url(admin_url('admin.php?page=verda-settings&tab=general')) . '" target="_blank" rel="noopener">Логотип</a> · ' .
					'<a href="' . esc_url(admin_url('admin.php?page=verda-settings&tab=menus')) . '" target="_blank" rel="noopener">Меню</a>.<br>' .
					'<b>Телефон, время работы и соцсети</b> берутся из <a href="' . esc_url(admin_url('admin.php?page=opt-contacts')) . '" target="_blank" rel="noopener">Контактных данных</a>.<br>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_header_tab_main',
				'label' => 'Основное',
				'name' => '',
				'type' => 'tab'
			],
			[
				'key' => 'field_header_logo',
				'label' => 'Логотип',
				'name' => 'header_logo',
				'type' => 'image'
			],
			[
				'key' => 'field_header_phone',
				'label' => 'Телефон',
				'name' => 'header_phone',
				'type' => 'text',
				'instructions' => 'Если не заполнен — берётся первый номер из «Контактные данные»'
			],
			[
				'key' => 'field_header_phone_label',
				'label' => 'Подпись под телефоном (операторы)',
				'name' => 'header_phone_label',
				'type' => 'text',
				'instructions' => 'Например: A1 • МТС • life'
			],
			[
				'key' => 'field_header_phone_badge',
				'label' => 'Бейдж (режим работы)',
				'name' => 'header_phone_badge',
				'type' => 'text',
				'instructions' => 'Например: 24/7'
			],
			[
				'key' => 'field_header_btn',
				'label' => 'Кнопка',
				'name' => 'header_btn',
				'type' => 'link'
			],

			[
				'key' => 'field_header_tab_socials',
				'label' => 'Соцсети и города',
				'name' => '',
				'type' => 'tab'
			],
			[
				'key' => 'field_header_socials_text',
				'label' => 'Заголовок блока соцсетей',
				'name' => 'header_socials_text',
				'type' => 'text',
				'instructions' => 'Например: Мы в социальных сетях'
			],
			[
				'key' => 'field_header_cities',
				'label' => 'Города',
				'name' => 'header_cities',
				'type' => 'repeater',
				'layout' => 'table',
				'button_label' => 'Добавить город',
				'sub_fields' => [
					[
						'key' => 'field_header_cities_city',
						'label' => 'Город',
						'name' => 'city',
						'type' => 'text'
					],
				]
			],
		],
		'location' => [
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-header'
				]
			]
		],
	]);

});
