<?php
acf_add_local_field_group([
	'key' => 'group_approach',
	'title' => 'Секция "Индивидуальный подход"',
	'fields' => [
		[
			'key' => 'field_approach_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_approach_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'approach_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_approach_title',
			'label' => 'Заголовок',
			'name' => 'approach_title',
			'type' => 'text'
		],
		[
			'key' => 'field_approach_descr',
			'label' => 'Описание',
			'name' => 'approach_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_approach_tab_steps',
			'label' => 'Шаги',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_approach_steps',
			'label' => 'Список шагов',
			'name' => 'approach_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить шаг',
			'sub_fields' => [
				[
					'key' => 'field_approach_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_approach_steps_descr',
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
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'archive-service.php'
			]
		]
	],
]);
?>