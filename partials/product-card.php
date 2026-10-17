<?php
$product_id = get_the_ID();
$product = wc_get_product($product_id);
if (!$product)
	return;

$thumb_id = $product->get_image_id();
$title = get_the_title();
$link = get_permalink();

$attributes = [];

$wc_attributes = $product->get_attributes();
foreach ($wc_attributes as $attribute) {
	if (!$attribute->get_visible())
		continue;
	if (count($attributes) >= 3)
		break;

	$values = $attribute->is_taxonomy()
		? wc_get_product_terms($product_id, $attribute->get_name(), ['fields' => 'names'])
		: $attribute->get_options();

	if (!empty($values)) {
		$attributes[] = [
			'key' => wc_attribute_label($attribute->get_name()),
			'value' => implode(', ', $values),
		];
	}
}

if (count($attributes) < 3) {
	$acf_attributes = get_field('product_attributes', $product_id) ?? [];
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