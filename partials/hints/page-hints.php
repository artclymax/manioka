<?php
$term = get_queried_object();

// 1. Получаем все категории hints для навигации
$all_categories = get_terms([
	'taxonomy' => 'hints_cat',
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
]);

if (is_wp_error($all_categories)) {
	$all_categories = [];
}

$current_term_id = (is_a($term, 'WP_Term')) ? $term->term_id : 0;
$archive_link = get_post_type_archive_link('hints');
$is_archive = is_post_type_archive('hints');

// 2. Настраиваем кастомный WP_Query
$paged = max(1, get_query_var('paged'));

$args = [
	'post_type' => 'hints', // Замени на 'services', если нужны услуги
	'posts_per_page' => 6,
	'paged' => $paged,
	'orderby' => 'date',  // Используем date, чтобы избежать ошибок с пустым menu_order
	'order' => 'DESC',
];

// Если открыта конкретная категория, добавляем фильтрацию
if ($current_term_id > 0) {
	$args['tax_query'] = [
		[
			'taxonomy' => 'hints_cat',
			'field' => 'term_id',
			'terms' => $current_term_id,
		]
	];
}

$hints_query = new WP_Query($args);
?>

<section class="section page-hints" id="page-hints">
	<div class="container page-hints__container section-gap">
		<!-- Навигация по категориям -->
		<div class="page-hints__nav">
			<?php if ($archive_link): ?>
				<a class="page-hints__nav-link<?php echo $is_archive ? ' active-category' : ''; ?>"
					href="<?php echo esc_url($archive_link); ?>">
					<?php esc_html_e('Все материалы', 'textdomain'); ?>
				</a>
			<?php endif; ?>

			<?php if (!empty($all_categories)): ?>
				<?php foreach ($all_categories as $cat):
					$cat_link = get_term_link($cat);
					if (is_wp_error($cat_link))
						continue;
					$is_active = $cat->term_id === $current_term_id ? ' active-category' : '';
					?>
					<a class="page-hints__nav-link<?php echo esc_attr($is_active); ?>" href="<?php echo esc_url($cat_link); ?>">
						<?php echo esc_html($cat->name); ?>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<!-- Сетка записей через кастомный WP_Query -->
		<?php if ($hints_query->have_posts()): ?>
			<div class="page-hints__grid">
				<?php
				$index = 0;
				while ($hints_query->have_posts()):
					$hints_query->the_post();
					$index++;

					$is_featured = $index === 1;
					$hint_id = get_the_ID();
					$thumb_id = get_post_thumbnail_id($hint_id);
					$title = get_the_title();
					$excerpt = get_the_excerpt();
					$link = get_permalink();
					$link_text = get_field('hints_link_text', $hint_id) ?? 'Открыть инструкцию';
					?>
					<a class="page-hints__card hints-card<?php echo $is_featured ? ' hints-card--featured' : ''; ?>"
						href="<?php echo esc_url($link); ?>">
						<?php if ($thumb_id): ?>
							<div class="hints-card__image image-box">
								<?php echo wp_get_attachment_image($thumb_id, 'large', false, [
									'class' => 'img',
									'alt' => $title,
									'loading' => $index <= 3 ? 'eager' : 'lazy'
								]); ?>
							</div>
						<?php endif; ?>

						<div class="hints-card__content">
							<?php if ($title): ?>
								<h3 class="hints-card__title title-4">
									<?php echo esc_html($title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($excerpt): ?>
								<div class="hints-card__descr descr">
									<?php echo wp_kses_post($excerpt); ?>
								</div>
							<?php endif; ?>

							<span class="hints-card__link-text btn-link">
								<?php echo esc_html($link_text); ?>
							</span>
						</div>
					</a>
					<?php
				endwhile;
				// ВАЖНО: сбрасываем данные кастомного запроса
				wp_reset_postdata();
				?>
			</div>

			<!-- Пагинация для кастомного запроса -->
			<div class="page-hints__pagination">
				<?php
				$total_pages = $hints_query->max_num_pages;
				if ($total_pages > 1):
					?>
					<div class="page-hints__pagination-inner">
						<?php
						$prev_link = get_previous_posts_link(__('Вернуться назад', 'textdomain'));
						$next_link = get_next_posts_link(__('Показать больше', 'textdomain'), $total_pages);
						?>
						<?php if ($prev_link): ?>
							<div class="page-hints__pagination-prev">
								<?php echo $prev_link; ?>
							</div>
						<?php endif; ?>

						<?php if ($next_link): ?>
							<div class="page-hints__pagination-next">
								<?php echo $next_link; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="page-hints__empty">
				<p class="title-4">
					<?php esc_html_e('В этой категории пока нет материалов.', 'textdomain'); ?>
				</p>
			</div>
		<?php endif; ?>
	</div>
</section>