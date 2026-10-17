<?php
/*
Template Name: Услуги
*/
?>
<?php get_header();
get_template_part('partials/components/hero-page', null, ['page' => 'services']);
get_template_part('partials/services/page-services');
get_template_part('partials/services/approach', null, ['page' => get_page_by_path('services', OBJECT, 'page')]);
get_template_part('partials/contacts-block');
get_footer(); ?>