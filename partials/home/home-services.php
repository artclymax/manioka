<?php
$page = get_queried_object();
$top_label = get_field('home_services_top_label', $page) ?? '';
$title = get_field('home_services_title', $page) ?? '';
$descr = get_field('home_services_descr', $page) ?? '';
$cards = get_field('home_services_cards', $page) ?? [];
?>

<?php if ($title || $descr || !empty($cards)): ?>
	<section class="section home-services" id="home-services">
		<div class="container home-services__container">
			<?php if ($top_label || $title || $descr): ?>
				<div class="home-services__header"> <?php if ($top_label): ?>
						<div class="home-services__top-label label">
							<?php echo esc_html($top_label); ?>
						</div>
					<?php endif; ?>
					<div class="home-services__header-content">

						<?php if ($title): ?>
							<h2 class="home-services__title title-1">
								<?php echo esc_html($title); ?>
							</h2>
						<?php endif; ?>

						<?php if ($descr): ?>
							<div class="home-services__descr descr">
								<?php echo wp_kses_post($descr); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($cards)): ?>
				<div class="home-services__grid">
					<?php foreach ($cards as $index => $card):
						$card_image = $card['image'] ?? null;
						$card_number = ++$index > 9 ? $index : '0' . $index;
						$card_title = $card['title'] ?? '';
						$card_descr = $card['descr'] ?? '';
						$card_link = $card['link'] ?? [];
						$card_style = $card['style'] ?? 'light';

						if (!$card_title && !$card_descr)
							continue;

						$has_image = $card_image && is_array($card_image) && !empty($card_image['ID']);
						$modifier_class = $card_style === 'dark' ? ' home-services-card--dark' : ' home-services-card--light';
						if ($has_image && $card_style !== 'dark')
							$modifier_class .= ' home-services-card--with-image';
						?>
						<?php if (!empty($card_link['url'])): ?>
							<a class="home-services__card home-services-card<?php echo esc_attr($modifier_class); ?>"
								href="<?php echo esc_url($card_link['url']); ?>" <?php if (!empty($card_link['target'])): ?> target="
				<?php echo esc_attr($card_link['target']); ?>" <?php endif; ?>>
							<?php else: ?>
								<div class="home-services__card home-services-card<?php echo esc_attr($modifier_class); ?>">
								<?php endif; ?>

								<?php if ($has_image): ?>
									<div class="home-services-card__image image-box">
										<?php echo wp_get_attachment_image($card_image['ID'], 'large', false, [
											'class' => 'img',
											'alt' => $card_image['alt'] ?: $card_title,
											'loading' => 'lazy'
										]); ?>
									</div>
								<?php endif; ?>

								<div class="home-services-card__content">
									<?php if ($card_number): ?>
										<div class="home-services-card__number text-number">
											<?php echo esc_html($card_number); ?>
										</div>
									<?php endif; ?>

									<?php if ($card_title): ?>
										<h3 class="home-services-card__title title-3">
											<?php echo esc_html($card_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($card_descr): ?>
										<div class="home-services-card__descr descr">
											<?php echo wp_kses_post($card_descr); ?>
										</div>
									<?php endif; ?>

									<?php if (!empty($card_link['url']) && !empty($card_link['title'])): ?>
										<span class="home-services-card__link-text btn-link">
											<?php echo esc_html($card_link['title']); ?>
										</span>
									<?php endif; ?>
								</div>

								<?php if (!empty($card_link['url'])): ?>
							</a>
						<?php else: ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	</section>
<?php endif; ?>