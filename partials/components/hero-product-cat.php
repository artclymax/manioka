<?php
/**
 * Template: Hero Product Category
 */

$class = $args['class'] ?? '';

// Получаем текущий объект (термин или страницу)
$term = get_queried_object();
if (!empty($args['page'])) {
	$term = get_page_by_path($args['page'], OBJECT, 'page');
}

// Инициализация переменных с фоллбэками
$title = get_field('hero_title', $term) ?: $term->name ?? '';
$descr = get_field('hero_descr', $term) ?: ($term->description ?? '');
$image = get_field('hero_image', $term) ?? null;

// Если изображение не задано в ACF, пробуем использовать thumbnail категории
if (!$image && is_tax('product_cat') && !empty($term->term_id)) {
	$thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
	if (!empty($thumbnail_id)) {
		$image = [
			'ID' => $thumbnail_id,
			'url' => wp_get_attachment_url($thumbnail_id),
			'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true),
		];
	}
}
?>

<?php if ($title || $descr || ($image && !empty($image['ID']))): ?>
	<section class="hero-product-cat <?php echo esc_attr($class); ?>" id="hero-product-cat">
		<div class="un-container un-container--reverse hero-product-cat__container">
			<div class="un-container__content hero-product-cat__content">
				<div class="hero-product-cat__breadcrumbs page-breadcrumbs">
					<?php if (function_exists('bcn_display')) {
						bcn_display();
					} ?>
				</div>

				<div class="hero-product-cat__wrapper">
					<?php if ($title): ?>
						<h1 class="hero-product-cat__title title-2 title-decor">
							<?php echo esc_html($title); ?>
						</h1>
					<?php endif; ?>

					<?php if ($descr): ?>
						<div class="hero-product-cat__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>
				</div>

				<a class="hero-product-cat__link" href="#category-catalog" aria-label="Прокрутить к каталогу">
					<svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg"
						aria-hidden="true">
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M11.6931 30.8884C12.8463 29.7351 14.7162 29.7351 15.8694 30.8884L31.5 46.519L47.1306 30.8884C48.2838 29.7351 50.1537 29.7351 51.3069 30.8884C52.4602 32.0417 52.4602 33.9115 51.3069 35.0647L33.5882 52.7835C32.4349 53.9368 30.5651 53.9368 29.4118 52.7835L11.6931 35.0647C10.5398 33.9115 10.5398 32.0417 11.6931 30.8884Z"
							fill="currentColor" />
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M31.5 9.35156C33.131 9.35156 34.4531 10.6737 34.4531 12.3047V48.2344C34.4531 49.8653 33.131 51.1875 31.5 51.1875C29.869 51.1875 28.5469 49.8653 28.5469 48.2344V12.3047C28.5469 10.6737 29.869 9.35156 31.5 9.35156Z"
							fill="currentColor" />
					</svg>
				</a>
			</div>
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="un-container__full hero-product-cat__image image-box">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'full',
						false,
						[
							'class' => 'img',
							'alt' => $image['alt'] ?: $title,
							'loading' => 'eager'
						]
					); ?>
				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>