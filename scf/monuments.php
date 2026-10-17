<?php
acf_add_local_field_group([
	'key' => 'group_monuments_attributes',
	'title' => 'Атрибуты памятника',
	'fields' => [
		[
			'key' => 'field_monuments_attributes',
			'label' => 'Список атрибутов',
			'name' => 'monuments_attributes',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить атрибут',
			'sub_fields' => [
				[
					'key' => 'field_monuments_attributes_key',
					'label' => 'Название',
					'name' => 'key',
					'type' => 'text'
				],
				[
					'key' => 'field_monuments_attributes_value',
					'label' => 'Значение',
					'name' => 'value',
					'type' => 'text'
				],
			]
		]
	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'monuments'
			]
		]
	],
]);
?>