<?php
acf_add_local_field_group([
	'key' => 'group_hints_instruction_cta',
	'title' => 'Секция "CTA: Нужна помощь"',
	'fields' => [
		[
			'key' => 'field_hints_cta_title',
			'label' => 'Заголовок',
			'name' => 'hints_cta_title',
			'type' => 'text',
		],
		[
			'key' => 'field_hints_cta_descr',
			'label' => 'Описание',
			'name' => 'hints_cta_descr',
			'type' => 'wysiwyg',
		],
		[
			'key' => 'field_hints_cta_phone',
			'label' => 'Телефон',
			'name' => 'hints_cta_phone',
			'type' => 'text',
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