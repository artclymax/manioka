<?php
$page = $args['page'] ?? get_queried_object();
$page_default = 'option';

$label = get_field('monuments_design_top_label', $page) ?: get_field('monuments_design_top_label', $page_default) ?? '';
$title = get_field('monuments_design_title', $page) ?: get_field('monuments_design_title', $page_default) ?? '';
$cards = get_field('monuments_design_cards', $page) ?: get_field('monuments_design_cards', $page_default) ?? [];
?>

<?php if ($title || !empty($cards)): ?>
	<section class="section monuments-design" id="monuments-design">
		<div class="container monuments-design__container section-gap">
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'title_class' => 'title-3'
			]); ?>

			<?php if (!empty($cards)): ?>
				<div class="monuments-design__grid grid">
					<?php foreach ($cards as $card):
						$image = $card['image'] ?? null;
						$title = $card['title'] ?? '';
						$descr = $card['descr'] ?? '';

						if (!$title && !$descr)
							continue;

						$has_image = $image && is_array($image) && !empty($image['ID']);
						?>
						<div class="monuments-design__card monuments-design-card">
							<?php if ($has_image): ?>
								<div class="monuments-design-card__image image-box">
									<?php echo wp_get_attachment_image($image['ID'], 'large', false, [
										'class' => 'img',
										'alt' => $image['alt'] ?: $title,
										'loading' => 'lazy'
									]); ?>
								</div>
							<?php endif; ?>

							<div class="monuments-design-card__content">
								<?php if ($title): ?>
									<h3 class="monuments-design-card__title title-3">
										<?php echo esc_html($title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($descr): ?>
									<div class="monuments-design-card__descr descr">
										<?php echo wp_kses_post($descr); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>