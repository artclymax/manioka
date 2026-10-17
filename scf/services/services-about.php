<?php
acf_add_local_field_group([
	'key' => 'group_services_about',
	'title' => 'Секция "Состав услуги"',
	'fields' => [
		[
			'key' => 'field_services_about_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_services_about_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'services_about_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_services_about_title',
			'label' => 'Заголовок',
			'name' => 'services_about_title',
			'type' => 'text'
		],
		[
			'key' => 'field_services_about_descr',
			'label' => 'Описание',
			'name' => 'services_about_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_services_about_tab_steps',
			'label' => 'Этапы',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_services_about_steps',
			'label' => 'Список этапов',
			'name' => 'services_about_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить этап',
			'sub_fields' => [
				[
					'key' => 'field_services_about_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_services_about_steps_descr',
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