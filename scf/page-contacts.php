<?php
acf_add_local_field_group([
	'key' => 'group_page_contacts',
	'title' => 'Страница контактов',
	'fields' => [
		[
			'key' => 'field_contacts_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'contacts_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_contacts_title',
			'label' => 'Заголовок',
			'name' => 'contacts_title',
			'type' => 'text'
		],
		[
			'key' => 'field_contacts_descr',
			'label' => 'Описание',
			'name' => 'contacts_descr',
			'type' => 'wysiwyg',
		],
	],
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-contacts.php'
			]
		]
	],
]);
?>