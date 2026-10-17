<?php
$page = get_queried_object();
$top_label = get_field('reviews_top_label', $page) ?? '';
$title = get_field('reviews_title', $page) ?? '';
$descr = get_field('reviews_descr', $page) ?? '';

$reviews = new WP_Query([
	'post_type' => 'review',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC',
]);

$review_items = [];
if ($reviews->have_posts()) {
	while ($reviews->have_posts()) {
		$reviews->the_post();
		$review_items[] = [
			'id' => get_the_ID(),
			'title' => get_the_title(),
			'content' => get_the_content(),
			'city' => get_field('review_city') ?? '',
			'date' => get_field('review_date') ?? '',
		];
	}
	wp_reset_postdata();
}
?>

<?php if ($title || $descr || !empty($review_items)): ?>
	<section class="section reviews" id="reviews"
		style="--quote-bg: url('<?= esc_url(get_template_directory_uri() . '/assets/images/icons/quote.webp'); ?>');">
		<div class="container reviews__container section-gap">
			<?php if ($top_label || $title || $descr): ?>
				<div class="reviews__header">
					<?php get_template_part('partials/section-header', null, [
						'label' => $top_label,
						'title' => $title,
						'descr' => $descr,
						'title_class' => 'title-2'
					]); ?>

					<div class="reviews__nav swiper-btn-box hidden-mobile">
						<button class="swiper-btn swiper-btn__prev" data-swiper-btn-prev=".reviews .reviews__swiper--desktop"
							type="button" aria-label="Назад"></button>
						<button class="swiper-btn swiper-btn__next" data-swiper-btn-next=".reviews .reviews__swiper--desktop"
							type="button" aria-label="Вперёд"></button>
					</div>
					<div class="reviews__nav-mobile swiper-btn-box visible-mobile">
						<button class="swiper-btn swiper-btn__prev" data-swiper-btn-prev=".reviews .reviews__swiper--mobile"
							type="button" aria-label="Назад"></button>
						<button class="swiper-btn swiper-btn__next" data-swiper-btn-next=".reviews .reviews__swiper--mobile"
							type="button" aria-label="Вперёд"></button>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($review_items)): ?>
				<!-- Десктопный слайдер: группы по 3 отзыва -->
				<div class="swiper reviews__swiper reviews__swiper--desktop hidden-mobile"
					data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true }'>
					<div class="swiper-wrapper">
						<?php
						$groups = array_chunk($review_items, 3);
						foreach ($groups as $index => $group):
							?>
							<div class="swiper-slide reviews__slide-desktop">
								<div class="reviews__grid">
									<?php foreach ($group as $item): ?>
										<div
											class="reviews__card reviews-card<?php echo $index === 0 && $item === reset($group) ? ' reviews-card--featured' : ''; ?>">

											<?php if ($item['content']): ?>
												<div class="reviews-card__text">
													<?php echo wp_kses_post($item['content']); ?>
												</div>
											<?php endif; ?>



											<?php if ($item['title']): ?>
												<div class="reviews-card__author">
													<div class="reviews-card__name title-4">
														<?php echo esc_html($item['title']); ?>
													</div>
													<?php if ($item['city'] || $item['date']): ?>
														<div class="reviews-card__meta">
															<?php echo esc_html($item['city']); ?>
															<?php if ($item['city'] && $item['date']): ?>
																<span class="reviews-card__sep" aria-hidden="true">•</span>
															<?php endif; ?>
															<?php echo esc_html($item['date']); ?>
														</div>
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Мобильный слайдер: по 1 отзыву -->
				<div class="swiper reviews__swiper reviews__swiper--mobile visible-mobile"
					data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true }'>
					<div class="swiper-wrapper">
						<?php foreach ($review_items as $item): ?>
							<div class="swiper-slide reviews__slide">
								<div class="reviews__card reviews-card">

									<?php if ($item['content']): ?>
										<div class="reviews-card__text">
											<?php echo wp_kses_post($item['content']); ?>
										</div>
									<?php endif; ?>
									<?php if ($item['title']): ?>
										<div class="reviews-card__author">
											<div class="reviews-card__name title-4">
												<?php echo esc_html($item['title']); ?>
											</div>
											<?php if ($item['city'] || $item['date']): ?>
												<div class="reviews-card__meta">
													<?php echo esc_html($item['city']); ?>
													<?php if ($item['city'] && $item['date']): ?>
														<span class="reviews-card__sep" aria-hidden="true">•</span>
													<?php endif; ?>
													<?php echo esc_html($item['date']); ?>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>


				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>