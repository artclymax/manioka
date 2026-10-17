<?php
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Секции услуг',
		'menu_title' => 'Секции услуг',
		'menu_slug' => 'opt-single-service',
		'position' => 20,
	));
}
acf_add_local_field_group([
	'key' => 'group_contacts_faq',
	'title' => 'Секция "Контакты + Частые вопросы"',
	'fields' => [
		[
			'key' => 'field_contacts_faq_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_contacts_faq_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'contacts_faq_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_contacts_faq_title',
			'label' => 'Заголовок',
			'name' => 'contacts_faq_title',
			'type' => 'text'
		],
		[
			'key' => 'field_contacts_faq_descr',
			'label' => 'Описание',
			'name' => 'contacts_faq_descr',
			'type' => 'wysiwyg',
		],

		[
			'key' => 'field_contacts_faq_tab_faq',
			'label' => 'FAQ',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_contacts_faq_items',
			'label' => 'Вопросы и ответы',
			'name' => 'contacts_faq_items',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить вопрос',
			'sub_fields' => [
				[
					'key' => 'field_contacts_faq_items_title',
					'label' => 'Вопрос',
					'name' => 'title',
					'type' => 'text'
				],
				[
					'key' => 'field_contacts_faq_items_descr',
					'label' => 'Ответ',
					'name' => 'descr',
					'type' => 'textarea',
					'rows' => 3,
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
		],
		[
			[
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'opt-single-service',
			],
		],
	],
]);
?>