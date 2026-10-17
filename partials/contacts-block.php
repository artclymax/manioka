<?php
$page = get_queried_object();
$top_label = get_field('contacts_block_top_label', $page) ?: get_field('contacts_block_top_label', 'option') ?? '';
$title = get_field('contacts_block_title', $page) ?: get_field('contacts_block_title', 'option') ?? '';
$descr = get_field('contacts_block_descr', $page) ?: get_field('contacts_block_descr', 'option') ?? '';
$phones = get_field('contacts_phones', 'option') ?? '';
$phone_label = get_field('contacts_block_phone_label', $page) ?? 'A1 • MTC • life';
$phone_badge = get_field('contacts_block_phone_badge', $page) ?? '24/7';
$address = get_field('contacts_address', 'option') ?? '';
$map = get_field('contacts_map', 'option') ?? '';
?>

<?php if ($title || $descr || $phone || $address || $map): ?>
	<section class="section contacts-block" id="contacts-block">
		<div class="container contacts-block__container">
			<div class="contacts-block__left">
				<?php if ($top_label || $title || $descr): ?>
					<?php get_template_part('partials/section-header', null, [
						'label' => $top_label,
						'title' => $title,
						'descr' => $descr,
						'title_class' => 'title-2'
					]); ?>
				<?php endif; ?>
				<div class="contacts-block__content">
					<?php if ($phones): ?>
						<div class="contacts-block__phone icon icon--phone">
							<div class="contacts-block__phone-wrapper">
								<div class="contacts-block__phone-list">
									<?php foreach ($phones as $phone): ?>
										<a class="contacts-block__phone-link"
											href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
											aria-label="Телефон: <?php echo esc_attr($phone['phone']); ?>">
											<span class="contacts-block__phone-value">
												<?php echo esc_html($phone['phone']); ?>
											</span>
										</a>
									<?php endforeach; ?>
								</div>
								<?php if ($phone_label || $phone_badge): ?>
									<div class="contacts-block__phone-meta">
										<?php if ($phone_label): ?>
											<span class="contacts-block__operators">
												<?php echo esc_html($phone_label); ?>
											</span>
										<?php endif; ?>
										<?php if ($phone_badge): ?>
											<span class="contacts-block__badge">
												<?php echo esc_html($phone_badge); ?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($address): ?>
						<div class="contacts-block__address">
							<?php get_template_part('partials/components/address', null, [
								'class' => 'contacts-block__address-text',
								'is_address' => true,
								'descr' => $address
							]); ?>
						</div>
					<?php endif; ?>

					<?php get_template_part('partials/components/socials', null, [
						'class' => 'contacts-block__socials'
					]); ?>
				</div>
			</div>

			<?php if ($map): ?>
				<div class="contacts-block__map">
					<?php echo wp_kses($map, [
						'iframe' => [
							'src' => true,
							'width' => true,
							'height' => true,
							'style' => true,
							'allowfullscreen' => true,
							'loading' => true,
						],
					]) ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
