<?php
add_action('wp_ajax_load_more_products', 'load_more_products_callback');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products_callback');

function load_more_products_callback()
{
	// Проверка nonce
	if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'products_load_more_nonce')) {
		wp_send_json_error(array('message' => 'Invalid nonce'));
	}

	$page = isset($_POST['page']) ? intval($_POST['page']) : 2;
	$posts_per_page = get_option('posts_per_page', 10);

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $posts_per_page,
		'paged' => $page,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC',
	);

	// Если передана таксономия
	if (!empty($_POST['taxonomy']) && !empty($_POST['term_id'])) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => sanitize_text_field($_POST['taxonomy']),
				'field' => 'term_id',
				'terms' => intval($_POST['term_id']),
			),
		);
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		ob_start();

		while ($query->have_posts()) {
			$query->the_post();

			// КРИТИЧЕСКИ ВАЖНО: принудительно обновляем глобальный объект товара
			global $product;
			$product = wc_get_product($query->post->ID);

			get_template_part('partials/product-card', null, array('product' => $product));
		}

		$html = ob_get_clean();
		wp_reset_postdata();

		$has_more = ($page < $query->max_num_pages);

		wp_send_json_success(array(
			'html' => $html,
			'has_more' => $has_more,
			'next_page' => $page + 1
		));
	} else {
		wp_send_json_error(array('message' => 'No products found'));
	}
}
?>