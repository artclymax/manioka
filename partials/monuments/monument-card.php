<?php
$monument_id = get_the_ID();
$thumb_id = get_post_thumbnail_id($monument_id);
$title = get_the_title();
$link = get_permalink();

// Собираем атрибуты из ACF (максимум 3)
$attributes = [];
$acf_attributes = get_field('monuments_attributes', $monument_id) ?? [];
if (!empty($acf_attributes)) {

	foreach ($acf_attributes as $acf_attr) {
		if (count($attributes) >= 3)
			break;
		$key = $acf_attr['key'] ?? '';
		$value = $acf_attr['value'] ?? '';
		if ($key && $value) {
			$attributes[] = [
				'key' => $key,
				'value' => $value,
			];
		}
	}
}
?>

<div class="product-card">
	<?php if ($thumb_id): ?>
		<a class="product-card__image image-box" href="<?php echo esc_url($link); ?>">
			<?php echo wp_get_attachment_image($thumb_id, 'large', false, [
				'class' => 'img',
				'alt' => $title,
				'loading' => 'lazy'
			]); ?>
		</a>
	<?php endif; ?>

	<div class="product-card__content">
		<?php if ($title): ?>
			<h3 class="product-card__title title-4">
				<a href="<?php echo esc_url($link); ?>">
					<?php echo esc_html($title); ?>
				</a>
			</h3>
		<?php endif; ?>

		<?php if (!empty($attributes)): ?>
			<dl class="product-card__attributes">
				<?php foreach ($attributes as $attr): ?>
					<div class="product-card__attribute">
						<dt class="product-card__attribute-key">
							<?php echo esc_html($attr['key']); ?>
						</dt>
						<dd class="product-card__attribute-value">
							<?php echo esc_html($attr['value']); ?>
						</dd>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>

		<a class="product-card__link btn-link" href="<?php echo esc_url($link); ?>">
			<?php esc_html_e('Подробнее', 'textdomain'); ?>
		</a>
	</div>
</div>