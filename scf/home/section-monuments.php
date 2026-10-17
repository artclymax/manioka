<?php
acf_add_local_field_group([
	'key' => 'group_monuments',
	'title' => 'Секция "Памятники и благоустройство"',
	'fields' => [
		[
			'key' => 'field_monuments_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_monuments_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'monuments_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_monuments_title',
			'label' => 'Заголовок',
			'name' => 'monuments_title',
			'type' => 'text'
		],
		[
			'key' => 'field_monuments_descr',
			'label' => 'Описание',
			'name' => 'monuments_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_monuments_btn',
			'label' => 'Кнопка',
			'name' => 'monuments_btn',
			'type' => 'link'
		],

		[
			'key' => 'field_monuments_tab_media',
			'label' => 'Медиа',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_monuments_image',
			'label' => 'Изображение',
			'name' => 'monuments_image',
			'type' => 'image',
		],

		[
			'key' => 'field_monuments_tab_steps',
			'label' => 'Этапы',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_monuments_steps',
			'label' => 'Список этапов',
			'name' => 'monuments_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить этап',
			'sub_fields' => [
				[
					'key' => 'field_monuments_steps_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_monuments_steps_descr',
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