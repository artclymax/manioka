<?php
acf_add_local_field_group([
	'key' => 'group_home_services',
	'title' => 'Секция "Основные направления"',
	'fields' => [
		[
			'key' => 'field_home_services_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_services_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'home_services_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_home_services_title',
			'label' => 'Заголовок',
			'name' => 'home_services_title',
			'type' => 'text',
		],
		[
			'key' => 'field_home_services_descr',
			'label' => 'Описание',
			'name' => 'home_services_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_home_services_tab_cards',
			'label' => 'Карточки',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_services_cards',
			'label' => 'Список карточек',
			'name' => 'home_services_cards',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить карточку',
			'sub_fields' => [
				[
					'key' => 'field_home_services_cards_title',
					'label' => 'Заголовок',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_home_services_cards_descr',
					'label' => 'Описание',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 3,
					'new_lines' => 'wpautop'
				],
				[
					'key' => 'field_home_services_cards_link',
					'label' => 'Ссылка',
					'name' => 'link',
					'type' => 'link',
					'instructions' => 'Текст ссылки будет использован как подпись кнопки (например: "Подробнее")'
				],
				[
					'key' => 'field_home_services_cards_image',
					'label' => 'Изображение (опционально)',
					'name' => 'image',
					'type' => 'image',
				],
				[
					'key' => 'field_home_services_cards_style',
					'label' => 'Стиль карточки',
					'name' => 'style',
					'type' => 'select',
					'choices' => [
						'light' => 'Светлый',
						'dark' => 'Тёмный (с затемнением изображения)',
					],
					'default_value' => 'light'
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