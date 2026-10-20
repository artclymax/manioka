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
	$featured_posts = get_field('hero_featured_posts', $term) ?? [];
} else {
	$label = get_field('hero_label', $page) ?? '';
	$title = get_field('hero_title', $page) ?? '';
	$descr = get_field('hero_descr', $page) ?? '';
	$featured_posts = get_field('hero_featured_posts', $page) ?? [];
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

$featured_items = [];
if (!empty($featured_posts)) {
	$posts = is_array($featured_posts) ? $featured_posts : [$featured_posts];

	foreach ($posts as $post) {
		$post_id = is_object($post) ? $post->ID : ($post['ID'] ?? 0);
		if (!$post_id)
			continue;

		$wp_post = get_post($post_id);
		if (!$wp_post || $wp_post->post_type !== 'hints')
			continue;

		$thumb_id = get_post_thumbnail_id($post_id);
		$link = get_field('hints_link_text', $post_id) ?? 'Открыть инструкцию';

		$featured_items[] = [
			'id' => $post_id,
			'title' => get_the_title($post_id),
			'excerpt' => get_the_excerpt($post_id),
			'link' => get_permalink($post_id),
			'thumb' => $thumb_id ? wp_get_attachment_image($thumb_id, 'large', false, [
				'class' => 'img',
				'alt' => get_the_title($post_id),
				'loading' => 'lazy'
			]) : null,
			'link_text' => $link,
		];
	}
}

if ($title || $descr || !empty($featured_items)):
	?>
	<section class="hero-page hero-page-hints <?php echo esc_attr($class); ?>" id="hero-page">
		<div class="container hero-page__container">
			<div class="hero-page__wrapper">
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
							<?php echo esc_html($label); ?>
						</p>
					<?php endif; ?>
					<?php if ($title): ?>
						<h1 class="hero-page__title title-1">
							<?php echo esc_html($title); ?>
						</h1>
					<?php endif; ?>
				</div>

				<?php if (!empty($featured_items)): ?>
					<div class="hero-page__featured">
						<?php foreach ($featured_items as $item): ?>
							<a class="hero-page__featured-card hero-featured-card" href="<?php echo esc_url($item['link']); ?>">


								<div class="hero-featured-card__content">
									<?php if ($item['title']): ?>
										<h3 class="hero-featured-card__title title-4">
											<?php echo esc_html($item['title']); ?>
										</h3>
									<?php endif; ?>

									<?php if ($item['excerpt']): ?>
										<div class="hero-featured-card__descr descr">
											<?php echo wp_kses_post($item['excerpt']); ?>
										</div>
									<?php endif; ?>

									<?php if ($item['link_text']): ?>
										<span class="hero-featured-card__link-text btn-link">
											<?php echo esc_html($item['link_text']); ?>
										</span>
									<?php endif; ?>
								</div>
								<?php if ($item['thumb']): ?>
									<div class="hero-featured-card__image image-box">
										<?php echo $item['thumb']; ?>
									</div>
								<?php endif; ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>