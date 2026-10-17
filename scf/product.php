<?php
acf_add_local_field_group([
	'key' => 'group_product_attributes',
	'title' => 'Атрибуты продукта',
	'fields' => [
		[
			'key' => 'field_product_attributes',
			'label' => 'Список атрибутов',
			'name' => 'product_attributes',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Добавить атрибут',
			'sub_fields' => [
				[
					'key' => 'field_product_attributes_title',
					'label' => 'Название',
					'name' => 'key',
					'type' => 'text'
				],
				[
					'key' => 'field_product_attributes_descr',
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
				'value' => 'product'
			]
		]
	],
]);
?>