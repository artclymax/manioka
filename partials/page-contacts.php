<?php

$page = get_queried_object();
$top_label = get_field('contacts_top_label', $page) ?: get_field('contacts_top_label', 'option') ?? '';
$title = get_field('contacts_title', $page) ?: get_field('contacts_title', 'option') ?? get_the_title();
$descr = get_field('contacts_descr', $page) ?: get_field('contacts_descr', 'option') ?? '';
$phones = get_field('contacts_phones', 'option') ?? [];
$phone_label = get_field('contacts_phone_label', 'option') ?? 'A1 • MTC • life';
$phone_badge = get_field('contacts_phone_badge', 'option') ?? '24/7';
$address = get_field('contacts_address', 'option') ?? '';
$map = get_field('contacts_map', 'option') ?? '';
?>

<section class="page-contacts" id="page-contacts">
	<div class="container page-contacts__container">
		<!-- Хлебные крошки -->
		<div class="page-contacts__breadcrumbs">
			<div class="page-breadcrumbs">
				<?php if (function_exists('bcn_display')) {
					bcn_display();
				} ?>
			</div>
		</div>

		<div class="page-contacts__grid">
			<div class="page-contacts__left">
				<?php if ($top_label || $title || $descr): ?>
					<?php get_template_part('partials/section-header', null, [
						'label' => $top_label,
						'title' => $title,
						'descr' => $descr,
						'title_class' => 'title-1',
						'title_tag' => 'h1',
					]); ?>
				<?php endif; ?>
			</div>

			<!-- Правая колонка: контакты -->
			<div class="page-contacts__right">
				<?php if (!empty($phones)): ?>
					<div class="page-contacts__phone icon icon--phone">
						<div class="page-contacts__phone-wrapper">
							<div class="page-contacts__phone-list">
								<?php foreach ($phones as $phone): ?>
									<a class="page-contacts__phone-link"
										href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
										aria-label="Телефон: <?php echo esc_attr($phone['phone']); ?>">
										<?php echo esc_html($phone['phone']); ?>

									</a>
								<?php endforeach; ?>
							</div>
							<?php if ($phone_label || $phone_badge): ?>
								<div class="page-contacts__phone-meta">
									<?php if ($phone_label): ?>
										<span class="page-contacts__operators">
											<?php echo esc_html($phone_label); ?>
										</span>
									<?php endif; ?>
									<?php if ($phone_badge): ?>
										<span class="page-contacts__badge">
											<?php echo esc_html($phone_badge); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($address): ?>
					<div class="page-contacts__address">
						<?php get_template_part('partials/components/address', null, [
							'class' => 'page-contacts__address-text',
							'is_address' => true,
							'descr' => $address
						]); ?>
					</div>
				<?php endif; ?>

				<?php get_template_part('partials/components/socials', null, [
					'class' => 'page-contacts__socials'
				]); ?>
			</div>
		</div>

		<?php if ($map): ?>
			<div class="page-contacts__map">
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