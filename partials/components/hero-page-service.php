<?php
$page = $args['page'] ?? get_queried_object();
$class = $args['class'] ?? '';

$label = get_field('hero_label', $page) ?: get_field('hero_label', 'option') ?? '';
$title = get_the_title() ?? '';
$descr = apply_filters('the_content', get_the_content()) ?? '';
$image = get_post_thumbnail_id() ?: get_field('hero_image', 'option')['ID'] ?? null;

if ($title || $descr || ($image && is_array($image) && !empty($image['ID']))):
	?>
	<section class="hero-page hero-page-service <?php echo esc_attr($class); ?>" id="hero-page">
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
						$image,
						'full',
						false,
						array(
							'class' => 'img',
							'alt' => $title ?: ''
						)
					); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>