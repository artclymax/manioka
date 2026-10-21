<?php
$page = $args['page'] ?? get_queried_object();
$title = get_field('about_descr_title', $page) ?? '';
$descr = get_field('about_descr_descr', $page) ?? '';
?>

<?php if ($title || $descr): ?>
	<section class="section about-description" id="about-description">
		<div class="container about-description__container">
			<div class="about-description__content">
				<?php if ($title): ?>
					<h2 class="about-description__title title-1 descr">
						<?php echo wp_kses_post($title); ?>
					</h2>
				<?php endif; ?>
				<?php if ($descr): ?>
					<div class="about-description__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</section>
<?php endif; ?>