<?php
define('THEME_PATH', get_template_directory());
define('THEME_DIR', get_template_directory_uri());
define('STYLESHEET_PATH', get_stylesheet_directory());
define('STYLESHEET_DIR', get_stylesheet_directory_uri());

require_once (THEME_PATH . "/framework/theme_functions.php");
require_once (THEME_PATH . "/woocommerce/tw_woocommerce.php");
require_once (THEME_PATH . "/framework/googlefonts.php");
require_once (THEME_PATH . "/framework/webink.php");
require_once (THEME_PATH . "/admin/index.php");
require_once (THEME_PATH . "/framework/aq_resizer.php");
require_once (THEME_PATH . "/framework/breadcrumbs.php");
require_once (THEME_PATH . "/framework/sidebar_generator.php");
require_once (THEME_PATH . "/framework/post-type/post-type.php");
require_once (THEME_PATH . "/framework/post-format.php");
require_once (THEME_PATH . "/framework/pagebuilder/pagebuilder.php");
require_once (THEME_PATH . "/framework/shortcode/shortcode.php");
require_once (THEME_PATH . "/framework/widget/recent_posts_widget.php");
require_once (THEME_PATH . "/framework/widget/recent_portfolios_widget.php");
require_once (THEME_PATH . "/framework/widget/dribbble_widget.php");
require_once (THEME_PATH . "/framework/widget/flickr_widget.php");
require_once (THEME_PATH . "/framework/widget/social_links_widget.php");
require_once (THEME_PATH . "/framework/widget/twitter_widget.php");
require_once (THEME_PATH . "/framework/widget/contact_widget.php");
require_once (THEME_PATH . "/framework/theme_css.php");




/* ================================================================================== */
/*      Include Plugins
  /* ================================================================================== */

require_once THEME_PATH . "/framework/plugins/install-plugin.php";



/* ================================================================================== */
/*      Register menu
  /* ================================================================================== */

register_nav_menus(array(
    'main' => 'Main Menu'
//    'footer' => 'Footer Menu'
));


/* ================================================================================== */
/*      Theme Supports
  /* ================================================================================== */

add_action('after_setup_theme', 'themewaves_setup');
if (!function_exists('themewaves_setup')) {

    function themewaves_setup() {
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_theme_support( 'woocommerce' );
        load_theme_textdomain('themewaves', THEME_PATH . '/languages/');
    }

}
if (!isset($content_width))
    $content_width = 960;



/* ================================================================================== */
/*      Enqueue Scripts
  /* ================================================================================== */

add_action('wp_enqueue_scripts', 'themewaves_scripts');

