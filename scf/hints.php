<?php
acf_add_local_field_group([
	'key' => 'group_hints_post',
	'title' => 'Данные карточки',
	'fields' => [
		[
			'key' => 'field_hints_link_text',
			'label' => 'Ссылка "Читать материал"',
			'name' => 'hints_link_text',
			'type' => 'text',
			'instructions' => 'Текст ссылки для кнопки в карточке',
			'default_value' => 'Читать материал'
		],
	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'hints'
			]
		]
	],
]);
acf_add_local_field_group([
	'key' => 'group_hints_block',
	'title' => 'Секция "Полезная информация"',
	'fields' => [
		[
			'key' => 'field_hints_block_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_block_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_block_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_block_title',
			'label' => 'Заголовок',
			'name' => 'hints_block_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_block_descr',
			'label' => 'Описание',
			'name' => 'hints_block_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_hints_block_btn',
			'label' => 'Кнопка "Все материалы"',
			'name' => 'hints_block_btn',
			'type' => 'link'
		],

		[
			'key' => 'field_hints_block_tab_items',
			'label' => 'Материалы',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_block_selected',
			'label' => 'Выбрать материалы (3 шт.)',
			'name' => 'hints_block_selected',
			'type' => 'post_object',
			'post_type' => ['hints'],
			'return_format' => 'object',
			'multiple' => 1,
			'instructions' => 'Первый элемент в списке будет выведен как (большая карточка)'
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