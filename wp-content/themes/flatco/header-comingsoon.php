<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?php current_title(); ?>
        <?php favicon(); ?>
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/font-awesome/font-awesome-ie7.min.css"><![endif]-->
        <?php
        wp_head();
        facebookOpenGraphMeta();
        global $tw_end;
        $tw_start = $tw_end = '';
//        if (tw_option('theme_layout') != "Fullwidth") {
//            $tw_start = '<div class="theme-boxed">';
//            $tw_end = '</div>';
//        }
        $bg = post_image_show(0, 0, true);
        ?>
    </head>
    <body <?php body_class() ?>>
        <?php echo $tw_start; ?>
        <!-- Start Main -->
        <section id="main"<?php echo !empty($bg) ? (' style="background:url('.$bg.')"') : '';?>>
            <div <?php echo is_page() ? 'id="page"' : 'class="container"'; ?>>