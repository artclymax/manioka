<?php
$monument_id = get_the_ID();

$main_image_id = get_post_thumbnail_id($monument_id);
$gallery_ids = get_field('monuments_gallery', $monument_id) ?? [];
$all_images = $main_image_id ? array_merge([$main_image_id], $gallery_ids) : $gallery_ids;

$categories = get_the_terms($monument_id, 'monuments_cat');
if (is_wp_error($categories)) {
	$categories = [];
}

// Атрибуты из ACF
$attributes = [];
$acf_attributes = get_field('monuments_attributes', $monument_id) ?? [];

foreach ($acf_attributes as $acf_attr) {
	$key = $acf_attr['key'] ?? '';
	$value = $acf_attr['value'] ?? '';
	if ($key && $value) {
		$attributes[] = [
			'key' => $key,
			'value' => $value,
		];
	}
}

$has_gallery = count($all_images) > 1;

$phones = get_field('contacts_phones', 'option') ?? [];
$phone_label = get_field('contacts_phone_label', 'option') ?? 'A1 • MTC • life';
$phone_badge = get_field('contacts_phone_badge', 'option') ?? '24/7';
?>

<section class="section product-single monuments-single" id="monuments-single">
	<div class="container product-single__container">
		<div class="product-single__breadcrumbs">
			<div class="page-breadcrumbs">
				<?php if (function_exists('bcn_display')) {
					bcn_display();
				} ?>
			</div>
		</div>

		<div class="product-single__grid">
			<!-- Левая колонка: галерея -->
			<div class="product-single__gallery">
				<?php if (!empty($all_images)): ?>
					<?php if ($has_gallery): ?>
						<!-- Два связанных слайдера: главный + миниатюры -->
						<div class="product-single__swiper-main swiper" data-product-swiper="main">
							<div class="swiper-wrapper">
								<?php foreach ($all_images as $img_id): ?>
									<div class="swiper-slide">
										<a class="product-single__main-image image-box"
											href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full')); ?>"
											data-fancybox="monument-gallery">
											<?php echo wp_get_attachment_image($img_id, 'large', false, [
												'class' => 'img',
												'alt' => get_the_title(),
												'loading' => 'eager'
											]); ?>
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<div class="product-single__swiper-thumbs swiper" data-product-swiper="thumbs">
							<div class="swiper-wrapper">
								<?php foreach ($all_images as $img_id): ?>
									<div class="swiper-slide">
										<div class="product-single__thumb image-box">
											<?php echo wp_get_attachment_image($img_id, 'medium', false, [
												'class' => 'img',
												'alt' => get_the_title(),
												'loading' => 'lazy'
											]); ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php else: ?>
						<!-- Одно изображение -->
						<?php $img_id = $all_images[0]; ?>
						<a class="product-single__single-image image-box"
							href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full')); ?>"
							data-fancybox="monument-gallery">
							<?php echo wp_get_attachment_image($img_id, 'large', false, [
								'class' => 'img',
								'alt' => get_the_title(),
								'loading' => 'eager'
							]); ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<!-- Правая колонка: информация -->
			<div class="product-single__info">
				<!-- Ссылки на категории -->
				<?php if (!empty($categories)): ?>
					<div class="product-single__categories">
						<?php foreach ($categories as $cat):
							$cat_link = get_term_link($cat);
							if (is_wp_error($cat_link))
								continue;
							?>
							<a class="product-single__category label" href="<?php echo esc_url($cat_link); ?>">
								<?php echo esc_html($cat->name); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Заголовок -->
				<h1 class="product-single__title title-1">
					<?php the_title(); ?>
				</h1>

				<!-- Описание -->
				<?php if (get_the_content()): ?>
					<div class="product-single__content descr">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<!-- Характеристики -->
				<?php if (!empty($attributes)): ?>
					<dl class="product-card__attributes product-single__attributes">
						<?php foreach ($attributes as $attr): ?>
							<div class="product-card__attribute product-single__attribute">
								<dt class="product-card__attribute-key product-single__attribute-key">
									<?php echo esc_html($attr['key']); ?>
								</dt>
								<dd class="product-card__attribute-value product-single__attribute-value">
									<?php echo esc_html($attr['value']); ?>
								</dd>
							</div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>

				<!-- Стоимость и наличие -->
				<?php if (get_the_excerpt()): ?>
					<div class="product-single__price-note descr">
						<?php the_excerpt(); ?>
					</div>
				<?php else: ?>
					<div class="product-single__price-note descr">
						Стоимость рассчитывается индивидуально и зависит от выбранного материала, размера, оформления и
						комплектации.
					</div>
				<?php endif; ?>

				<!-- Телефон -->
				<?php if ($phones): ?>
					<div class="product-single__phone contacts-block__phone icon icon--phone">
						<div class="contacts-block__phone-wrapper">
							<div class="contacts-block__phone-list">
								<?php foreach ($phones as $phone): ?>
									<a class="contacts-block__phone-link"
										href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
										aria-label="Телефон: <?php echo esc_attr($phone['phone']); ?>">
										<span class="contacts-block__phone-value">
											<?php echo esc_html($phone['phone']); ?>
										</span>
									</a>
								<?php endforeach; ?>
							</div>
							<?php if ($phone_label || $phone_badge): ?>
								<div class="contacts-block__phone-meta">
									<?php if ($phone_label): ?>
										<span class="contacts-block__operators">
											<?php echo esc_html($phone_label); ?>
										</span>
									<?php endif; ?>
									<?php if ($phone_badge): ?>
										<span class="contacts-block__badge">
											<?php echo esc_html($phone_badge); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>