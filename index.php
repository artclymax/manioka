<?php get_header();

get_template_part('partials/components/hero-page-simple');

if (have_posts()): ?>
	<?php while (have_posts()):
		the_post(); ?>
		<section class="index-section">
			<div class="container descr ">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endwhile; ?>
<?php else: ?>
	<section class="index-section">
		<div class="container descr ">
			<p>Записей не найдено.</p>
		</div>
	</section>
<?php endif;

get_footer(); ?>