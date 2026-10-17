<?php
$footer_logo = get_field('footer_logo', 'option') ?? '';
$footer_descr = get_field('footer_descr', 'option') ?? '';
$footer_company = get_field('footer_company', 'option') ?: get_bloginfo('name');
$footer_copy = get_field('footer_copy', 'option') ?? '';
$footer_links = get_field('footer_links', 'option') ?? [];
$footer_links_right = get_field('footer_links_right', 'option') ?? [];

// Контакты из опций
$phones = get_field('contacts_phones', 'option') ?? [];
$address = get_field('contacts_address', 'option') ?? '';
$phone_label = get_field('contacts_phone_label', 'option') ?? 'A1 • MTC • life';
$phone_badge = get_field('contacts_phone_badge', 'option') ?? '24/7';
?>

<footer class="footer" id="footer">
	<div class="container footer__container">
		<div class="footer__top">
			<!-- Логотип и описание -->
			<div class="footer__brand">
				<div class="footer__logo logo">
					<?php mx_logo('', $footer_logo); ?>
				</div>
				<?php if ($footer_descr): ?>
					<div class="footer__descr descr">
						<?php echo wp_kses_post($footer_descr); ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Меню навигации -->
			<nav class="footer__nav footer-col">
				<h3 class="footer-col__title title-4">
					<?php esc_html_e('Навигация', 'textdomain'); ?>
				</h3>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu',
					'container' => false,
					'menu_class' => 'footer-menu',
					'depth' => 1,
					'fallback_cb' => false,
				]);
				?>
			</nav>

			<!-- Меню услуг/каталога -->
			<nav class="footer__catalog footer-col">
				<h3 class="footer-col__title title-4">
					<?php esc_html_e('Основные услуги', 'textdomain'); ?>
				</h3>
				<?php
				wp_nav_menu([
					'theme_location' => 'catalog-menu',
					'container' => false,
					'menu_class' => 'footer-menu catalog-menu',
					'depth' => 1,
					'fallback_cb' => false,
				]);
				?>
			</nav>

			<!-- Контакты -->
			<div class="footer__contacts">

				<?php if (!empty($phones)): ?>
					<div class="footer__phone">
						<div class="footer__phone-list">
							<?php foreach ($phones as $phone): ?>
								<a class="footer__phone-link" href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
									aria-label="Телефон: <?php echo esc_attr($phone['phone']); ?>">
									<span class="footer__phone-value">
										<?php echo esc_html($phone['phone']); ?>
									</span>
								</a>
							<?php endforeach; ?>
						</div>
						<?php if ($phone_label || $phone_badge): ?>
							<div class="footer__phone-meta">
								<?php if ($phone_label): ?>
									<span class="footer__operators">
										<?php echo esc_html($phone_label); ?>
									</span>
								<?php endif; ?>
								<?php if ($phone_badge): ?>
									<span class="footer__badge">
										<?php echo esc_html($phone_badge); ?>
									</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ($address): ?>
					<div class="footer__address">
						<?php get_template_part('partials/components/address', null, [
							'class' => 'footer__address-text',
							'is_address' => true,
							'descr' => $address
						]); ?>
					</div>
				<?php endif; ?>

				<?php get_template_part('partials/components/socials', null, [
					'class' => 'footer__socials'
				]); ?>
			</div>
		</div>

		<!-- Нижняя панель -->
		<div class="footer__bottom">
			<div class="footer__bottom-links">
				<?php if (!empty($footer_links)): ?>
					<?php foreach ($footer_links as $item):
						$link = $item['footer_links_link'] ?? [];
						if (empty($link['url']))
							continue;
						?>
						<a class="footer__bottom-link" href="<?php echo esc_url($link['url']); ?>" <?php if (!empty($link['target'])): ?> target="<?php echo esc_attr($link['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($link['title']); ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="footer__copy">
				&copy;
				<?php echo esc_html($footer_company) . ', ' . date('Y') . '.'; ?>
				<?php if ($footer_copy): ?>
					<?php echo esc_html($footer_copy); ?>
				<?php endif; ?>
			</div>
			<div class="footer__bottom-links footer__bottom-links--right">
				<?php if (!empty($footer_links_right)): ?>
					<?php foreach ($footer_links_right as $item):
						$link = $item['footer_links_link'] ?? [];
						if (empty($link['url']))
							continue;
						?>
						<a class="footer__bottom-link" href="<?php echo esc_url($link['url']); ?>" <?php if (!empty($link['target'])): ?> target="<?php echo esc_attr($link['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($link['title']); ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>