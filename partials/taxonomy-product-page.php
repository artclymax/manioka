<?php
$term = get_queried_object();

// Получаем все категории (исключая misc)
$misc_term = get_term_by('slug', 'misc', 'product_cat');
$exclude_ids = $misc_term ? [$misc_term->term_id] : [];

$all_categories = get_terms([
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'exclude' => $exclude_ids,
]);

if (is_wp_error($all_categories)) {
	$all_categories = [];
}

// Текущая категория
$current_term_id = $term ? $term->term_id : 0;
?>

<section class="section taxonomy-product-page" id="taxonomy-product-page">
	<div class="container taxonomy-product-page__container">
		<div class="taxonomy-product-page__hero taxonomy-product-page-hero">
			<div class="taxonomy-product-page-hero__breadcrumbs">
				<div class="page-breadcrumbs">
					<?php if (function_exists('bcn_display')) {
						bcn_display();
					} ?>
				</div>
			</div>
			<div class="taxonomy-product-page-hero__header">
				<div class="taxonomy-product-page-hero__label label">
					<?php esc_html_e('Ритуальные товары', 'textdomain'); ?>
				</div>
				<?php if ($term): ?>
					<h1 class="taxonomy-product-page-hero__title title-1">
						<?php echo esc_html($term->name); ?>
					</h1>
				<?php endif; ?>
			</div>

			<!-- Навигация по категориям -->
			<?php if (!empty($all_categories)): ?>
				<div class="taxonomy-product-page-hero__nav">
					<?php foreach ($all_categories as $cat):
						$cat_link = get_term_link($cat);
						if (is_wp_error($cat_link))
							continue;
						$is_active = $cat->term_id === $current_term_id ? ' active-category' : '';
						?>
						<a class="taxonomy-product-page-hero__nav-link<?php echo esc_attr($is_active); ?>"
							href="<?php echo esc_url($cat_link); ?>">
							<?php echo esc_html($cat->name); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Сетка товаров -->
		<?php if (have_posts()): ?>
			<div class="taxonomy-product-page__grid grid">
				<?php while (have_posts()):
					the_post();
					get_template_part('partials/product-card');
				endwhile; ?>
			</div>

			<!-- Пагинация -->
			<div class="taxonomy-product-page__pagination">
				<?php
				$next_link = get_next_posts_link(__('Показать больше', 'textdomain'));
				$prev_link = get_previous_posts_link(__('Вернуться назад', 'textdomain'));

				if ($next_link || $prev_link):
					?>
					<div class="taxonomy-product-page__pagination-inner">
						<?php if ($prev_link): ?>
							<div class="taxonomy-product-page__pagination-prev">
								<?php echo $prev_link; ?>
							</div>
						<?php endif; ?>

						<?php if ($next_link): ?>
							<div class="taxonomy-product-page__pagination-next">
								<?php echo $next_link; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="taxonomy-product-page__empty">
				<p class="title-4"><?php esc_html_e('В этой категории пока нет товаров.', 'textdomain'); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>