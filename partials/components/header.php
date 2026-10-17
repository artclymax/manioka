<?php
$header_class = $args['class'] ?? '';

$logo = get_field('header_logo', 'option') ?? [];
$phone = get_field('header_phone', 'option') ?: (get_field('contacts_phones', 'option')[0]['phone'] ?? '');
$phone_label = get_field('header_phone_label', 'option') ?? 'A1 • МТС • life';
$phone_badge = get_field('header_phone_badge', 'option') ?? '24/7';
$btn = get_field('header_btn', 'option') ?? [];
$socials_text = get_field('header_socials_text', 'option') ?? '';
$cities = get_field('header_cities', 'option') ?? [];
?>

<header class="header <?php echo esc_attr($header_class); ?>" data-auto-calc="header, height">
	<div class="header__container container">
		<!-- logo -->
		<div class="header__logo logo">
			<?php mx_logo($logo); ?>
		</div>

		<!-- menu -->
		<nav class="header__menu header-menu" aria-label="Главное меню">
			<div class="header-menu__wrapper">
				<div class="header-menu__main-menu">
						<?php
						wp_nav_menu([
							'theme_location' => 'header-menu',
							'container' => false,
							'menu_class' => 'header-menu__list',
							'fallback_cb' => false,
							'depth' => 1,
						]);
						?>
				</div>
				<!-- phone -->
					<?php if ($phone): ?>
					<div class="header-menu__phone header-phone hidden-tablet">
						<a class="header-phone__number icon icon--phone"
							href="tel:+<?php echo esc_attr(correct_phone($phone)); ?>"
							aria-label="Телефон: <?php echo esc_attr($phone); ?>">
							<span class="header-phone__value link">
									<?php echo esc_html($phone); ?>
							</span>
						</a>
						<div class="header-phone__meta">
							<span class="header-phone__operators">
									<?php echo esc_html($phone_label); ?>
							</span>
								<?php if ($phone_badge): ?>
								<span class="header-phone__badge">
										<?php echo esc_html($phone_badge); ?>
								</span>
								<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>

				<div class="header-menu__contacts-box visible-tablet">
						<?php if (!empty($btn['url'])): ?>
						<a class="header-menu__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?> target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn['title']); ?>
						</a>
						<?php endif; ?>

					<div class="header-menu__socials socials-box">
							<?php if ($socials_text): ?>
							<p class="socials-box__title">
									<?php echo esc_html($socials_text); ?>
							</p>
							<?php endif; ?>
							<?php get_template_part('partials/components/socials'); ?>
					</div>

						<?php if (!empty($cities)): ?>
						<ul class="header-menu__cities">
								<?php foreach ($cities as $item):
									$city = $item['city'] ?? '';
									if (!$city)
										continue;
									?>
								<li class="header-menu__city">
										<?php echo esc_html($city); ?>
								</li>
								<?php endforeach; ?>
						</ul>
						<?php endif; ?>
				</div>
			</div>
		</nav>

		<?php if ($phone): ?>
			<a class="header__phone visible-tablet" href="tel:+<?php echo esc_attr(correct_phone($phone)); ?>"
				aria-label="Телефон: <?php echo esc_attr($phone); ?>">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"
					aria-hidden="true">
					<path
						d="M14.9669 11.5669C14.8037 11.3932 14.2278 10.8794 13.169 10.1997C12.1025 9.51411 11.3159 9.08661 11.0903 8.98692C11.0704 8.9781 11.0485 8.97486 11.0269 8.97756C11.0053 8.98026 10.9849 8.98879 10.9678 9.00223C10.6044 9.28567 9.99248 9.80629 9.95966 9.83442C9.74779 10.016 9.74779 10.016 9.57435 9.95942C9.26935 9.85942 8.32185 9.35629 7.49623 8.52879C6.6706 7.70129 6.14154 6.73036 6.04154 6.42567C5.98435 6.25192 5.98435 6.25192 6.16654 6.04004C6.19466 6.00723 6.7156 5.39536 6.99904 5.03223C7.01248 5.01513 7.02101 4.99469 7.02371 4.97311C7.02641 4.95152 7.02317 4.92961 7.01435 4.90973C6.91467 4.68379 6.48716 3.89754 5.80154 2.83098C5.12091 1.77254 4.60779 1.1966 4.43404 1.03348C4.4181 1.01843 4.39839 1.00797 4.37699 1.00318C4.3556 0.998398 4.33331 0.999472 4.31248 1.00629C3.70513 1.21501 3.11912 1.48132 2.56248 1.80161C2.02511 2.11399 1.51636 2.47319 1.04216 2.87504C1.02561 2.88912 1.0132 2.90743 1.00626 2.92802C0.999327 2.94861 0.998126 2.9707 1.00279 2.99192C1.0681 3.29629 1.38029 4.56692 2.34904 6.32692C3.33748 8.12317 4.02248 9.04348 5.47404 10.49C6.9256 11.9366 7.87498 12.6629 9.6731 13.6513C11.4331 14.62 12.7044 14.9325 13.0081 14.9972C13.0294 15.0019 13.0515 15.0006 13.0721 14.9937C13.0928 14.9868 13.1111 14.9744 13.1253 14.9579C13.5271 14.4837 13.8862 13.9749 14.1984 13.4375C14.5186 12.8809 14.785 12.2949 14.9937 11.6875C15.0004 11.6669 15.0014 11.6448 14.9967 11.6236C14.992 11.6024 14.9817 11.5828 14.9669 11.5669V11.5669Z"
						fill="currentColor" />
				</svg>
			</a>
		<?php endif; ?>

		<button class="header__burger-btn burger-btn visible-tablet" type="button" aria-label="Открыть меню">
			<span></span>
		</button>
	</div>
</header>