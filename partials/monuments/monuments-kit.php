<?php
$page = $args['page'] ?? get_queried_object();
$default_page = 'option';
$top_label = get_field('monuments_kit_top_label', $page) ?: get_field('monuments_kit_top_label', $default_page) ?? '';
$title = get_field('monuments_kit_title', $page) ?: get_field('monuments_kit_title', $default_page) ?? '';
$items = get_field('monuments_kit_items', $page) ?: get_field('monuments_kit_items', $default_page) ?? [];
?>

<?php if ($title || !empty($items)): ?>
	<section class="section monuments-kit" id="monuments-kit">
		<div class="container monuments-kit__container">
			<div class="monuments-kit__grid">
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
					'title_class' => 'title-3'
				]); ?>

				<?php if (!empty($items)): ?>
					<ul class="monuments-kit__list">
						<?php foreach ($items as $item):
							$link_url = $item['link']['url'] ?? '';
							$link_text = $item['link']['title'] ?? $item['text'] ?? '';

							if (!$link_text)
								continue;
							?>
							<li class="monuments-kit__item">
								<?php if ($link_url): ?>
									<a class="monuments-kit__link link" href="<?php echo esc_url($link_url); ?>">
										<?php echo esc_html($link_text); ?>
									</a>
								<?php else: ?>
									<span class="monuments-kit__text">
										<?php echo esc_html($link_text); ?>
									</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>