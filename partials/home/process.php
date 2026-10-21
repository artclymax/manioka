<?php
$page = get_queried_object();
$top_label = get_field('process_top_label', $page) ?? '';
$title = get_field('process_title', $page) ?? '';
$descr = get_field('process_descr', $page) ?? '';
$subtitle = get_field('process_subtitle', $page) ?? '';
$subtitle_descr = get_field('process_subtitle_descr', $page) ?? '';
$btn = get_field('process_btn', $page) ?? [];
$phone_label = get_field('process_phone_label', $page) ?? 'Круглосуточно';
$phone = get_field('process_phone', $page) ?: (get_field('contacts_phones', 'option')[0]['phone'] ?? '');
$right_title = get_field('process_right_title', $page) ?? '';
$steps = get_field('process_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps) || $right_title): ?>
	<section class="section process" id="process">
		<div class="container process__container">
			<!-- Левая колонка -->
			<div class="process__left process-left">
				<div class="process-left__content">
					<?php if ($top_label): ?>
						<div class="process-left__label label">
							<?php echo esc_html($top_label); ?>
						</div>
					<?php endif; ?>

					<?php if ($title): ?>
						<h2 class="process-left__title title-2">
							<?php echo esc_html($title); ?>
						</h2>
					<?php endif; ?>

					<?php if ($descr): ?>
						<div class="process-left__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="process-left__bottom">
					<?php if ($subtitle || $subtitle_descr): ?>
						<div class="process-left__feature">
							<?php if ($subtitle): ?>
								<h3 class="process-left__subtitle title-4">
									<?php echo esc_html($subtitle); ?>
								</h3>
							<?php endif; ?>

							<?php if ($subtitle_descr): ?>
								<div class="process-left__feature-descr descr">
									<?php echo wp_kses_post($subtitle_descr); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($btn['url'])): ?>
						<a class="process-left__btn btn btn--white" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?> target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title'] ?? ''); ?>
						</a>
					<?php endif; ?>

					<?php if ($phone): ?>
						<div class="process-left__phone">
							<span class="process-left__phone-label">
								<?php echo esc_html($phone_label); ?> •
							</span>
							<span class="process-left__phone-value">
								<a href="tel:<?php echo esc_attr(correct_phone($phone)); ?>" class="link">
									<?php echo esc_html($phone); ?>
								</a>
							</span>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Правая колонка -->
			<div class="process__right process-right section-gap">
				<?php if ($right_title): ?>
					<h2 class="process-right__title title-2">
						<?php echo esc_html($right_title); ?>
					</h2>
				<?php endif; ?>

				<?php if (!empty($steps)): ?>
					<div class="process-right__grid grid">
						<?php foreach ($steps as $index => $step):
							$step_number = ++$index > 9 ? $index : '0' . $index;
							$step_title = $step['title'] ?? '';
							$step_descr = $step['descr'] ?? '';
							if (!$step_title && !$step_descr)
								continue;
							?>
							<div class="process-right__step process-step">
								<div class="process-step__number title-4">
									<?php echo esc_html($step_number); ?>
								</div>

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
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>