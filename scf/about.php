<?php
acf_add_local_field_group([
	'key' => 'group_about_description',
	'title' => 'Секция "Описание о компании"',
	'fields' => [
		[
			'key' => 'field_about_descr_title',
			'label' => 'Заголовок',
			'name' => 'about_descr_title',
			'type' => 'textarea',
			'rows' => 3,
			'new_lines' => 'wpautop',
		],
		[
			'key' => 'field_about_descr_descr',
			'label' => 'Описание',
			'name' => 'about_descr_descr',
			'type' => 'wysiwyg',
		],
	],
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-about.php'
			]
		]
	],
]);
?>