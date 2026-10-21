<?php
$categories = get_the_terms(get_the_ID(), 'hints_cat');
$title = get_the_title();
$descr = get_the_excerpt() ?? '';
?>
<section class="section hero-hints">
	<div class="container hero-hints__container">
		<div class="hero-hints__breadcrumbs">
			<div class="page-breadcrumbs">
				<?php if (function_exists('bcn_display')) {
					bcn_display();
				} ?>
			</div>
		</div>
		<div class="hero-hints__content">
			<?php if (!empty($categories)): ?>
				<div class="hero-hints__categories">
					<?php foreach ($categories as $cat):
						$cat_link = get_term_link($cat);
						if (is_wp_error($cat_link))
							continue;
						?>
						<a class="hero-hints__category label" href="<?php echo esc_url($cat_link); ?>">
							<?php echo esc_html($cat->name); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<h1 class="hero-hints__title title-1">
				<?php echo esc_html($title); ?>
			</h1>
			<?php if (!empty($descr)): ?>
				<div class="hero-hints__descr descr">
					<?php echo wp_kses_post($descr); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if (has_post_thumbnail()): ?>
			<div class="hero-hints__image image-box">
				<?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
			</div>
		<?php endif; ?>
	</div>
</section>