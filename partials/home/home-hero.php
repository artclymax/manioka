<?php
$page = get_queried_object();
$bg = get_field('home_hero_bg', $page) ?? null;
$top_label = get_field('home_hero_top_label', $page) ?? '';
$title = get_field('home_hero_title', $page) ?? '';
$descr = get_field('home_hero_descr', $page) ?? '';
$btn_primary = get_field('home_hero_btn_primary', $page) ?? [];
$btn_secondary = get_field('home_hero_btn_secondary', $page) ?? [];
$cities = get_field('home_hero_cities', $page) ?? [];
?>
<?php if ($title || $descr || !empty($btn_primary['url']) || !empty($btn_secondary['url']) || !empty($cities) || ($bg && !empty($bg['ID']))): ?>
	<section class="home-hero" id="home-hero">
		<div class="container home-hero__container">
			<div class="home-hero__content">
				<?php if ($top_label): ?>
					<div class="home-hero__top-label label">
						<?php echo esc_html($top_label); ?>
					</div>
				<?php endif; ?>

				<?php if ($title): ?>
					<h1 class="home-hero__title title-main">
						<?php echo wp_kses_post($title); ?>
					</h1>
				<?php endif; ?>

				<?php if ($descr): ?>
					<div class="home-hero__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($btn_primary['url']) || !empty($btn_secondary['url'])): ?>
					<div class="home-hero__actions">
						<?php if (!empty($btn_primary['url'])): ?>
							<a class="home-hero__btn home-hero__btn--primary btn" href="<?php echo esc_url($btn_primary['url']); ?>"
								<?php if (!empty($btn_primary['target'])): ?> target="
					<?php echo esc_attr($btn_primary['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn_primary['title'] ?? ''); ?>
							</a>
						<?php endif; ?>

						<?php if (!empty($btn_secondary['url'])): ?>
							<a class="home-hero__btn home-hero__btn--secondary btn btn--white"
								href="<?php echo esc_url($btn_secondary['url']); ?>" <?php if (!empty($btn_secondary['target'])): ?>
									target="
					<?php echo esc_attr($btn_secondary['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn_secondary['title'] ?? ''); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if (!empty($cities)): ?>
				<ul class="home-hero__cities">
					<?php foreach ($cities as $city): ?>
						<li class="home-hero__city">
							<?php echo esc_html($city['city'] ?? ''); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<?php if ($bg && is_array($bg) && !empty($bg['ID'])): ?>
			<div class="home-hero__bg image-box">
				<?php echo wp_get_attachment_image($bg['ID'], 'full', false, [
					'class' => 'img',
					'alt' => $bg['alt'] ?: $title,
					'loading' => 'eager'
				]); ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>