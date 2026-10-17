<?php
$page = $args['page'] ?? get_queried_object();
$top_label = get_field('approach_top_label', $page) ?? '';
$title = get_field('approach_title', $page) ?? '';
$descr = get_field('approach_descr', $page) ?? '';
$steps = get_field('approach_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps)): ?>
	<section class="section approach" id="approach">
		<div class="container approach__container">
			<?php get_template_part('partials/section-header', null, [
				'label' => $top_label,
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($steps)): ?>
				<ol class="approach__list">
					<?php foreach ($steps as $index => $step):
						$step_number = ++$index > 9 ? $index : '0' . $index;
						$step_title = $step['title'] ?? '';
						$step_descr = $step['descr'] ?? '';
						if (!$step_title && !$step_descr)
							continue;
						?>
						<li class="approach__step hints-step">
							<?php if ($step_number): ?>
								<span class="hints-step__number text-number">
									<?php echo esc_html($step_number); ?>
								</span>
							<?php endif; ?>
							<div class="hints-step__content">
								<?php if ($step_title): ?>
									<h3 class="hints-step__title title-3">
										<?php echo esc_html($step_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($step_descr): ?>
									<div class="hints-step__descr descr">
										<?php echo wp_kses_post($step_descr); ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php endif; ?>
		</div>
		</section>
<?php endif; ?>