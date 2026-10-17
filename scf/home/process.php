<?php
acf_add_local_field_group([
	'key' => 'group_process',
	'title' => 'Секция "Организация похорон"',
	'fields' => [
		[
			'key' => 'field_process_tab_left',
			'label' => 'Левая колонка',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_process_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'process_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_process_title',
			'label' => 'Заголовок',
			'name' => 'process_title',
			'type' => 'text'
		],
		[
			'key' => 'field_process_descr',
			'label' => 'Описание',
			'name' => 'process_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_process_subtitle',
			'label' => 'Подзаголовок (преимущество)',
			'name' => 'process_subtitle',
			'type' => 'text',
			'instructions' => 'Например: Один распорядитель на всех этапах'
		],
		[
			'key' => 'field_process_subtitle_descr',
			'label' => 'Описание преимущества',
			'name' => 'process_subtitle_descr',
			'type' => 'textarea',
			'rows' => 2,
			'new_lines' => 'wpautop'
		],
		[
			'key' => 'field_process_btn',
			'label' => 'Кнопка',
			'name' => 'process_btn',
			'type' => 'link'
		],
		[
			'key' => 'field_process_phone_label',
			'label' => 'Подпись телефона',
			'name' => 'process_phone_label',
			'type' => 'text',
			'instructions' => 'Например: Круглосуточно'
		],
		[
			'key' => 'field_process_phone',
			'label' => 'Телефон',
			'name' => 'process_phone',
			'type' => 'text',
			'instructions' => 'Если не заполнен — берётся из «Контактные данные»'
		],

		[
			'key' => 'field_process_tab_right',
			'label' => 'Правая колонка',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_process_right_title',
			'label' => 'Заголовок правой колонки',
			'name' => 'process_right_title',
			'type' => 'text'
		],
		[
			'key' => 'field_process_steps',
			'label' => 'Шаги',
			'name' => 'process_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить шаг',
			'sub_fields' => [
				[
					'key' => 'field_process_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_process_steps_descr',
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
				'value' => 'front-page.php'
			]
		]
	],
]);
?>