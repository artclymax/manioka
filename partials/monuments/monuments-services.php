<?php
$page = $args['page'] ?? get_queried_object();
$cards = get_field('monuments_services_cards', $page) ?? [];
?>

<?php if (!empty($cards)): ?>
	<section class="section monuments-services" id="monuments-services">
		<div class="container monuments-services__container">
			<div class="monuments-services__grid grid">
				<?php foreach ($cards as $card):
					$title = $card['title'] ?? '';
					$descr = $card['descr'] ?? '';
					$link = $card['link'] ?? [];
					$image = $card['image'] ?? null;
					$is_dark = $card['is_dark'] ?? 0;
					$has_content = $title || $descr;

					if (!$has_content)
						continue;

					$has_image = $image && is_array($image) && !empty($image['ID']);
					$card_class = 'monuments-services__card monuments-card';
					if ($has_image)
						$card_class .= ' monuments-card--with-image';
					if ($is_dark)
						$card_class .= ' monuments-card--dark';
					$wrapper_tag = (!empty($link['url'])) ? 'a' : 'div';
					$wrapper_attrs = '';

					if ($wrapper_tag === 'a') {
						$wrapper_attrs = sprintf(
							'href="%s"%s',
							esc_url($link['url']),
							!empty($link['target']) ? sprintf(' target="%s"', esc_attr($link['target'])) : ''
						);
					}
					?>
					<<?php echo $wrapper_tag; ?> class="
						<?php echo esc_attr($card_class); ?>"
						<?php echo $wrapper_attrs; ?>>
						<?php if ($has_image): ?>
							<div class="monuments-card__image image-box">
								<?php echo wp_get_attachment_image($image['ID'], 'large', false, [
									'class' => 'img',
									'alt' => $image['alt'] ?: $title,
									'loading' => 'lazy'
								]); ?>
							</div>
						<?php endif; ?>

						<div class="monuments-card__content">
							<?php if ($title): ?>
								<h3 class="monuments-card__title title-3">
									<?php echo esc_html($title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($descr): ?>
								<div class="monuments-card__descr descr">
									<?php echo wp_kses_post($descr); ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($link['title'])): ?>
								<span class="monuments-card__link-text btn-link">
									<?php echo esc_html($link['title']); ?>
								</span>
							<?php endif; ?>
						</div>
					</<?php echo $wrapper_tag; ?>>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>