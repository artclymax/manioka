<?php
$page = $args['page'] ?? get_queried_object();
$class = $args['class'] ?? '';

if (!empty($args['page'])) {
	$page = get_page_by_path($args['page'], OBJECT, 'page');
}

if (is_archive()) {
	$archive_name = '';

	$queried = get_queried_object();
	$archive_name = $queried->has_archive ? $queried->name : $queried->has_archive;


	$archive_page = $archive_name ? get_page_by_path($archive_name, OBJECT, 'page') : null;

	if ($archive_page) {
		$page = $archive_page;
	}
}
if (is_tax()) {
	$term = get_queried_object();
	if (!empty($args['page'])) {
		$term = get_page_by_path($args['page'], OBJECT, 'page');
	}
	$label = get_field('hero_label', $term) ?? '';
	$title = get_field('hero_title', $term) ?? '';
	$descr = get_field('hero_descr', $term) ?: $term->description ?? '';
	$image = get_field('hero_image', $term) ?: get_field('hero_product_cat_image', 'option') ?? '';

} else {
	$label = get_field('hero_label', $page) ?? '';
	$title = get_field('hero_title', $page) ?? '';
	$descr = get_field('hero_descr', $page) ?? '';
	$image = get_field('hero_image', $page) ?? '';

}

if (!$title) {
	if (is_tax() || is_category() || is_tag()) {
		$title = single_term_title('', false);
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	} else {
		$title = get_the_title();
	}
}



if ($title || $descr || ($image && is_array($image) && !empty($image['ID']))):
	?>
	<section class="hero-page <?php echo esc_attr($class); ?>" id="hero-page">
		<div class="un-container un-container--reverse hero-page__container">
			<div class="un-container__content hero-page__wrapper">
				<div class="hero-page__content">
					<div class="hero-page__breadcrumbs">
						<div class="page-breadcrumbs">
							<?php if (function_exists('bcn_display')) {
								bcn_display();
							} ?>
						</div>
					</div>
					<?php if (!empty($label)): ?>
						<p class="hero-page__label label">
							<?php echo esc_html($label) ?>
						</p>
					<?php endif; ?>
					<?php if ($title): ?>
						<h1 class="hero-page__title title-1">
							<?php echo esc_html($title); ?>
						</h1>
					<?php endif; ?>
					<?php if ($descr): ?>
						<div class="hero-page__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php if (!empty($image)): ?>
				<div class="un-container__full hero-page__image image-box">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'full',
						false,
						array(
							'class' => 'img',
							'alt' => $image['alt'] ?: ''
						)
					); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>