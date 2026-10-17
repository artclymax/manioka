<?php
acf_add_local_field_group([
	'key' => 'group_why_us',
	'title' => 'Секция "Почему нам доверяют"',
	'fields' => [
		[
			'key' => 'field_why_us_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_why_us_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'why_us_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_why_us_title',
			'label' => 'Заголовок',
			'name' => 'why_us_title',
			'type' => 'text'
		],
		[
			'key' => 'field_why_us_descr',
			'label' => 'Описание',
			'name' => 'why_us_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_why_us_tab_advantages',
			'label' => 'Преимущества',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_why_us_advantages',
			'label' => 'Список преимуществ',
			'name' => 'why_us_advantages',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить преимущество',
			'sub_fields' => [
				[
					'key' => 'field_why_us_advantages_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_why_us_advantages_descr',
					'label' => 'Описание',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 2,
					'new_lines' => 'wpautop'
				],
			]
		],

		[
			'key' => 'field_why_us_tab_banner',
			'label' => 'Нижняя панель',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_why_us_cities',
			'label' => 'Города выезда',
			'name' => 'why_us_cities',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить город',
			'sub_fields' => [
				[
					'key' => 'field_why_us_cities_city',
					'label' => 'Город',
					'name' => 'city',
					'type' => 'text'
				],
			]
		],
		[
			'key' => 'field_why_us_phone',
			'label' => 'Телефон',
			'name' => 'why_us_phone',
			'type' => 'text',
			'instructions' => 'Если не заполнен — берётся из «Контактные данные»'
		],
		[
			'key' => 'field_why_us_phone_label',
			'label' => 'Подпись под телефоном (операторы)',
			'name' => 'why_us_phone_label',
			'type' => 'text',
			'instructions' => 'Например: A1 • МТС • life'
		],
		[
			'key' => 'field_why_us_phone_badge',
			'label' => 'Бейдж (режим работы)',
			'name' => 'why_us_phone_badge',
			'type' => 'text',
			'instructions' => 'Например: 24/7'
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