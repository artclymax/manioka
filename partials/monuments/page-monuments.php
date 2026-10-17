<?php
$term = get_queried_object();

// Безопасное получение ID текущей категории (защита от ошибки на главной странице архива)
$current_term_id = (is_a($term, 'WP_Term')) ? $term->term_id : 0;

// Получаем все категории памятников
$all_categories = get_terms([
	'taxonomy' => 'monuments_cat',
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
]);

if (is_wp_error($all_categories)) {
	$all_categories = [];
}

// Ссылка на главный архив памятников
$archive_link = get_post_type_archive_link('monuments');
$is_archive = is_post_type_archive('monuments');
?>

<section class="section page-monuments" id="page-monuments">
	<div class="container page-monuments__container section-gap">
		<div class="page-monuments__hero taxonomy-product-page-hero">
			<!-- Навигация по категориям -->
			<?php if (!empty($all_categories)): ?>
				<div class="page-monuments__nav taxonomy-product-page-hero__nav">

					<!-- Ссылка "Все модели" -->
					<?php if ($archive_link): ?>
						<a class="page-monuments__nav-link taxonomy-product-page-hero__nav-link<?php echo $is_archive ? ' active-category' : ''; ?>"
							href="<?php echo esc_url($archive_link); ?>">
							<?php esc_html_e('Все модели', 'textdomain'); ?>
						</a>
					<?php endif; ?>

					<!-- Ссылки на категории -->
					<?php if (!empty($all_categories)): ?>
						<?php foreach ($all_categories as $cat):
							$cat_link = get_term_link($cat);
							if (is_wp_error($cat_link))
								continue;
							$is_active = $cat->term_id === $current_term_id ? ' active-category' : '';
							?>
							<a class="page-monuments__nav-link taxonomy-product-page-hero__nav-link<?php echo esc_attr($is_active); ?>"
								href="<?php echo esc_url($cat_link); ?>">
								<?php echo esc_html($cat->name); ?>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Сетка памятников -->
		<?php if (have_posts()): ?>
			<div class="page-monuments__grid grid taxonomy-product-page__grid">
				<?php while (have_posts()):
					the_post();
					get_template_part('partials/monuments/monument-card');
				endwhile; ?>
			</div>

			<!-- Пагинация -->
			<div class="page-monuments__pagination taxonomy-product-page__pagination">
				<?php
				$next_link = get_next_posts_link(__('Показать больше', 'textdomain'));
				$prev_link = get_previous_posts_link(__('Вернуться назад', 'textdomain'));

				if ($next_link || $prev_link):
					?>
					<div class="page-monuments__pagination-inner taxonomy-product-page__pagination-inner">
						<?php if ($prev_link): ?>
							<div class="page-monuments__pagination-prev taxonomy-product-page__pagination-prev">
								<?php echo $prev_link; ?>
							</div>
						<?php endif; ?>

						<?php if ($next_link): ?>
							<div class="page-monuments__pagination-next taxonomy-product-page__pagination-next">
								<?php echo $next_link; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="page-monuments__empty taxonomy-product-page__empty">
				<p class="title-4"><?php esc_html_e('В этой категории пока нет памятников.', 'textdomain'); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>