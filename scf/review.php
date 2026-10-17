<?php
acf_add_local_field_group([
	'key' => 'group_review',
	'title' => 'Отзыв',
	'fields' => [
		[
			'key' => 'field_review_city',
			'label' => 'Город',
			'name' => 'review_city',
			'type' => 'text'
		],
		[
			'key' => 'field_review_date',
			'label' => 'Дата',
			'name' => 'review_date',
			'type' => 'text',
			'instructions' => 'Например: 12.03.2024'
		],
	],
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'review'
			]
		]
	],
]);
acf_add_local_field_group([
	'key' => 'group_reviews',
	'title' => 'Секция "Отзывы"',
	'fields' => [
		[
			'key' => 'field_reviews_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab'
		],
		[
			'key' => 'field_reviews_top_label',
			'label' => 'Верхняя надпись',
			'name' => 'reviews_top_label',
			'type' => 'text',
		],
		[
			'key' => 'field_reviews_title',
			'label' => 'Заголовок',
			'name' => 'reviews_title',
			'type' => 'text'
		],
		[
			'key' => 'field_reviews_descr',
			'label' => 'Описание',
			'name' => 'reviews_descr',
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