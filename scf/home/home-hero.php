<?php
acf_add_local_field_group([
	'key' => 'group_home_hero',
	'title' => 'Главный экран',
	'fields' => [
		[
			'key' => 'field_home_hero_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_hero_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'home_hero_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_home_hero_title',
			'label' => 'Заголовок (H1)',
			'name' => 'home_hero_title',
			'type' => 'text'
		],
		[
			'key' => 'field_home_hero_descr',
			'label' => 'Описание',
			'name' => 'home_hero_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_home_hero_btn_primary',
			'label' => 'Кнопка (основная)',
			'name' => 'home_hero_btn_primary',
			'type' => 'link'
		],
		[
			'key' => 'field_home_hero_btn_secondary',
			'label' => 'Кнопка (вторичная)',
			'name' => 'home_hero_btn_secondary',
			'type' => 'link'
		],

		[
			'key' => 'field_home_hero_tab_media',
			'label' => 'Медиа',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_hero_bg',
			'label' => 'Фоновое изображение',
			'name' => 'home_hero_bg',
			'type' => 'image',
		],

		[
			'key' => 'field_home_hero_tab_cities',
			'label' => 'Города',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_home_hero_cities',
			'label' => 'Список городов',
			'name' => 'home_hero_cities',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить город',
			'sub_fields' => [
				[
					'key' => 'field_home_hero_cities_city',
					'label' => 'Город',
					'name' => 'city',
					'type' => 'text'
				],
			]
		],
	],
	'location' => [
		[
			[
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'front-page.php'
			]
		]
	],
]);
?>