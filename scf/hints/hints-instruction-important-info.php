<?php
acf_add_local_field_group([
	'key' => 'group_hints_important_info',
	'title' => 'Секция "Чего не следует делать"',
	'fields' => [
		[
			'key' => 'field_hints_important_info_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_important_info_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_important_info_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_important_info_title',
			'label' => 'Заголовок',
			'name' => 'hints_important_info_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_important_info_descr',
			'label' => 'Описание',
			'name' => 'hints_important_info_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_hints_important_info_tab_steps',
			'label' => 'Шаги',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_important_info_steps',
			'label' => 'Список шагов',
			'name' => 'hints_important_info_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить шаг',
			'sub_fields' => [
				[
					'key' => 'field_hints_important_info_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_hints_important_info_steps_descr',
					'label' => 'Описание',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 2,
					'new_lines' => 'wpautop'
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