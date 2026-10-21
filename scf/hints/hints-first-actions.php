<?php
acf_add_local_field_group([
	'key' => 'group_hints_first_actions',
	'title' => 'Секция "Первые действия"',
	'fields' => [
		[
			'key' => 'field_hints_first_actions_tab_header',
			'label' => 'Заголовок секции',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_first_actions_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_first_actions_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_first_actions_title',
			'label' => 'Заголовок',
			'name' => 'hints_first_actions_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_first_actions_descr',
			'label' => 'Описание',
			'name' => 'hints_first_actions_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_hints_first_actions_tab_tabs',
			'label' => 'Табы',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_first_actions_tabs',
			'label' => 'Список табов',
			'name' => 'hints_first_actions_tabs',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить таб',
			'sub_fields' => [
				[
					'key' => 'field_hints_first_actions_tabs_title',
					'label' => 'Название таба',
					'name' => 'tab_title',
					'type' => 'text',
					'instructions' => 'Например: Дома, В медицинском учреждении'
				],
				[
					'key' => 'field_hints_first_actions_tabs_left',
					'label' => 'Шаги (левая колонка)',
					'name' => '',
					'type' => 'accordion',
					'open' => false,
				],
				[
					'key' => 'field_hints_first_actions_tabs_steps',
					'label' => 'Шаги (левая колонка)',
					'name' => 'steps',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Добавить шаг',
					'sub_fields' => [
						[
							'key' => 'field_hints_first_actions_tabs_steps_title',
							'label' => 'Заголовок',
							'name' => 'title',
							'type' => 'text'
						],
						[
							'key' => 'field_hints_first_actions_tabs_steps_descr',
							'label' => 'Описание',
							'name' => 'descr',
							'type' => 'textarea',
							'rows' => 2,
							'new_lines' => 'wpautop'
						],
					]
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency',
					'label' => 'Экстренная информация (правая колонка)',
					'name' => '',
					'type' => 'accordion',
					'open' => false,
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_label',
					'label' => 'Верхняя надпись',
					'name' => 'emergency_label',
					'type' => 'text',
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_title',
					'label' => 'Заголовок',
					'name' => 'emergency_title',
					'type' => 'text'
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_descr',
					'label' => 'Описание',
					'name' => 'emergency_descr',
					'type' => 'textarea',
					'rows' => 2,
					'new_lines' => 'wpautop'
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_phone_first_label',
					'label' => 'Надпись над телефоном',
					'name' => 'emergency_phone_first_label',
					'type' => 'text',
					'instructions' => 'Например: Ритуальная помощь 24/7'
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_phone',
					'label' => 'Телефон',
					'name' => 'emergency_phone',
					'type' => 'text'
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_phone_label',
					'label' => 'Подпись под телефоном',
					'name' => 'emergency_phone_label',
					'type' => 'text',
					'instructions' => 'Например: A1 • MTC • life'
				],
				[
					'key' => 'field_hints_first_actions_tabs_emergency_phone_badge',
					'label' => 'Бейдж',
					'name' => 'emergency_phone_badge',
					'type' => 'text',
					'instructions' => 'Например: 24/7'
				],
			]
		],
	],
	'location' => [
		[
			[
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'single-hints-instruction.php'
			]
		]
	],
]);
?>