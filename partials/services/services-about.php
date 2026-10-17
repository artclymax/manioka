<?php
$page = $args['page'] ?? get_queried_object();
$top_label = get_field('services_about_top_label', $page) ?? '';
$title = get_field('services_about_title', $page) ?? '';
$descr = get_field('services_about_descr', $page) ?? '';
$steps = get_field('services_about_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps)): ?>
	<section class="section services-about" id="services-about">
		<div class="container services-about__container">
			<?php get_template_part('partials/section-header', null, [
				'label' => $top_label,
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($steps)): ?>
				<ol class="services-about__list grid">
					<?php foreach ($steps as $index => $step):
						$step_number = ++$index > 9 ? $index : '0' . $index;
						$step_title = $step['title'] ?? '';
						$step_descr = $step['descr'] ?? '';
						if (!$step_title && !$step_descr)
							continue;
						?>
						<li class="services-about__step process-step">

							<span class="process-step__number title-4">
								<?php echo esc_html($step_number); ?>
							</span>

							<?php if ($step_title): ?>
								<h3 class="process-step__title title-4">
									<?php echo esc_html($step_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($step_descr): ?>
								<div class="process-step__descr descr">
									<?php echo wp_kses_post($step_descr); ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>