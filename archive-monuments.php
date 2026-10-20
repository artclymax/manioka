<?php
/*
Template Name: Каталог памятников
*/
?>
<?php get_header();
get_template_part('partials/components/hero-page', null, ['page' => 'monuments']);
get_template_part('partials/monuments/monuments-services', null, ['page' => get_page_by_path('monuments', OBJECT, 'page')]);
get_template_part('partials/monuments/page-monuments');
get_template_part('partials/home/project-gallery');
get_template_part('partials/contacts-block');
get_footer(); ?>