<?php
$page = get_queried_object();
$top_label = get_field('hints_block_top_label', $page) ?? '';
$title = get_field('hints_block_title', $page) ?? '';
$descr = get_field('hints_block_descr', $page) ?? '';
$btn = get_field('hints_block_btn', $page) ?? [];
$selected = get_field('hints_block_selected', $page) ?? [];

// Собираем выбранные материалы (макс. 3)
$hint_items = [];
if (!empty($selected)) {
	$posts = is_array($selected) ? $selected : [$selected];

	foreach ($posts as $post) {
		$post_id = is_object($post) ? $post->ID : ($post['ID'] ?? 0);
		if (!$post_id)
			continue;

		$wp_post = get_post($post_id);
		if (!$wp_post || $wp_post->post_type !== 'hints')
			continue;

		$hint_items[] = [
			'id' => $wp_post->ID,
			'title' => get_the_title($wp_post->ID),
			'excerpt' => get_the_excerpt($wp_post->ID),
			'permalink' => get_permalink($wp_post->ID),
			'link_text' => get_field('hints_link_text', $wp_post->ID) ?? '',
		];

		if (count($hint_items) >= 3)
			break;
	}
}
?>

<?php if ($title || $descr || !empty($hint_items)): ?>
	<section class="section hints-block" id="hints-block">
		<div class="container hints-block__container section-gap">
			<?php if ($top_label || $title || $descr): ?>
				<div class="hints-block__header">
					<?php get_template_part('partials/section-header', null, [
						'label' => $top_label,
						'title' => $title,
						'descr' => $descr,
						'title_class' => 'title-2'
					]); ?>

					<?php if (!empty($btn['url'])): ?>
						<a class="hints-block__btn btn-link" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?> target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title'] ?? ''); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($hint_items)): ?>
				<div class="hints-block__grid">
					<?php foreach ($hint_items as $index => $item):
						$is_accent = $index === 0;
						?>
						<a class="hints-block__card hints-card<?php echo $is_accent ? ' hints-card--accent' : ''; ?>"
							href="<?php echo esc_url($item['permalink']); ?>">

							<?php if ($item['title']): ?>
								<h3 class="hints-card__title title-4">
									<?php echo esc_html($item['title']); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item['excerpt']): ?>
								<div class="hints-card__descr descr">
									<?php echo wp_kses_post($item['excerpt']); ?>
								</div>
							<?php endif; ?>

							<?php if ($item['link_text']): ?>
								<span class="hints-card__link-text btn-link">
									<?php echo esc_html($item['link_text']); ?>
								</span>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>