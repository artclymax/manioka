<?php
acf_add_local_field_group([
	'key' => 'group_hints',
	'title' => 'Секция "Что делать, если умер близкий"',
	'fields' => [
		[
			'key' => 'field_hints_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_title',
			'label' => 'Заголовок',
			'name' => 'hints_title',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_descr',
			'label' => 'Описание',
			'name' => 'hints_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_hints_btn',
			'label' => 'Кнопка',
			'name' => 'hints_btn',
			'type' => 'link'
		],

		[
			'key' => 'field_hints_tab_steps',
			'label' => 'Шаги',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_steps',
			'label' => 'Список шагов',
			'name' => 'hints_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить шаг',
			'sub_fields' => [
				[
					'key' => 'field_hints_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_hints_steps_descr',
					'label' => 'Описание',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 2,
					'new_lines' => 'wpautop'
				],
			]
		],

		[
			'key' => 'field_hints_tab_banner',
			'label' => 'Нижний баннер',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_banner_title',
			'label' => 'Заголовок баннера',
			'name' => 'hints_banner_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_banner_descr',
			'label' => 'Описание баннера',
			'name' => 'hints_banner_descr',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_phone',
			'label' => 'Телефон',
			'name' => 'hints_phone',
			'type' => 'text',
			'instructions' => 'Если не заполнен — берётся первый номер из «Контактные данные»'
		],
		[
			'key' => 'field_hints_phone_label',
			'label' => 'Подпись под телефоном (операторы)',
			'name' => 'hints_phone_label',
			'type' => 'text',
			'instructions' => 'Например: A1 • МТС • life'
		],
		[
			'key' => 'field_hints_phone_badge',
			'label' => 'Бейдж (режим работы)',
			'name' => 'hints_phone_badge',
			'type' => 'text',
			'instructions' => 'Например: 24/7'
		],
	],
	'location' => [
		[
			[
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'front-page.php',
			]
		]
	],
]);
?>