<?php
$title = get_field('thank_you_title', 'option') ?? '';
$descr = get_field('thank_you_descr', 'option') ?? '';
$btn = get_field('thank_you_btn', 'option') ?? [];
$image = get_field('thank_you_image', 'option') ?? null;

if (empty($btn['url'])) {
	$btn = [
		'url' => home_url('/'),
		'title' => 'На главную',
	];
}

$has_image = ($image && is_array($image) && !empty($image['ID']));
?>
<section class="section-full page-404 hero-thank-you jarallax" id="thank-you">
	<div class="container page-404__container section-gap">
		<div class="page-404__content">
			<?php if ($title): ?>
				<h1 class="page-404__title title-1"><?php echo esc_html($title); ?></h1>
			<?php endif; ?>

			<?php if ($descr): ?>
				<div class="page-404__descr descr"><?php echo wp_kses_post($descr); ?></div>
			<?php endif; ?>

			<?php if (!empty($btn) || !empty($btn_second)): ?>

				<div class="page-404__btn-box">

				
			<?php if (!empty($btn) && !empty($btn['url'])): ?>
				<a class="page-404__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>
						target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>><?php echo esc_html($btn['title']); ?></a>
			<?php endif; ?>
		</div>
			<?php endif; ?>
		</div>

	</div>
	<?php if ($has_image): ?>
		<div class="page-404__image image-box jarallax-img">
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<?php echo wp_get_attachment_image(
					$image['ID'],
					'full',
					false,
					[
						'class' => 'page-404__img-big',
						'alt' => $image['alt'] ?: $title,
						'loading' => 'eager',
					]
				); ?>
			<?php endif; ?>

		</div>
	<?php endif; ?>
</section>