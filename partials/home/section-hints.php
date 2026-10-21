<?php
$page = get_queried_object();
$top_label = get_field('hints_top_label', $page) ?? '';
$title = get_field('hints_title', $page) ?? '';
$descr = get_field('hints_descr', $page) ?? '';
$btn = get_field('hints_btn', $page) ?? [];
$steps = get_field('hints_steps', $page) ?? [];
$banner_title = get_field('hints_banner_title', $page) ?? '';
$banner_descr = get_field('hints_banner_descr', $page) ?? '';
$phone = get_field('hints_phone', $page) ?: (get_field('contacts_phones', 'option')[0]['phone'] ?? '');
$phone_label = get_field('hints_phone_label', 'option') ?? 'A1 • МТС • life';
$phone_badge = get_field('hints_phone_badge', 'option') ?? '24/7';
?>

<?php if ($title || $descr || !empty($steps) || ($banner_title && $banner_descr)): ?>
	<section class="section section-hints" id="hints">
		<div class="container section-hints__container section-gap">
			<div class="section-hints__grid">
				<div class="section-hints__left">
					<?php if ($top_label): ?>
						<div class="section-hints__top-label label">
							<?php echo esc_html($top_label); ?>
						</div>
					<?php endif; ?>

					<?php if ($title): ?>
						<h2 class="section-hints__title title-1">
							<?php echo esc_html($title); ?>
						</h2>
					<?php endif; ?>

					<?php if ($descr): ?>
						<div class="section-hints__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($btn['url'])): ?>
						<a class="section-hints__btn btn btn--white" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?> target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title'] ?? ''); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if (!empty($steps)): ?>
					<ol class="section-hints__steps">
						<?php foreach ($steps as $index => $step):
							$step_number = ++$index > 9 ? $index : '0' . $index;
							$step_title = $step['title'] ?? '';
							$step_descr = $step['descr'] ?? '';
							if (!$step_title && !$step_descr)
								continue;
							?>
							<li class="section-hints__step hints-step">
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

			<?php if ($banner_title || $banner_descr || $phone): ?>
				<div class="section-hints__banner hints-banner">
					<div class="hints-banner__content">
						<?php if ($banner_title): ?>
							<h3 class="hints-banner__title title-3">
								<?php echo esc_html($banner_title); ?>
							</h3>
						<?php endif; ?>

						<?php if ($banner_descr): ?>
							<div class="hints-banner__descr">
								<?php echo esc_html($banner_descr); ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ($phone): ?>
						<div class="hints-banner__phone icon icon--phone">
							<a class="hints-banner__phone-link link" href="tel:<?php echo esc_attr(correct_phone($phone)); ?>"
								aria-label="Телефон: <?php echo esc_attr($phone); ?>">
								<?php echo esc_html($phone); ?>
							</a>
							<div class="hints-banner__phone-meta">
								<span class="hints-banner__operators">
									<?php echo esc_html($phone_label); ?>
								</span>
								<?php if ($phone_badge): ?>
									<span class="hints-banner__badge">
										<?php echo esc_html($phone_badge); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>