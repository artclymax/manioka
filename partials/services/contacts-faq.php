<?php
$page = $args['page'] ?? get_queried_object();
$top_label = get_field('contacts_faq_top_label', $page) ?: get_field('contacts_faq_top_label', 'option') ?? '';
$title = get_field('contacts_faq_title', $page) ?: get_field('contacts_faq_title', 'option') ?? '';
$descr = get_field('contacts_faq_descr', $page) ?: get_field('contacts_faq_descr', 'option') ?? '';
$phones = get_field('contacts_phones', 'option') ?? [];
$phone_label = get_field('contacts_block_phone_label', 'option') ?? 'A1 • MTC • life';
$phone_badge = get_field('contacts_block_phone_badge', 'option') ?? '24/7';
$address = get_field('contacts_address', 'option') ?? '';
$faq_items = get_field('contacts_faq_items', $page) ?: get_field('contacts_faq_items', 'option') ?? [];
?>

<?php if ($title || $descr || !empty($phones) || $address || !empty($faq_items)): ?>
	<section class="section contacts-faq" id="contacts-faq">
		<div class="container contacts-faq__container">
			<!-- Левая колонка: контакты -->
			<div class="contacts-faq__left">
				<?php if ($top_label || $title || $descr): ?>
					<?php get_template_part('partials/section-header', null, [
						'label' => $top_label,
						'title' => $title,
						'descr' => $descr
					]); ?>
				<?php endif; ?>

				<div class="contacts-faq__content">
					<?php if (!empty($phones)): ?>
						<div class="contacts-faq__phone icon icon--phone">
							<div class="contacts-faq__phone-wrapper">
								<div class="contacts-faq__phone-list">
									<?php foreach ($phones as $phone): ?>
										<a class="contacts-faq__phone-link"
											href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
											aria-label="Телефон: <?php echo esc_attr($phone['phone']); ?>">
											<span class="contacts-faq__phone-value">
												<?php echo esc_html($phone['phone']); ?>
											</span>
										</a>
									<?php endforeach; ?>
								</div>
								<?php if ($phone_label || $phone_badge): ?>
									<div class="contacts-faq__phone-meta">
										<?php if ($phone_label): ?>
											<span class="contacts-faq__operators">
												<?php echo esc_html($phone_label); ?>
											</span>
										<?php endif; ?>
										<?php if ($phone_badge): ?>
											<span class="contacts-faq__badge">
												<?php echo esc_html($phone_badge); ?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($address): ?>
						<div class="contacts-faq__address">
							<?php get_template_part('partials/components/address', null, [
								'class' => 'contacts-faq__address-text',
								'is_address' => true,
								'descr' => $address
							]); ?>
						</div>
					<?php endif; ?>

					<?php get_template_part('partials/components/socials', null, [
						'class' => 'contacts-faq__socials'
					]); ?>
				</div>
			</div>

			<!-- Правая колонка: FAQ -->
			<?php if (!empty($faq_items)): ?>
				<div class="contacts-faq__right">
					<div class="contacts-faq__faq-label label">
						<?php esc_html_e('Важно знать', 'textdomain'); ?>
					</div>

					<div class="contacts-faq__faq-list">
						<?php foreach ($faq_items as $index => $item):
							$item_title = $item['title'] ?? '';
							$item_descr = $item['descr'] ?? '';
							if (!$item_title && !$item_descr)
								continue;

							$is_active = $index === 0 ? ' spoiler-active' : '';
							?>
							<div class="faq-item<?php echo esc_attr($is_active); ?>" data-spoiler>
								<button class="faq-item__btn" data-spoiler-title>
									<h3 class="faq-item__title title-4">
										<?php echo esc_html($item_title); ?>
									</h3>
									<span class="faq-item__icon"></span>
								</button>
								<div class="faq-item__content" data-spoiler-content>
									<?php if ($item_descr): ?>
										<div class="faq-item__descr descr">
											<?php echo wp_kses_post($item_descr); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>