<?php

function theme_option_styles() {

    function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
        //return $rgb; // returns an array with the rgb values
    }
    ?>


    <style>
        body {
            font-family: <?php echo tw_option('body_text_font', 'face'); ?>, Arial, Helvetica, sans-serif;
            font-size: <?php echo tw_option('body_text_font', 'size'); ?>; 
            font-weight: <?php echo tw_option('body_text_font', 'style'); ?>; 
            color: <?php echo tw_option('body_text_font', 'color'); ?>;
            <?php
            if (tw_option('theme_layout') == 'Boxed Layout') {
                if (tw_option('background_color') != "") {
                    echo 'background-color: ' . tw_option('background_color') . ';';
                }
                if (tw_option('background_image') != "") {
                    echo 'background-image: url(' . tw_option('background_image') . ');';
                }
                if (tw_option('background_repeat') != 'Strech Image') {
                    echo 'background-repeat: ' . tw_option('background_repeat') . ';';
                } else {
                    echo '-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;';
                }
                echo "background-attachment: fixed;";
                echo "margin-top:" . tw_option('margin_top') . "px;";
                echo "margin-bottom:" . tw_option('margin_bottom') . "px";
            }
            ?>
        }
        h1,h2,h3,h4,h5,h6,
        .btn,button, .tw-portfolio .tw-filter ul,
        .loop-media blockquote p,
        input[type="submit"],
        input[type="reset"],
        input[type="button"],
        .accordion-heading .accordion-toggle,
        .tw-service-content a,
        .isotope-container .loop-block a.more-link{font-family: <?php echo tw_option('heading_font'); ?>;}
        h1{ font-size: <?php echo tw_option('h1_spec_font', 'size'); ?>; color: <?php echo tw_option('h1_spec_font', 'color'); ?>; }
        h2{ font-size: <?php echo tw_option('h2_spec_font', 'size'); ?>; color: <?php echo tw_option('h2_spec_font', 'color'); ?>; }
        h3{ font-size: <?php echo tw_option('h3_spec_font', 'size'); ?>; color: <?php echo tw_option('h3_spec_font', 'color'); ?>; }
        h4{ font-size: <?php echo tw_option('h4_spec_font', 'size'); ?>; color: <?php echo tw_option('h4_spec_font', 'color'); ?>; }
        h5{ font-size: <?php echo tw_option('h5_spec_font', 'size'); ?>; color: <?php echo tw_option('h5_spec_font', 'color'); ?>; }
        h6{ font-size: <?php echo tw_option('h6_spec_font', 'size'); ?>; color: <?php echo tw_option('h6_spec_font', 'color'); ?>; }

        a,.tw-callout h1 a,#sidebar ul.menu .current_page_item a{ color: <?php echo tw_option('link_color'); ?>; }
        a:hover, a:focus,.loop-meta a:hover,article .loop-content a.more-link:hover{ color: <?php echo tw_option('link_hover_color'); ?>; }

        /* Top Bar ------------------------------------------------------------------------ */

        .tw-top-bar{ background: <?php echo tw_option('top_bar_bg'); ?>;}

        /* Header ------------------------------------------------------------------------ */  
        #header { background-color: <?php echo tw_option('header_background'); ?>; }

        /* Navigation ------------------------------------------------------------------------ */ 

        #header .tw-menu-container{ background-color: <?php echo tw_option('menu_background'); ?>; }
        ul.sf-menu > li a{ font-family: <?php echo tw_option('menu_font', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('menu_font', 'size'); ?>; font-weight: <?php echo tw_option('menu_font', 'style'); ?>; color: <?php echo tw_option('menu_font', 'color'); ?>; }
        ul.sf-menu > li.current-menu-item,ul.sf-menu > li.current_page_item{ background-color: <?php echo tw_option('menu_hover_background'); ?>; }
        ul.sf-menu > li.current-page-item > a,.sf-menu > li.current_page_item > a,#sidebar ul.menu li.current_page_item a,ul.sf-menu > li.current_page_ancestor > a,ul.sf-menu > li.current-menu-ancestor >a, ul.sf-menu > li a:hover,ul.sf-menu > li.current-menu-item > a,ul.sf-menu > li.current-menu-item[class^="fa-"]:before, ul.sf-menu > li.current-menu-item[class*=" fa-"]:before,ul.sf-menu > li.current_page_ancestor[class^="fa-"]:before, ul.sf-menu > li.current_page_ancestor[class*=" fa-"]:before,ul.sf-menu > li:hover > a{ color: <?php echo tw_option('menu_hover'); ?>; }
        ul.sf-menu li ul li { background: <?php echo tw_option('submenu_bg'); ?>; }
        ul.sf-menu li ul li:hover { background: <?php echo tw_option('submenu_hover_background'); ?>; }
        ul.sf-menu li ul li.current-menu-item a,ul.sf-menu li ul li a{ color: <?php echo tw_option('submenu_link'); ?>; }
        ul.sf-menu li ul li a:hover,ul.sf-menu li ul li.current-menu-item a,ul.sf-menu li ul li.current_page_item a{ color: <?php echo tw_option('submenu_hover'); ?>; }

        /* Main ------------------------------------------------------------------------ */  
        #main { background: <?php echo tw_option('body_background'); ?>; }

        /* Footer ------------------------------------------------------------------------ */  

        #footer{ background: <?php echo tw_option('footer_background'); ?>; }
        #footer{ color: <?php echo tw_option('footer_text_color'); ?>; }
        #footer a{ color: <?php echo tw_option('footer_link_color'); ?>; }
        #footer a:hover, #footer .tw-recent-posts-widget h4 a:hover{ color: <?php echo tw_option('footer_link_hover_color'); ?>; }
        #sidebar h3.widget-title, .sidebar-container .tw-title-container h3 { font-family: <?php echo tw_option('sidebar_widgets_title', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('sidebar_widgets_title', 'size'); ?>; font-weight: <?php echo tw_option('sidebar_widgets_title', 'style'); ?>; color: <?php echo tw_option('sidebar_widgets_title', 'color'); ?>; }
        #sidebar a{ color: <?php echo tw_option('sidebar_widgets_title', 'color'); ?>;}
        .sidebar-container .tw-title-container h3 span { color: <?php echo tw_option('sidebar_widgets_title', 'color'); ?>;}
        #footer h3.widget-title { font-family: <?php echo tw_option('footer_widgets_title', 'face'); ?>, Arial, Helvetica, sans-serif; font-size: <?php echo tw_option('footer_widgets_title', 'size'); ?>; font-weight: <?php echo tw_option('footer_widgets_title', 'style'); ?>; color: <?php echo tw_option('footer_widgets_title', 'color'); ?>; }

        /* General Color ------------------------------------------------------------------------ */ 

        ::selection{ background: <?php echo tw_option('primary_color'); ?>; }
        ::-moz-selection{ background: <?php echo tw_option('primary_color'); ?>; }

        .sub-title{color: <?php echo tw_option('body_text_font', 'color'); ?>;}

        .tagcloud a:hover, #footer .tagcloud a:hover,.ui-slider-handle{ background: <?php echo tw_option('primary_color'); ?> !important; }
        button,input[type="submit"],input[type="reset"],input[type="button"],.content-meta,.comment-block .comment span.comment-splash,.tw-pagination.pagination ul>li>a.selected,.tw-coming-soon .days,.tw-coming-soon .hours,.tw-coming-soon .minutes,.tw-coming-soon .seconds,.tw-404-search-container,.woocommerce span.onsale, .woocommerce-page span.onsale,
        .woocommerce a.button.alt, .woocommerce-page a.button.alt, .woocommerce button.button.alt, .woocommerce-page button.button.alt, .woocommerce input.button.alt, .woocommerce-page input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce-page #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page #content input.button.alt{ background: <?php echo tw_option('primary_color'); ?>; }
        .team-member ul.tw-social-icon li a:hover,ul.tw-social-icon li a:hover{ background-color: <?php echo tw_option('primary_color'); ?>; }
        .featured,.tw-dropcap,.progress .bar,div.jp-jplayer.jp-jplayer-video,.pagination ul>li>a.current,.carousel-content .post-format,span.post-format,.tw-author,.nav-tabs>li>a, .tabs-below>.nav-tabs>li>a,blockquote:before{ background-color: <?php echo tw_option('primary_color'); ?>; }
        footer#footer .tw-recent-posts-widget .meta a,.highlight,.tw-top-bar-info a,#bottom a,.tw-title-container h3 span,a.live-preview,h3.error404 span,.total strong,.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price{ color: <?php echo tw_option('primary_color'); ?>; }
        .tw-top-service-text div:last-child,h2.loop-title a:hover,#sidebar a:hover,a.live-preview:hover,.pagination ul>li>a.current, .pagination ul>li>span.current, .pagination ul>li>a:hover,.list_carousel li .carousel-content h3:hover a,h2.portfolio-title a:hover{ color: <?php echo tw_option('primary_color'); ?>; }
        .pagination ul>li>a.current, .pagination ul>li>span.current,.team-member .loop-image,ul.sf-menu > li:hover > a,ul.sf-menu > li.current-menu-item,a.live-preview,.pagination ul>li>a:hover,ul.sf-menu > li.current_page_ancestor{ border-color: <?php echo tw_option('primary_color'); ?>; }
        ul.sf-menu > li.current-page-item,.tw-testimonials .carousel-arrow a.carousel-prev:hover, .tw-testimonials .carousel-arrow a.carousel-next:hover{ background:<?php echo tw_option('primary_color'); ?>; }
        .image-overlay.hover-zoom,.carousel-meta,.team-member .member-title,.accordion-heading .accordion-toggle,#header .tw-logo,#header .tw-logo-bg,.tw-title-border,.loop-block a.more-link,.format-link .loop-media,article .loop-format,.format-quote .loop-media,.btn{background-color:<?php echo tw_option('primary_color'); ?>;}
        .image-overlay{background-color: <?php echo "rgba(" . hex2rgb(tw_option('primary_color')) . ",.7)" ?> ; }
        @media (min-width: 768px) and (max-width: 979px) { 
            header#header,header#header.stuck{ background: <?php echo tw_option('logo_bg') ? tw_option('primary_color') : '#fff'; ?>; }
        }
        @media (min-width: 768px) and (max-width: 979px) { 
            .mobile-menu-icon span{ background: <?php echo tw_option('logo_bg') ? '#fff' : tw_option('primary_color'); ?>; }
        }
        <?php echo tw_option('custom_css'); ?>
    </style>

    <?php
}

add_action('wp_footer', 'theme_option_styles', 100);
?>