<?php
$page = $args['page'] ?? get_queried_object();
$class = $args['class'] ?? '';

$top_label = get_field('hints_instruction_top_label', $page) ?? '';
$title = get_field('hints_instruction_title', $page) ?? '';
$descr = get_field('hints_instruction_descr', $page) ?? '';
$btn_call = get_field('hints_instruction_btn_call', $page) ?? [];
$btn_instruction = get_field('hints_instruction_btn_instruction', $page) ?? [];

$emergency_label = get_field('hints_emergency_label', $page) ?? '';
$emergency_title = get_field('hints_emergency_title', $page) ?? '';
$emergency_descr = get_field('hints_emergency_descr', $page) ?? '';
$emergency_numbers = get_field('hints_emergency_numbers', $page) ?? [];
$emergency_note = get_field('hints_emergency_note', $page) ?? '';

$phone = get_field('contacts_phones', 'option')[0]['phone'] ?? '';
?>

<?php if ($title || $descr || $emergency_title): ?>
	<section class="hero-hints-instruction <?php echo esc_attr($class); ?>" id="hero-hints-instruction">
		<div class="hero-hints-instruction__container">
			<!-- Левая колонка -->
			<div class="hero-hints-instruction__left">
				<div class="hero-hints-instruction__breadcrumbs">
					<div class="page-breadcrumbs">
						<?php if (function_exists('bcn_display')) {
							bcn_display();
						} ?>
					</div>
				</div>

				<?php get_template_part('partials/section-header', null, [
					'label' => $top_label,
					'title' => $title,
					'descr' => $descr,
					'title_tag' => 'h1',
				]); ?>

				<div class="hero-hints-instruction__buttons">
					<?php if (!empty($btn_call['url']) || $phone): ?>
						<a class="hero-hints-instruction__btn hero-hints-instruction__btn--call btn btn--dark"
							href="tel:<?php echo esc_attr(correct_phone($phone)); ?>">
							<?php echo esc_html($btn_call['title'] ?? 'Позвонить ' . $phone); ?>
						</a>
					<?php endif; ?>

					<?php if (!empty($btn_instruction['url'])): ?>
						<a class="hero-hints-instruction__btn hero-hints-instruction__btn--instruction btn btn--outline"
							href="<?php echo esc_url($btn_instruction['url']); ?>">
							<?php echo esc_html($btn_instruction['title'] ?? 'Перейти к инструкции'); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<!-- Правая колонка: экстренные номера -->
			<?php if ($emergency_title || $emergency_descr || !empty($emergency_numbers)): ?>
				<div class="hero-hints-instruction__right">
					<?php if ($emergency_label): ?>
						<div class="hero-hints-instruction__emergency-label label">
							<?php echo esc_html($emergency_label); ?>
						</div>
					<?php endif; ?>

					<?php if ($emergency_title): ?>
						<h2 class="hero-hints-instruction__emergency-title title-2">
							<?php echo esc_html($emergency_title); ?>
						</h2>
					<?php endif; ?>

					<?php if ($emergency_descr): ?>
						<div class="hero-hints-instruction__emergency-descr descr">
							<?php echo wp_kses_post($emergency_descr); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($emergency_numbers)): ?>
						<ul class="hero-hints-instruction__emergency-list">
							<?php foreach ($emergency_numbers as $item):
								$number = $item['number'] ?? '';
								$label = $item['label'] ?? '';
								if (!$number)
									continue;
								?>
								<li class="hero-hints-instruction__emergency-item">
									<a class="hero-hints-instruction__emergency-link" href="tel:<?php echo esc_attr($number); ?>">
										<span class="hero-hints-instruction__emergency-number title-2">
											<?php echo esc_html($number); ?>
										</span>
										<?php if ($label): ?>
											<span class="hero-hints-instruction__emergency-text">
												<?php echo esc_html($label); ?>
											</span>
										<?php endif; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ($emergency_note): ?>
						<div class="hero-hints-instruction__emergency-note descr">
							<?php echo wp_kses_post($emergency_note); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>