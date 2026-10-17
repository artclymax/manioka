<?php
acf_add_local_field_group([
	'key' => 'group_project_gallery',
	'title' => 'Секция "Примеры выполненных работ"',
	'fields' => [
		[
			'key' => 'field_project_gallery_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_project_gallery_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'project_gallery_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_project_gallery_title',
			'label' => 'Заголовок',
			'name' => 'project_gallery_title',
			'type' => 'text'
		],
		[
			'key' => 'field_project_gallery_descr',
			'label' => 'Описание',
			'name' => 'project_gallery_descr',
			'type' => 'wysiwyg',
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