function themewaves_scripts() {
    wp_enqueue_style('tw-bootstrap', THEME_DIR . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('tw-responsive', THEME_DIR . '/assets/css/bootstrap-responsive.min.css');    
    wp_enqueue_style('tw-prettyphoto', THEME_DIR . '/assets/css/prettyPhoto.css');
    wp_enqueue_style('tw-fontawesome', THEME_DIR . '/assets/css/font-awesome/font-awesome.min.css');
    if(woocommerce_enabled())
        wp_enqueue_style('tw_woocommerce', THEME_DIR . '/woocommerce/tw_woocommerce.css');
    wp_enqueue_style('tw-themewaves', STYLESHEET_DIR . '/style.css');
    wp_enqueue_style('tw-animate', THEME_DIR . '/assets/css/animate-custom.css');
    wp_enqueue_style('tw-responsive2', THEME_DIR . '/assets/css/responsive.css');
    $protocol = is_ssl() ? 'https' : 'http';
    $defaultfonts = array(
            'Helvetica Neue',
            'Verdana, Geneva',
            'Trebuchet MS',
            'Georgia',
            'Times New Roman',
            'Tahoma, Geneva',
            'Palatino');
    $tw_googlefonts = array(
        tw_option('body_text_font','face'),
        tw_option('menu_font','face'),
        tw_option('sidebar_widgets_title','face'),
        tw_option('footer_widgets_title','face'),
        tw_option('heading_font'),
    );
    $googlefont = '';
    foreach($tw_googlefonts as $font) {
        if(!in_array($font, $defaultfonts)) {
            $googlefont = str_replace(' ', '+', $font). ':400,400italic,700,700italic|' . $googlefont;
	}
    }
    if($googlefont != '')
        wp_enqueue_style('google-font', "$protocol://fonts.googleapis.com/css?family=" . substr_replace($googlefont ,"",-1) . "&subset=".tw_option('google_font_subset'));

    wp_enqueue_script('jquery');
    if ( is_single() && comments_open() ) wp_enqueue_script( 'comment-reply' );
    wp_enqueue_script('scripts', THEME_DIR . '/assets/js/scripts.js', false, false, true);
    wp_enqueue_script('themewaves', THEME_DIR . '/assets/js/themewaves.js', false, false, true);
    if(woocommerce_enabled())
        wp_enqueue_script('tw_woocommerce', THEME_DIR . '/woocommerce/tw_woocommerce.js', false, false, true);
    if(tw_option('nicescroll'))
        wp_enqueue_script('tw_scroll', THEME_DIR . '/assets/js/jquery.nicescroll.min.js', false, false, true);
    
    if(tw_option('social_share')) {
        if(tw_option('twitter_share'))
            wp_enqueue_script('tw_share_twitter', $protocol.'://platform.twitter.com/widgets.js','','',true);
        if(tw_option('googleplus_share'))
            wp_enqueue_script('tw_share_google', $protocol.'://apis.google.com/js/plusone.js','','',true);
        if(tw_option('linkedin_share'))
            wp_enqueue_script('tw_share_linkedin', $protocol.'://platform.linkedin.com/in.js','','',true);
        if(tw_option('pinterest_share'))
            wp_enqueue_script('tw_share_pinterest', $protocol.'://assets.pinterest.com/js/pinit.js','','',true);
    }
}

/* ================================================================================== */
/*      Register Widget Sidebar
  /* ================================================================================== */

if (!function_exists('theme_widgets_init')) {

    function theme_widgets_init() {

        register_sidebar(array(
            'name' => 'Default sidebar',
            'id' => 'default-sidebar',
            'before_widget' => '<aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside>',
            'before_title' => '<div class="tw-widget-title-container"><h3 class="widget-title">',
            'after_title' => '</h3><span class="tw-title-border"></span></div>',
        ));
        
        register_sidebar(array(
            'name' => 'Top widget',
            'id' => 'top-widget',
            'before_widget' => '<div class="tw-top-bar-info" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '',
            'after_title' => '',
        ));
        
        if(woocommerce_enabled()){
            register_sidebar(array(
                'name' => 'Woocommerce widget',
                'id' => 'woocommerce-widget',
                'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                'after_widget' => '</aside>',
                'before_title' => '<div class="tw-widget-title-container"><h3 class="widget-title">',
                'after_title' => '</h3><span class="tw-title-border"></span></div>',
            ));
        }
        
        /* footer sidebar */
        $grid = tw_option('footer_layout')!="" ? tw_option('footer_layout') : '3-3-3-3';
        $i = 1;
        foreach (explode('-', $grid) as $g) {
            register_sidebar(array(
                'name' => __("Footer sidebar ", "themewaves") . $i,
                'id' => "footer-sidebar-$i",
                'description' => __('The footer sidebar widget area', 'themewaves'),
                'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                'after_widget' => '</aside>',
                'before_title' => '<div class="tw-widget-title-container"><h3 class="widget-title">',
                'after_title' => '</h3><span class="tw-title-border"></span></div>',
            ));
            $i++;
        }
    }

}
add_action('widgets_init', 'theme_widgets_init');
add_filter('widget_text', 'do_shortcode');





/* ================================================================================== */
/*      Has more in post
  /* ================================================================================== */

function has_more() {
    global $post;
    if (empty($post))
        return;
    return (bool) preg_match('/<!--more(.*?)?-->/', $post->post_content);
}

/* ================================================================================== */
/*      Exclude pages from search
  /* ================================================================================== */

if (!function_exists('exclude_pages_from_search') && !is_admin()) :

    function exclude_pages_from_search($query) {
        if ($query->is_search) {
            $query->set('post_type', array('post', 'portfolio', 'page', 'product'));
        }
        return $query;
    }

    if(!is_admin())add_filter('pre_get_posts', 'exclude_pages_from_search');
endif;





/* ================================================================================== */
/*      Support upload .ico file
  /* ================================================================================== */

if (!function_exists('custom_upload_mimes')) {
    add_filter('upload_mimes', 'custom_upload_mimes');

    function custom_upload_mimes($existing_mimes = array()) {
        $existing_mimes['ico'] = "image/x-icon";
        return $existing_mimes;
    }

}



/* ================================================================================== */
/*      ThemeWaves Search Form Customize
  /* ================================================================================== */

function my_search_form() {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
    <div class="input">
        <i class="fa fa-search"></i><input class="span12" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Type and hit enter', 'themewaves') . '">
    </div>
    </form>';

    return $form;
}

add_filter('get_search_form', 'my_search_form');



/* ================================================================================== */
/*      IE
  /* ================================================================================== */

function my_render_css3_pie() {
    echo '
<!--[if lte IE 7]> <html class="ie7"> <![endif]-->
<!--[if IE 8]>     <html class="ie8"> <![endif]-->
<!--[if lte IE 8]><style type="text/css" media="screen">
.image-overlay{background:transparent;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#50000000,endColorstr=#50000000);zoom: 1;}
</style><![endif]-->
';
}

//add_action('wp_head', 'my_render_css3_pie', 8);
add_filter("wpcf7_mail_tag_replaced", "suppress_wpcf7_filter");

function suppress_wpcf7_filter($value, $sub = "") {
    $out = !empty($sub) ? $sub : $value;
    $out = strip_tags($out);
    $out = wptexturize($out);
    return $out;
}

function wpex_fix_shortcodes($content){   
    $array = array (
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'wpex_fix_shortcodes');

/* Wordpress Edit Gallery */
add_filter( 'use_default_gallery_style', '__return_false' );
add_filter( 'wp_get_attachment_link', 'tw_pretty_gallery', 10, 5); 
function tw_pretty_gallery ($content, $id, $size, $permalink) {
    if(!$permalink)
	$content = preg_replace("/<a/","<a rel=\"prettyPhoto[gallery]\"",$content,1);
    return $content;
}


/* Facebook Open Graph Meta */
function facebookOpenGraphMeta() {
    global $post;
    if(!empty($post->ID)) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
        $image = isset($image[0])?$image[0]:'';
        if(!$image){$image=tw_option("theme_logo");};
        if (is_single()) { ?>
            <meta property="og:url" content="<?php the_permalink() ?>"/>
            <meta property="og:title" content="<?php single_post_title(''); ?>" />
            <meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
            <meta property="og:type" content="article" />
            <meta property="og:image" content="<?php echo $image; ?>" /><?php
        } else {
            if(!is_page()&&tw_option("theme_logo")!==''){$image=tw_option("theme_logo");} ?>
            <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />  
            <meta property="og:description" content="<?php bloginfo('description'); ?>" />  
            <meta property="og:type" content="website" />  
            <meta property="og:image" content="<?php echo $image; ?>" /> <?php 
        }
    }
} ?>