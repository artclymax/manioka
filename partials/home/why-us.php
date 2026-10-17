<?php
$page = get_queried_object();
$top_label = get_field('why_us_top_label', $page) ?? '';
$title = get_field('why_us_title', $page) ?? '';
$descr = get_field('why_us_descr', $page) ?? '';
$advantages = get_field('why_us_advantages', $page) ?? [];
$cities = get_field('why_us_cities', $page) ?? [];
$phone = get_field('why_us_phone', $page) ?: (get_field('contacts_phones', 'option')[0]['phone'] ?? '');
$phone_label = get_field('why_us_phone_label', 'option') ?? 'A1 • МТС • life';
$phone_badge = get_field('why_us_phone_badge', 'option') ?? '24/7';
?>

<?php if ($title || $descr || !empty($advantages) || !empty($cities) || $phone): ?>
	<section class="section why-us" id="why-us">
		<div class="container why-us__container section-gap">
			<div class="why-us__grid section-gap">
				<!-- Левая колонка -->
				<?php get_template_part('partials/section-header', null, [
					'label' => $top_label,
					'title' => $title,
					'descr' => $descr,
					'title_class' => 'title-2'
				]); ?>

				<!-- Правая колонка: преимущества -->
				<?php if (!empty($advantages)): ?>
					<ul class="why-us__list grid">
						<?php foreach ($advantages as $item):
							$item_title = $item['title'] ?? '';
							$item_descr = $item['descr'] ?? '';
							if (!$item_title && !$item_descr)
								continue;
							?>
							<li class="why-us__item monuments-step">

								<?php if ($item_title): ?>
									<h3 class="monuments-step__title title-4">
										<?php echo esc_html($item_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($item_descr): ?>
									<div class="monuments-step__descr descr">
										<?php echo wp_kses_post($item_descr); ?>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if (!empty($cities) || $phone): ?>
				<div class="why-us__banner hints-banner">
					<?php if (!empty($cities)): ?>
						<div class="hints-banner__geo">
							<div class="hints-banner__geo-label label">
								<?php esc_html_e('География выезда', 'textdomain'); ?>
							</div>
							<div class="hints-banner__cities">
								<?php
								$city_names = array_filter(array_column($cities, 'city'));
								if (!empty($city_names)):
									$escaped = array_map('esc_html', $city_names);
									echo implode(' <span class="hints-banner__city-sep" aria-hidden="true">·</span> ', $escaped);
								endif;
								?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($phone): ?>
						<div class="hints-banner__phone icon icon--phone">
							<a class="hints-banner__phone-link link" href="tel:+<?php echo esc_attr(correct_phone($phone)); ?>"
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