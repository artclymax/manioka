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

//if (function_exists('acf_add_local_field_group')) {
//	acf_add_local_field_group([
//		'key' => 'group_product_cat_hero',
//		'title' => 'Первый экран категории',
//		'fields' => [
//			[
//				'key' => 'field_product_cat_hero_accordion',
//				'label' => 'Первый экран категории',
//				'name' => 'product_cat_hero_accordion',
//				'type' => 'accordion',
//			],
//			[
//				'key' => 'field_product_cat_hero_tab_content',
//				'label' => 'Контент',
//				'name' => '',
//				'type' => 'tab',
//				'placement' => 'top',
//				'endpoint' => 0,
//			],
//			[
//				'key' => 'field_product_cat_hero_title',
//				'label' => 'Заголовок',
//				'name' => 'hero_title',
//				'type' => 'text',
//				'instructions' => 'Если пусто, будет использовано название категории',
//			],
//			[
//				'key' => 'field_product_cat_hero_descr',
//				'label' => 'Описание',
//				'name' => 'hero_descr',
//				'type' => 'wysiwyg',
//			],
//			[
//				'key' => 'field_product_cat_hero_tab_media',
//				'label' => 'Медиа',
//				'name' => '',
//				'type' => 'tab',
//				'placement' => 'top',
//				'endpoint' => 0,
//			],
//			[
//				'key' => 'field_product_cat_hero_image',
//				'label' => 'Фоновое изображение',
//				'name' => 'hero_image',
//				'type' => 'image',
//			],
//		],
//		'location' => [
//			[
//				[
//					'param' => 'taxonomy',
//					'operator' => '==',
//					'value' => 'product_cat',
//				],
//			],
//		],
//		'menu_order' => 1,
//	]);
//}

