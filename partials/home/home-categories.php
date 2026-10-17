<?php
$page = get_queried_object();
$top_label = get_field('home_categories_top_label', $page) ?? '';
$title = get_field('home_categories_title', $page) ?? '';
$descr = get_field('home_categories_descr', $page) ?? '';
$btn = get_field('home_categories_btn', $page) ?? [];
$selected = get_field('home_categories_selected', $page) ?? [];

// Собираем все возможные slug категории "Разное"
$misc_slugs = ['uncategorized', 'misc', 'raznoe', 'bez-kategorii'];
$exclude_ids = [];

foreach ($misc_slugs as $slug) {
	$term = get_term_by('slug', $slug, 'product_cat');
	if ($term && !is_wp_error($term)) {
		$exclude_ids[] = $term->term_id;
	}
}

// Получаем категории
if (!empty($selected) && is_array($selected)) {
	$term_ids = wp_list_pluck($selected, 'term_id');
	$terms = get_terms([
		'taxonomy' => 'product_cat',
		'include' => $term_ids,
		'hide_empty' => false,
		'orderby' => 'include',
		'exclude' => $exclude_ids,
	]);
} else {
	$terms = get_terms([
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'number' => 6,
		'orderby' => 'term_order',
		'order' => 'ASC',
		'exclude' => $exclude_ids,
	]);
}

if (is_wp_error($terms)) {
	$terms = [];
}
?>

<?php if ($title || $descr || !empty($terms)): ?>
	<section class="section home-categories" id="home-categories">
		<div class="container home-categories__container section-gap">
			<?php if ($top_label || $title || $descr || !empty($btn['url'])): ?>
				<div class="home-categories__header">
					<div class="home-categories__header-content">
						<?php if ($top_label): ?>
							<div class="home-categories__top-label label">
								<?php echo esc_html($top_label); ?>
							</div>
						<?php endif; ?>
						<?php if ($title): ?>
							<h2 class="home-categories__title title-1">
								<?php echo esc_html($title); ?>
							</h2>
						<?php endif; ?>

						<?php if ($descr): ?>
							<div class="home-categories__descr descr">
								<?php echo wp_kses_post($descr); ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if (!empty($btn['url'])): ?>
						<a class="home-categories__btn btn-link" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?> target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title'] ?? ''); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($terms)): ?>
				<div class="home-categories__grid grid">
					<?php foreach ($terms as $term):
						$term_id = $term->term_id;
						$term_name = $term->name ?? '';
						$term_descr = $term->description ?? '';
						$term_link = get_term_link($term);
						$thumb_id = get_woocommerce_term_meta($term_id, 'thumbnail_id', true);

						if (!$term_name)
							continue;
						if (is_wp_error($term_link))
							continue;
						?>
						<a class="home-categories__card home-categories-card" href="<?php echo esc_url($term_link); ?>">
							<?php if ($thumb_id): ?>
								<div class="home-categories-card__image image-box">
									<?php echo wp_get_attachment_image($thumb_id, 'large', false, [
										'class' => 'img',
										'alt' => $term_name,
										'loading' => 'lazy'
									]); ?>
								</div>
							<?php endif; ?>

							<div class="home-categories-card__content">
								<?php if ($term_name): ?>
									<h3 class="home-categories-card__title title-3">
										<?php echo esc_html($term_name); ?>
									</h3>
								<?php endif; ?>

								<?php if ($term_descr): ?>
									<div class="home-categories-card__descr descr">
										<?php echo wp_kses_post($term_descr); ?>
									</div>
								<?php endif; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>