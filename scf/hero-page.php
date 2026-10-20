<?php
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_hero_page',
		'title' => 'Первый экран',
		'fields' => [
			[
				'key' => 'field_hero_page_tab_content',
				'label' => 'Контент',
				'name' => 'hero_tab_content',
				'type' => 'tab',
			],
			[
				'key' => 'field_hero_page_label',
				'label' => 'Надзаголовок',
				'name' => 'hero_label',
				'type' => 'text',
			],
			[
				'key' => 'field_hero_page_title',
				'label' => 'Заголовок',
				'name' => 'hero_title',
				'type' => 'text',
			],
			[
				'key' => 'field_hero_page_descr',
				'label' => 'Описание',
				'name' => 'hero_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_hero_page_tab_image',
				'label' => 'Медиа',
				'name' => 'hero_tab_image',
				'type' => 'tab',
			],
			[
				'key' => 'field_hero_image',
				'label' => 'Изображение',
				'name' => 'hero_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				],
				[
					'param' => 'post_template',
					'operator' => '!=',
					'value' => 'front-page.php',
				],
				[
					'param' => 'post_template',
					'operator' => '!=',
					'value' => 'archive-hints.php',
				],

				//[
				//	'param' => 'post_template',
				//	'operator' => '=',
				//	'value' => 'archive-project.php',
				//],
			],
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-single-service',
				],
			],
		],
	]);
}

acf_add_local_field_group([
	'key' => 'group_hero_page_hints',
	'title' => 'Hero секция страницы',
	'fields' => [
		[
			'key' => 'field_hero_label',
			'label' => 'Верхняя надпись',
			'name' => 'hero_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hero_title',
			'label' => 'Заголовок',
			'name' => 'hero_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hero_featured_posts',
			'label' => 'Закреплённые записи',
			'name' => 'hero_featured_posts',
			'type' => 'post_object',
			'post_type' => ['hints'],
			'return_format' => 'object',
			'multiple' => 1,
			'instructions' => 'Выберите 1-3 записи из  для вывода в правой части главного баннера',
		],
	],
	'location' => [
		[
			[
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'archive-hints.php',
			]
		]
	],
]);
?>