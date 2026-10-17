<?php
/*
Template Name: Магазин
*/
?>
<?php get_header();
get_template_part('partials/components/hero-page', null, ['page' => 'shop']);
get_template_part('partials/page-shop');
get_template_part('partials/contacts-block');
get_footer(); ?>