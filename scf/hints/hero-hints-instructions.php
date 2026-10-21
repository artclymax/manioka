<?php
acf_add_local_field_group([
	'key' => 'group_hero_hints_instruction',
	'title' => 'Первый экран',
	'fields' => [
		[
			'key' => 'field_hero_hints_instruction_tab_left',
			'label' => 'Левая колонка',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hero_hints_instruction_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_instruction_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hero_hints_instruction_title',
			'label' => 'Заголовок',
			'name' => 'hints_instruction_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hero_hints_instruction_descr',
			'label' => 'Описание',
			'name' => 'hints_instruction_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_hero_hints_instruction_btn_call',
			'label' => 'Кнопка "Позвонить"',
			'name' => 'hints_instruction_btn_call',
			'type' => 'link',
			'instructions' => 'URL можно оставить пустым — телефон возьмётся из контактов'
		],
		[
			'key' => 'field_hero_hints_instruction_btn_instruction',
			'label' => 'Кнопка "Перейти к инструкции"',
			'name' => 'hints_instruction_btn_instruction',
			'type' => 'link'
		],

		[
			'key' => 'field_hero_hints_instruction_tab_right',
			'label' => 'Правая колонка (Экстренные номера)',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hero_hints_emergency_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_emergency_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hero_hints_emergency_title',
			'label' => 'Заголовок',
			'name' => 'hints_emergency_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hero_hints_emergency_descr',
			'label' => 'Описание',
			'name' => 'hints_emergency_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_hero_hints_emergency_numbers',
			'label' => 'Экстренные номера',
			'name' => 'hints_emergency_numbers',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить номер',
			'sub_fields' => [
				[
					'key' => 'field_hero_hints_emergency_numbers_number',
					'label' => 'Номер',
					'name' => 'number',
					'type' => 'text',
				],
				[
					'key' => 'field_hero_hints_emergency_numbers_label',
					'label' => 'Подпись',
					'name' => 'label',
					'type' => 'text',
				],
			]
		],
		[
			'key' => 'field_hero_hints_emergency_note',
			'label' => 'Примечание',
			'name' => 'hints_emergency_note',
			'type' => 'textarea',
			'rows' => 2,
			'new_lines' => 'wpautop',
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