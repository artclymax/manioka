<?php
$page = $args['page'] ?? get_queried_object();
$label = get_field('hint_actions_process_label', $page) ?? '';
$title = get_field('hint_actions_process_title', $page) ?? '';
$descr = get_field('hint_actions_process_descr', $page) ?? '';
$steps = get_field('hint_actions_process_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps)): ?>
	<section class="section hint-actions-process" id="hint-actions-process">
		<div class="container hint-actions-process__container">
			<!-- Левая колонка -->
			<div class="hint-actions-process__left">
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => $descr
				]); ?>
			</div>

			<!-- Правая колонка: список шагов -->
			<?php if (!empty($steps)): ?>
				<div class="hint-actions-process__right">
					<?php foreach ($steps as $index => $step):
						$step_number = ++$index > 9 ? $index : '0' . $index;
						$step_title = $step['title'] ?? '';
						$step_descr = $step['descr'] ?? '';
						if (!$step_title && !$step_descr)
							continue;
						?>
						<div class="hint-actions-process__step hints-step">
							<div class="hints-step__number text-number">
								<?php echo esc_html($step_number); ?>
							</div>
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
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>