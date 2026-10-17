<?php
$page = get_queried_object();
$top_label = get_field('monuments_top_label', $page) ?? '';
$title = get_field('monuments_title', $page) ?? '';
$descr = get_field('monuments_descr', $page) ?? '';
$btn = get_field('monuments_btn', $page) ?? [];
$image = get_field('monuments_image', $page) ?? null;
$steps = get_field('monuments_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps) || ($image && !empty($image['ID']))): ?>
	<section class="section monuments" id="monuments">
		<div class="container monuments__container section-gap">
			<?php if ($top_label || $title || $descr || !empty($btn['url'])): ?>
				<div class="monuments__header">
					<?php if ($top_label): ?>
						<div class="monuments__top-label label">
							<?php echo esc_html($top_label); ?>
						</div>
					<?php endif; ?>
					<?php if ($title): ?>
						<h2 class="monuments__title title-1">
							<?php echo esc_html($title); ?>
						</h2>
					<?php endif; ?>
					<div class="monuments__header-content">
						<?php if ($descr): ?>
							<div class="monuments__descr descr">
								<?php echo wp_kses_post($descr); ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($btn['url'])): ?>
							<a class="monuments__btn btn-link" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?> target="
					<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn['title'] ?? ''); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="monuments__image image-box">
					<?php echo wp_get_attachment_image($image['ID'], 'large', false, [
						'class' => 'img',
						'alt' => $image['alt'] ?: $title,
						'loading' => 'lazy'
					]); ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($steps)): ?>
				<ul class="monuments__grid grid">
					<?php foreach ($steps as $index => $step):
						$step_title = $step['title'] ?? '';
						$step_descr = $step['descr'] ?? '';
						if (!$step_title && !$step_descr)
							continue;
						?>
						<li class="monuments__step monuments-step">
							<?php if ($step_title): ?>
								<h3 class="monuments-step__title title-4">
									<?php echo esc_html($step_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($step_descr): ?>
								<div class="monuments-step__descr descr">
									<?php echo wp_kses_post($step_descr); ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>