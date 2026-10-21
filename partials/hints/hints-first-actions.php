<?php
$page = $args['page'] ?? get_queried_object();
$top_label = get_field('hints_first_actions_top_label', $page) ?? '';
$title = get_field('hints_first_actions_title', $page) ?? '';
$descr = get_field('hints_first_actions_descr', $page) ?? '';
$tabs = get_field('hints_first_actions_tabs', $page) ?? [];
?>

<?php if ($title || !empty($tabs)): ?>
	<section class="section hints-first-actions" id="hints-first-actions">
		<div class="container hints-first-actions__container section-gap">

			<?php get_template_part('partials/section-header', null, [
				'label' => $top_label,
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($tabs)): ?>
				<!-- Навигация по табам -->
				<div class="hints-first-actions__nav">
					<?php foreach ($tabs as $index => $tab):
						$tab_title = $tab['tab_title'] ?? '';
						if (!$tab_title)
							continue;

						$tab_id = 'tab-' . sanitize_title($tab_title);
						$active_class = $index === 0 ? ' active-tab' : '';
						?>
						<!-- Добавлен href для совместимости с твоим Tabs.js -->
						<button class="hints-first-actions__nav-link<?php echo esc_attr($active_class); ?>"
							href="#<?php echo esc_attr($tab_id); ?>" data-tab-link data-tab-target="<?php echo esc_attr($tab_id); ?>">
							<?php echo esc_html($tab_title); ?>
						</button>
					<?php endforeach; ?>
				</div>

				<!-- Контент табов -->
				<div class="hints-first-actions__content">
					<?php foreach ($tabs as $index => $tab):
						$tab_title = $tab['tab_title'] ?? '';
						if (!$tab_title)
							continue;

						$tab_id = 'tab-' . sanitize_title($tab_title);
						$active_class = $index === 0 ? ' active-tab' : '';

						$steps = $tab['steps'] ?? [];
						$emergency_label = $tab['emergency_label'] ?? '';
						$emergency_title = $tab['emergency_title'] ?? '';
						$emergency_descr = $tab['emergency_descr'] ?? '';
						$emergency_phone_first_label = $tab['emergency_phone_first_label'] ?? '';
						$emergency_phone_label = $tab['emergency_phone_label'] ?? '';
						$phone = $tab['emergency_phone'] ?? '';
						$phone_badge = $tab['emergency_phone_badge'] ?? '';
						?>
						<div class="hints-first-actions__tab<?php echo esc_attr($active_class); ?>"
							id="<?php echo esc_attr($tab_id); ?>" data-tab>
							<div class="hints-first-actions__grid">
								<!-- Левая колонка: шаги -->
								<?php if (!empty($steps)): ?>
									<div class="hints-first-actions__steps">
										<?php foreach ($steps as $step_index => $step):

											$step_number = ++$step_index > 9 ? $step_index : '0' . $step_index;
											$step_title = $step['title'] ?? '';
											$step_descr = $step['descr'] ?? '';
											if (!$step_title && !$step_descr)
												continue;
											?>
											<div class="hints-first-actions__step hints-step">
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

								<!-- Правая колонка: экстренная информация -->
								<?php if ($emergency_title || $emergency_descr || $phone): ?>
									<div class="hints-first-actions__emergency">
										<?php if ($emergency_label): ?>
											<div class="hints-first-actions__emergency-label label">
												<?php echo esc_html($emergency_label); ?>
											</div>
										<?php endif; ?>

										<?php if ($emergency_title): ?>
											<h3 class="hints-first-actions__emergency-title title-2">
												<?php echo esc_html($emergency_title); ?>
											</h3>
										<?php endif; ?>

										<?php if ($emergency_descr): ?>
											<div class="hints-first-actions__emergency-descr descr">
												<?php echo wp_kses_post($emergency_descr); ?>
											</div>
										<?php endif; ?>

										<?php if ($phone): ?>
											<div class="hints-first-actions__emergency-phone">

												<?php if ($emergency_phone_first_label): ?>
													<p class="hints-first-actions__emergency-phone-label label">
														<?php echo esc_html($emergency_phone_first_label); ?>
													</p>
												<?php endif; ?>
												<a class="hints-first-actions__emergency-phone-link"
													href="tel:+<?php echo esc_attr(correct_phone($phone)); ?>">
													<?php echo esc_html($phone); ?>
												</a>

												<?php if ($phone_badge): ?>
													<div class="hints-first-actions__emergency-phone-meta">
														<?php if ($emergency_phone_label): ?>
															<p class="hints-first-actions__emergency-phone__label ">
																<?php echo esc_html($emergency_phone_label); ?>
															</p>
														<?php endif; ?>
														<span class="hints-first-actions__emergency-badge">
															<?php echo esc_html($phone_badge); ?>
														</span>
													</div>
												<?php endif; ?>
											</div>
										<?php endif; ?>
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