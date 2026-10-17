<?php
/*
Template Name: Главная страница (home)
*/
?>
<?php get_header();
get_template_part('partials/home/home-hero');
get_template_part('partials/home/section-hints');
get_template_part('partials/home/home-services');
get_template_part('partials/home/process');
get_template_part('partials/home/home-categories');
get_template_part('partials/home/section-monuments');
get_template_part('partials/home/why-us');
get_template_part('partials/home/project-gallery');
get_template_part('partials/reviews');
get_template_part('partials/home/hints-block');
get_template_part('partials/contacts-block');
get_footer(); ?>