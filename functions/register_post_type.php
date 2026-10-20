<?php

add_action('init', function () {
	register_post_type('project', [
		'labels' => [
			'name' => 'Проекты',
			'singular_name' => 'Проект',
			'menu_name' => 'Проекты',
			'add_new' => 'Добавить проект',
			'add_new_item' => 'Добавить новый проект',
			'edit_item' => 'Редактировать проект',
			'new_item' => 'Новый проект',
			'view_item' => 'Просмотреть проект',
			'search_items' => 'Найти проекты',
			'not_found' => 'Проекты не найдены',
			'not_found_in_trash' => 'В корзине проектов не найдено',
		],
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-images-alt2',
		'supports' => ['title', 'thumbnail'],
		'rewrite' => ['slug' => 'projects'],
		'has_archive' => false,
		'menu_position' => 10,

	]);


});
add_action('init', function () {
	register_post_type('review', [
		'labels' => [
			'name' => 'Отзывы',
			'singular_name' => 'Отзыв',
			'menu_name' => 'Отзывы',
			'add_new' => 'Добавить отзыв',
			'add_new_item' => 'Добавить новый отзыв',
			'edit_item' => 'Редактировать отзыв',
			'new_item' => 'Новый отзыв',
			'view_item' => 'Просмотреть отзыв',
			'search_items' => 'Найти отзывы',
			'not_found' => 'Отзывы не найдены',
			'not_found_in_trash' => 'В корзине отзывов не найдено',
		],
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-format-quote',
		'supports' => ['title', 'editor'],
		'rewrite' => false,
		'has_archive' => false,
		'menu_position' => 10,
	]);
});

add_action('init', function () {
	register_taxonomy('hints_cat', 'hints', [
		'labels' => [
			'name' => 'Категории памятников',
			'singular_name' => 'Категория памятника',
			'menu_name' => 'Категории',
			'search_items' => 'Найти категорию',
			'all_items' => 'Все категории',
			'parent_item' => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'edit_item' => 'Редактировать категорию',
			'update_item' => 'Обновить категорию',
			'add_new_item' => 'Добавить категорию',
			'new_item_name' => 'Новая категория',
		],
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'rewrite' => ['slug' => 'hints'],
	]);
	register_post_type('hints', [
		'labels' => [
			'name' => 'Полезные материалы',
			'singular_name' => 'Материал',
			'menu_name' => 'Полезное',
			'add_new' => 'Добавить материал',
			'add_new_item' => 'Добавить новый материал',
			'edit_item' => 'Редактировать материал',
			'new_item' => 'Новый материал',
			'view_item' => 'Просмотреть материал',
			'search_items' => 'Найти материалы',
			'not_found' => 'Материалы не найдены',
			'not_found_in_trash' => 'В корзине материалов не найдено',
		],
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-book-alt',
		'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
		'rewrite' => ['slug' => 'hints'],
		'has_archive' => 'hints',
		'menu_position' => 10,
		'taxonomies' => ['hints_cat'],
	]);
});

add_action('init', function () {
	// Таксономия категорий услуг
	register_taxonomy('service_cat', 'service', [
		'labels' => [
			'name' => 'Категории услуг',
			'singular_name' => 'Категория услуги',
			'menu_name' => 'Категории',
			'search_items' => 'Найти категорию',
			'all_items' => 'Все категории',
			'parent_item' => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'edit_item' => 'Редактировать категорию',
			'update_item' => 'Обновить категорию',
			'add_new_item' => 'Добавить категорию',
			'new_item_name' => 'Новая категория',
		],
		'hierarchical' => true,
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'rewrite' => false,
	]);

	// CPT услуг
	register_post_type('service', [
		'labels' => [
			'name' => 'Услуги',
			'singular_name' => 'Услуга',
			'menu_name' => 'Услуги',
			'add_new' => 'Добавить услугу',
			'add_new_item' => 'Добавить новую услугу',
			'edit_item' => 'Редактировать услугу',
			'new_item' => 'Новая услуга',
			'view_item' => 'Просмотреть услугу',
			'search_items' => 'Найти услуги',
			'not_found' => 'Услуги не найдены',
			'not_found_in_trash' => 'В корзине услуг не найдено',
		],
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-clipboard',
		'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
		'rewrite' => ['slug' => 'services'],
		'has_archive' => true,
		'taxonomies' => ['service_cat'],
		'menu_position' => 10,
	]);
});

// 1. Добавляем заголовок новой колонки
add_filter('manage_service_posts_columns', function ($columns) {
	$new_columns = [];
	foreach ($columns as $key => $value) {
		$new_columns[$key] = $value;
		// Вставляем колонку "Категория" сразу после заголовка
		if ($key === 'title') {
			$new_columns['service_cat'] = 'Категория';
		}
	}
	return $new_columns;
});

// 2. Выводим содержимое колонки
add_action('manage_service_posts_custom_column', function ($column, $post_id) {
	if ($column === 'service_cat') {
		$terms = get_the_terms($post_id, 'service_cat');

		if ($terms && !is_wp_error($terms)) {
			$links = [];
			foreach ($terms as $term) {
				// Делаем название категории ссылкой на её редактирование для удобства
				$edit_link = get_edit_term_link($term->term_id, 'service_cat', 'service');
				$links[] = '<a href="' . esc_url($edit_link) . '">' . esc_html($term->name) . '</a>';
			}
			echo implode(', ', $links);
		} else {
			echo '<span style="color:#999;">—</span>';
		}
	}
}, 10, 2);

// 3. Делаем колонку визуально сортируемой (заголовок станет кликабельным)
// Примечание: для реальной сортировки записей по таксономии в админке WordPress 
// по умолчанию не имеет встроенного механизма, для этого часто используют плагин "Admin Columns".
add_filter('manage_edit-service_sortable_columns', function ($columns) {
	$columns['service_cat'] = 'service_cat';
	return $columns;
});

add_action('init', function () {
	// Таксономия категорий памятников
	register_taxonomy('monuments_cat', 'monuments', [
		'labels' => [
			'name' => 'Категории памятников',
			'singular_name' => 'Категория памятника',
			'menu_name' => 'Категории',
			'search_items' => 'Найти категорию',
			'all_items' => 'Все категории',
			'parent_item' => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'edit_item' => 'Редактировать категорию',
			'update_item' => 'Обновить категорию',
			'add_new_item' => 'Добавить категорию',
			'new_item_name' => 'Новая категория',
		],
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'rewrite' => ['slug' => 'monuments_cat'],
	]);

	// CPT памятников
	register_post_type('monuments', [
		'labels' => [
			'name' => 'Памятники',
			'singular_name' => 'Памятник',
			'menu_name' => 'Памятники',
			'add_new' => 'Добавить памятник',
			'add_new_item' => 'Добавить новый памятник',
			'edit_item' => 'Редактировать памятник',
			'new_item' => 'Новый памятник',
			'view_item' => 'Просмотреть памятник',
			'search_items' => 'Найти памятники',
			'not_found' => 'Памятники не найдены',
			'not_found_in_trash' => 'В корзине памятников не найдено',
		],
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-marker',
		'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
		'rewrite' => ['slug' => 'monuments'],
		'has_archive' => true,
		'taxonomies' => ['monuments_cat'],
		'menu_position' => 5,
	]);
});