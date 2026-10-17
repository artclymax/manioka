<?php
/*
Template Name: Магазин
*/
?>
<?php get_header();
get_template_part('partials/components/hero-page', null, ['page' => 'monuments']);
get_template_part('partials/monuments/page-monuments');
get_template_part('partials/home/project-gallery');
get_template_part('partials/contacts-block');
get_footer(); ?>