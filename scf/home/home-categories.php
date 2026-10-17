<?php
acf_add_local_field_group([
	'key' => 'group_home_categories',
	'title' => 'Секция "Ритуальные товары"',
	'fields' => [
		[
			'key' => 'field_home_categories_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_categories_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'home_categories_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_home_categories_title',
			'label' => 'Заголовок',
			'name' => 'home_categories_title',
			'type' => 'text'
		],
		[
			'key' => 'field_home_categories_descr',
			'label' => 'Описание',
			'name' => 'home_categories_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_home_categories_btn',
			'label' => 'Кнопка "Перейти в каталог"',
			'name' => 'home_categories_btn',
			'type' => 'link'
		],

		[
			'key' => 'field_home_categories_tab_settings',
			'label' => 'Настройки вывода',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_categories_selected',
			'label' => 'Категории для вывода',
			'name' => 'home_categories_selected',
			'type' => 'taxonomy',
			'taxonomy' => 'product_cat',
			'field_type' => 'multi_select',
			'add_term' => 0,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'object',
			'instructions' => 'Если ничего не выбрано — выводятся 6 последних категорий по количеству товаров'
		],
	],
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'front-page.php'
			]
		]
	],
]);
?>