<?php
$page = get_queried_object();
$top_label = get_field('services_cards_top_label', $page) ?? '';
$title = get_field('services_cards_title', $page) ?? '';
$descr = get_field('services_cards_descr', $page) ?? '';

// Получаем категории услуг, отсортированные плагином по menu_order
$categories = get_terms([
	'taxonomy' => 'service_cat',
	'hide_empty' => false,
	'orderby' => 'menu_order', // Стандартный параметр для плагинов сортировки таксономий
	'order' => 'ASC',
]);

if (is_wp_error($categories)) {
	$categories = [];
}

// Для каждой категории получаем записи
$categories_data = [];
foreach ($categories as $cat) {
	$services = new WP_Query([
		'post_type' => 'service',
		'posts_per_page' => -1,
		'tax_query' => [
			[
				'taxonomy' => 'service_cat',
				'field' => 'term_id',
				'terms' => $cat->term_id,
			],
		],
		'orderby' => 'menu_order', // Сортировка самих записей внутри категории
		'order' => 'ASC',
	]);

	if ($services->have_posts()) {
		$items = [];
		while ($services->have_posts()) {
			$services->the_post();
			$items[] = [
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'link' => get_permalink(),
			];
		}
		wp_reset_postdata();

		$categories_data[] = [
			'term' => $cat,
			'items' => $items,
		];
	}
}
?>

<?php if ($title || $descr || !empty($categories_data)): ?>
	<section class="section page-services" id="page-services">
		<h2 class="visually-hidden"><?= the_archive_title() ?: 'Услуги'; ?></h2>
		<div class="container page-services__container">
			<?php if (!empty($categories_data)): ?>
				<div class="page-services__grid grid">
					<?php foreach ($categories_data as $index => $cat_data):
						$cat = $cat_data['term'];
						$items = $cat_data['items'];
						$cat_num = ++$index > 9 ? $index : '0' . $index;
						$cat_name = $cat->name ?? '';
						?>
						<div class="page-services__card services-card">
							<div class="services-card__header">
								<div class="services-card__number text-number">
									<?php echo esc_html($cat_num); ?>
								</div>
								<?php if ($cat_name): ?>
									<h3 class="services-card__title title-3">
										<?php echo esc_html(mx_fix_orphans($cat_name)); ?>
									</h3>
								<?php endif; ?>
							</div>

							<?php if (!empty($items)): ?>
								<ul class="services-card__list">
									<?php foreach ($items as $item): ?>
										<li class="services-card__item">
											<a class="services-card__link" href="<?php echo esc_url($item['link']); ?>">
												<span class="services-card__link-text">
													<?php echo esc_html($item['title']); ?>
												</span>
												<span class="services-card__arrow" aria-hidden="true">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path
															d="M17.4189 10L10.4688 16.9512L9.14258 15.625L13.8301 10.9375H2.96875V9.0625H13.8301L9.14258 4.375L10.4688 3.04883L17.4189 10Z"
															fill="currentColor" />
													</svg>
												</span>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>