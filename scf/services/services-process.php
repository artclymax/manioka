<?php
acf_add_local_field_group([
	'key' => 'group_services_process',
	'title' => 'Секция "Как проходит организация"',
	'fields' => [
		[
			'key' => 'field_services_process_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_services_process_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'services_process_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_services_process_title',
			'label' => 'Заголовок',
			'name' => 'services_process_title',
			'type' => 'text'
		],
		[
			'key' => 'field_services_process_descr',
			'label' => 'Описание',
			'name' => 'services_process_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_services_process_tab_steps',
			'label' => 'Этапы',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_services_process_steps',
			'label' => 'Список этапов',
			'name' => 'services_process_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить этап',
			'sub_fields' => [
				[
					'key' => 'field_services_process_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_services_process_steps_descr',
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
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'service'
			]
		]
	],
]);
?>