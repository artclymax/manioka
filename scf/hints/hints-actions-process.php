<?php
acf_add_local_field_group([
	'key' => 'group_hint_actions_process',
	'title' => 'Секция "Первые действия"',
	'fields' => [
		[
			'key' => 'field_hint_actions_process_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hint_actions_process_label',
			'label' => 'Верхняя надпись',
			'name' => 'hint_actions_process_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hint_actions_process_title',
			'label' => 'Заголовок',
			'name' => 'hint_actions_process_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hint_actions_process_descr',
			'label' => 'Описание',
			'name' => 'hint_actions_process_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_hint_actions_process_tab_steps',
			'label' => 'Шаги',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hint_actions_process_steps',
			'label' => 'Список шагов',
			'name' => 'hint_actions_process_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить шаг',
			'sub_fields' => [
				[
					'key' => 'field_hint_actions_process_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_hint_actions_process_steps_descr',
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