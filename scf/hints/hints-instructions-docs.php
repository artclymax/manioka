<?php
acf_add_local_field_group([
	'key' => 'group_hints_instructions_docs',
	'title' => 'Секция "Какие документы понадобятся"',
	'fields' => [
		[
			'key' => 'field_hints_docs_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_docs_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'hints_docs_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_docs_title',
			'label' => 'Заголовок',
			'name' => 'hints_docs_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_docs_descr',
			'label' => 'Описание',
			'name' => 'hints_docs_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_hints_docs_tab_lists_first',
			'label' => 'Первая колонка',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_docs_prepare_title',
			'label' => 'Заголовок',
			'name' => 'hints_docs_prepare_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_docs_prepare',
			'label' => 'Список',
			'name' => 'hints_docs_prepare',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить документ',
			'sub_fields' => [
				[
					'key' => 'field_hints_docs_prepare_text',
					'label' => 'Текст',
					'name' => 'text',
					'type' => 'text'
				],
			]
		],
		[
			'key' => 'field_hints_docs_tab_lists_second',
			'label' => 'Вторая колонка',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_hints_docs_process_title',
			'label' => 'Заголовок',
			'name' => 'hints_docs_process_title',
			'type' => 'text'
		],
		[
			'key' => 'field_hints_docs_process',
			'label' => 'Будут оформлены в процессе',
			'name' => 'hints_docs_process',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить документ',
			'sub_fields' => [
				[
					'key' => 'field_hints_docs_process_text',
					'label' => 'Текст',
					'name' => 'text',
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
				'value' => 'single-hints-instruction.php'
			]
		]
	],
]);
?>