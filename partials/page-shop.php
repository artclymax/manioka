<?php

$misc_slugs = ['uncategorized', 'misc', 'raznoe', 'bez-kategorii'];
$exclude_ids = [];

foreach ($misc_slugs as $slug) {
	$term = get_term_by('slug', $slug, 'product_cat');
	if ($term && !is_wp_error($term)) {
		$exclude_ids[] = $term->term_id;
	}
}
$terms = get_terms([
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'orderby' => 'term_order',
	'order' => 'ASC',
	'exclude' => $exclude_ids,
]);


if (is_wp_error($terms)) {
	$terms = [];
}
?>

<?php if (!empty($terms)): ?>
	<section class="section page-shop" id="page-shop">
		<div class="container page-shop__container">
			<?php if (!empty($terms)): ?>
				<div class="page-shop__grid grid">
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
						<a class="page-shop__card home-categories-card" href="<?php echo esc_url($term_link); ?>">
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