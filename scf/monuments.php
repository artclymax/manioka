<?php
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Общие секции памятников',
		'menu_title' => 'Общие секции памятников',
		'menu_slug' => 'opt-single-monuments',
		'position' => 20,
	));
}
acf_add_local_field_group([
	'key' => 'group_monuments_attributes',
	'title' => 'Атрибуты памятника',
	'fields' => [
		[
			'key' => 'field_monuments_attributes',
			'label' => 'Список атрибутов',
			'name' => 'monuments_attributes',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить атрибут',
			'sub_fields' => [
				[
					'key' => 'field_monuments_attributes_key',
					'label' => 'Название',
					'name' => 'key',
					'type' => 'text'
				],
				[
					'key' => 'field_monuments_attributes_value',
					'label' => 'Значение',
					'name' => 'value',
					'type' => 'text'
				],
			]
		]
	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'monuments'
			]
		]
	],
]);

acf_add_local_field_group([
	'key' => 'group_monuments_services',
	'title' => 'Секция "Услуги памятники"',
	'fields' => [
		[
			'key' => 'field_monuments_services_tab_cards',
			'label' => 'Карточки',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_monuments_services_cards',
			'label' => 'Карточки услуг',
			'name' => 'monuments_services_cards',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить карточку',
			'sub_fields' => [
				[
					'key' => 'field_monuments_services_cards_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_monuments_services_cards_descr',
					'label' => 'Описание',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 3,
					'new_lines' => 'wpautop'
				],
				[
					'key' => 'field_monuments_services_cards_image',
					'label' => 'Изображение (опционально)',
					'name' => 'image',
					'type' => 'image',
					'instructions' => 'Если не загружено — карточка будет с белым фоном'
				],
				[
					'key' => 'field_monuments_services_cards_is_dark',
					'label' => 'Белый текст у карточки',
					'name' => 'is_dark',
					'type' => 'true_false',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Да',
					'ui_off_text' => 'Нет',
				],
				[
					'key' => 'field_monuments_services_cards_link',
					'label' => 'Ссылка',
					'name' => 'link',
					'type' => 'link',
				],
			]
		],
	],
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'archive-monuments.php'
			]
		]
	],
]);

acf_add_local_field_group([
	'key' => 'group_monuments_gallery',
	'title' => 'Галерея памятника',
	'fields' => [
		[
			'key' => 'field_monuments_gallery',
			'label' => 'Галерея',
			'name' => 'monuments_gallery',
			'type' => 'gallery',
			'return_format' => 'id',
		],

	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'monuments'
			]
		]
	],
]);

acf_add_local_field_group([
	'key' => 'group_monuments_design',
	'title' => 'Секция "Индивидуальное оформление"',
	'fields' => [
		[
			'key' => 'field_monuments_design_message',
			'label' => 'Инструкция',
			'type' => 'message',
			'message' => 'По умолчанию будет брать данные из <b>Общие секции памятников > Секция "Индивидуальное оформление" </b>'
		],
		[
			'key' => 'field_monuments_design_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_monuments_design_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'monuments_design_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_monuments_design_title',
			'label' => 'Заголовок',
			'name' => 'monuments_design_title',
			'type' => 'text'
		],

		[
			'key' => 'field_monuments_design_tab_cards',
			'label' => 'Карточки',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_monuments_design_cards',
			'label' => 'Карточки услуг',
			'name' => 'monuments_design_cards',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить карточку',
			'sub_fields' => [
				[
					'key' => 'field_monuments_design_cards_image',
					'label' => 'Изображение',
					'name' => 'image',
					'type' => 'image',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all'
				],
				[
					'key' => 'field_monuments_design_cards_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_monuments_design_cards_descr',
					'label' => 'Описание',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 3,
					'new_lines' => 'wpautop'
				],
			]
		],
	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'monuments'
			]
		],
		[
			[
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'opt-single-monuments'
			]
		]
	],
]);
acf_add_local_field_group([
	'key' => 'group_monuments_kit',
	'title' => 'Секция "Что можно включить в комплект"',
	'fields' => [
		[
			'key' => 'field_monuments_kit_title',
			'label' => 'Заголовок',
			'name' => 'monuments_kit_title',
			'type' => 'text'
		],
		[
			'key' => 'field_monuments_kit_items',
			'label' => 'Список элементов',
			'name' => 'monuments_kit_items',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить элемент',
			'sub_fields' => [
				[
					'key' => 'field_monuments_kit_items_link',
					'label' => 'Ссылка (опционально)',
					'name' => 'link',
					'type' => 'link',
				],
				[
					'key' => 'field_monuments_kit_items_text',
					'label' => 'Текст (если нет ссылки)',
					'name' => 'text',
					'type' => 'text',
				],
			]
		],
	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'monuments'
			]
		],
		[
			[
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'opt-single-monuments'
			]
		]
	]
]);
?>