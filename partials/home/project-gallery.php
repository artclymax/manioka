<?php
$page = get_queried_object();
$default_page = get_page_by_path('home', OBJECT, 'page');

$top_label = get_field('project_gallery_top_label', $page) ?: get_field('project_gallery_top_label', $default_page) ?? '';
$title = get_field('project_gallery_title', $page) ?: get_field('project_gallery_title', $default_page) ?? '';
$descr = get_field('project_gallery_descr', $page) ?: get_field('project_gallery_descr', $default_page) ?? '';

$projects = new WP_Query([
	'post_type' => 'project',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC',
]);

$project_items = [];
if ($projects->have_posts()) {
	while ($projects->have_posts()) {
		$projects->the_post();
		$thumb_id = get_post_thumbnail_id();
		if ($thumb_id) {
			$project_items[] = [
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'link' => get_permalink(),
				'thumb_url' => get_the_post_thumbnail_url(),
				'thumb' => wp_get_attachment_image($thumb_id, 'large', false, [
					'class' => 'img',
					'alt' => get_the_title(),
					'loading' => 'lazy'
				])
			];
		}
	}
	wp_reset_postdata();
}
?>

<?php if ($title || $descr || !empty($project_items)): ?>
	<section class="section project-gallery" id="project-gallery">
		<div class="container project-gallery__container section-gap">
			<?php if ($top_label || $title || $descr): ?>
				<div class="project-gallery__header">
					<?php get_template_part('partials/section-header', null, [
						'label' => $top_label,
						'title' => $title,
						'descr' => $descr,
						'title_class' => 'title-2'
					]); ?>

					<div class="project-gallery__nav swiper-btn-box">
						<button class="swiper-btn swiper-btn__prev" data-swiper-btn-prev=".project-gallery .project-gallery__swiper"
							type="button" aria-label="Назад"></button>
						<button class="swiper-btn swiper-btn__next" data-swiper-btn-next=".project-gallery .project-gallery__swiper"
							type="button" aria-label="Вперёд"></button>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($project_items)): ?>
				<div class="swiper project-gallery__swiper project-gallery__swiper--desktop hidden-mobile"
					data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true }'>
					<div class="swiper-wrapper">
						<?php
						$groups = array_chunk($project_items, 3);
						foreach ($groups as $group):
							?>
							<div class="swiper-slide project-gallery__slide-desktop">
								<div class="project-gallery__grid">
									<?php foreach ($group as $item): ?>
										<a class="project-gallery__item project-gallery__item image-box"
											href="<?php echo esc_url($item['thumb_url']); ?>" data-fancybox="project-gallery-desktop">
											<?php echo $item['thumb']; ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swiper project-gallery__swiper project-gallery__swiper--mobile visible-mobile"
					data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true}'>
					<div class="swiper-wrapper">
						<?php foreach ($project_items as $item): ?>
							<div class="swiper-slide project-gallery__slide">
								<a class="project-gallery__item image-box" href="<?php echo esc_url($item['thumb_url']); ?>"
									data-fancybox="project-gallery-mobile">
									<?php echo $item['thumb']; ?>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>