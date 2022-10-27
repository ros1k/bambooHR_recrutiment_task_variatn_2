<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="theme-color" content="#fff" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
    <meta name="description" content="<?php if ( is_single() ) {
        single_post_title('', true);
    } else {
        bloginfo('description'); 
    }
    ?>" />
    <?php if (get_field('page-header-bg', 'option')): ?>
        <meta property="og:image"            content="<?php the_field('page-header-bg', 'option'); ?>">
        <meta property="og:image:secure_url" content="<?php the_field('page-header-bg', 'option'); ?>">
        <meta property="og:image:type"       content="image/png">
        <meta property="og:image:width"      content="200">
        <meta property="og:image:height"     content="500">
    <?php elseif (get_field('page-header-bg')): ?>
        <meta property="og:image"            content="<?php the_field('page-header-bg'); ?>">
        <meta property="og:image:secure_url" content="<?php the_field('page-header-bg'); ?>">
        <meta property="og:image:type"       content="image/png">
        <meta property="og:image:width"      content="200">
        <meta property="og:image:height"     content="500">
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php the_field('fav_icon', 'option'); ?>" />
   <!-- --><?php
/*    $fonts = get_field('font', 'option');
    if ($fonts):
        foreach ($fonts as $font):
            echo '<link rel="stylesheet" href="'. $font['google_font_url'] .'"/>';
        endforeach;
    endif;
    */?>
    <link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <?php wp_head(); ?>


</head>


<body>
<header class="main-header">
    <div class="main-menu"><?php include "partials/main-menu.php"; ?></div>
</header>

