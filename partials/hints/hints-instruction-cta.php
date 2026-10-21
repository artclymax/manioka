<?php
$page = $args['page'] ?? get_queried_object();
$title = get_field('hints_cta_title', $page) ?? '';
$descr = get_field('hints_cta_descr', $page) ?? '';
$phones = get_field('hints_cta_phone', $page) ?? get_field('contacts_phones', 'option')[0]['phone'] ?? [];
$phone_label = get_field('contacts_phone_label', 'option') ?? 'A1 • MTC • life';
$phone_badge = get_field('contacts_phone_badge', 'option') ?? '24/7';

?>

<?php if ($title || $descr || !empty($phones)): ?>
	<section class="section hints-instruction-cta" id="hints-instruction-cta">
		<div class="container hints-instruction-cta__container">

			<!-- Левая колонка: текст -->
			<?php if ($title || $descr): ?>
				<div class="hints-instruction-cta__content">
					<?php if ($title): ?>
						<h2 class="hints-instruction-cta__title title-3">
							<?php echo esc_html($title); ?>
						</h2>
					<?php endif; ?>

					<?php if ($descr): ?>
						<div class="hints-instruction-cta__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Правая колонка: телефон -->
			<?php if (!empty($phones)): ?>
				<div class="hints-instruction-cta__phone icon icon--phone">
					<div class="hints-instruction-cta__phone-wrapper">
						<a class="hints-instruction-cta__phone-link" href="tel:<?php echo esc_attr(correct_phone($phones)); ?>">
							<?php echo esc_html($phones); ?>
						</a>
						<?php if ($phone_label || $phone_badge): ?>
							<div class="hints-instruction-cta__phone-meta">
								<?php if ($phone_label): ?>
									<span class="hints-instruction-cta__operators">
										<?php echo esc_html($phone_label); ?>
									</span>
								<?php endif; ?>
								<?php if ($phone_badge): ?>
									<span class="hints-instruction-cta__badge">
										<?php echo esc_html($phone_badge); ?>
									</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>