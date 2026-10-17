<?php
add_action('acf/init', function () {

	if (function_exists('acf_add_options_page')) {
		acf_add_options_page(array(
			'page_title' => 'Контактные данные',
			'menu_title' => 'Контактные данные',
			'menu_slug' => 'opt-contacts',
			'position' => 20,
		));
	}

	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	// CONTACTS - OPTIONS PAGE
	acf_add_local_field_group([
		'key' => 'group_contacts_page',
		'title' => 'Контактные данные',
		'fields' => [
			[
				'key' => 'field_contacts_tab_page',
				'label' => 'Страница контактов',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_contacts_block_top_label',
				'label' => 'Верхняя надпись (для секции)',
				'name' => 'contacts_block_top_label',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_block_title',
				'label' => 'Заголовок',
				'name' => 'contacts_block_title',
				'type' => 'text'
			],
			[
				'key' => 'field_contacts_block_descr',
				'label' => 'Описание',
				'name' => 'contacts_block_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_contacts_block_phone_label',
				'label' => 'Подпись под телефоном (операторы)',
				'name' => 'contacts_block_phone_label',
				'type' => 'text',
				'instructions' => 'Например: A1 • MTC • life'
			],
			[
				'key' => 'field_contacts_block_phone_badge',
				'label' => 'Бейдж (режим работы)',
				'name' => 'contacts_block_phone_badge',
				'type' => 'text',
				'instructions' => 'Например: 24/7'
			],
			[
				'key' => 'field_contacts_tab_phones',
				'label' => 'Телефон',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_contacts_phones',
				'label' => 'Телефоны',
				'name' => 'contacts_phones',
				'type' => 'repeater',
				'layout' => 'table',
				'collapsed' => 'field_contact_phone_number',
				'button_label' => 'Добавить телефон',
				'sub_fields' => [
					[
						'key' => 'field_contact_phone_number',
						'label' => 'Номер телефона',
						'name' => 'phone',
						'type' => 'text',
					],
				],
			],
			//[
			//	'key' => 'field_contacts_tab_email',
			//	'label' => 'Email',
			//	'name' => '',
			//	'type' => 'tab',
			//	'placement' => 'top',
			//	'endpoint' => 0,
			//],
			//[
			//	'key' => 'field_contacts_emails',
			//	'label' => 'Email адреса',
			//	'name' => 'contacts_emails',
			//	'type' => 'repeater',
			//	'layout' => 'block',
			//	'collapsed' => 'field_contact_email_link',
			//	'button_label' => 'Добавить email',
			//	'sub_fields' => [
			//		[
			//			'key' => 'field_contact_email_link',
			//			'label' => 'Email',
			//			'name' => 'email',
			//			'type' => 'email',
			//		],
			//	],
			//],
			[
				'key' => 'field_contacts_tab_address_time',
				'label' => 'Адрес',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_contacts_address',
				'label' => 'Адрес',
				'name' => 'contacts_address',
				'type' => 'wysiwyg',
			],
			//[
			//	'key' => 'field_contacts_time',
			//	'label' => 'Время работы',
			//	'name' => 'contacts_time',
			//	'type' => 'wysiwyg',
			//],
			[
				'key' => 'field_of_tab_map',
				'label' => 'Карта',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_contacts_map',
				'label' => 'Код карты (iframe)',
				'name' => 'contacts_map',
				'type' => 'textarea',
				'rows' => 6,
				'new_lines' => '',
				'instructions' => 'Вставьте iframe из виджета Яндекс.Карт или Google Maps.',
			],
			[
				'key' => 'field_contacts_tab_socials',
				'label' => 'Соцсети',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_contacts_socials',
				'label' => 'Социальные сети',
				'name' => 'contacts_socials',
				'type' => 'repeater',
				'layout' => 'table',
				'collapsed' => 'field_contacts_social_title',
				'button_label' => 'Добавить соцсеть',
				'sub_fields' => [
					[
						'key' => 'field_contacts_social_image',
						'label' => 'Иконка',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_contacts_social_link',
						'label' => 'Ссылка на соцсеть',
						'name' => 'link',
						'type' => 'link',
					],
				],
			],
			//[
			//	'key' => 'field_pg_contacts_tab_legal',
			//	'label' => 'Реквизиты',
			//	'name' => '',
			//	'type' => 'tab',
			//	'placement' => 'top',
			//	'endpoint' => 0,
			//],
			//[
			//	'key' => 'field_contacts_payment',
			//	'label' => 'Реквизиты',
			//	'name' => 'contacts_payment',
			//	'type' => 'wysiwyg',
			//],
		],
		'location' => [
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-contacts',
				],
			],
		],
	]);


});