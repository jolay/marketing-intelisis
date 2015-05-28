<?php
global $tw_socials;
$tw_socials = array(
    'facebook' => array(
        'name' => 'facebook_username',
        'link' => 'http://www.facebook.com/*',
    ),
    'tumblr' => array(
        'name' => 'tumblr_username',
        'link' => 'http://*.tumblr.com/',
    ),
    'flickr' => array(
        'name' => 'flickr_username',
        'link' => 'http://www.flickr.com/photos/*'
    ),
    'gplus' => array(
        'name' => 'googleplus_username',
        'link' => 'https://plus.google.com/u/0/*'
    ),
    'twitter' => array(
        'name' => 'twitter_username',
        'link' => 'http://twitter.com/*',
    ),
    'instagram' => array(
        'name' => 'instagram_username',
        'link' => 'http://instagram.com/*',
    ),
    'pinterest' => array(
        'name' => 'pinterest_username',
        'link' => 'http://pinterest.com/*',
    ),
    'skype' => array(
        'name' => 'skype_username',
        'link' => 'skype:*'
    ),
    'vimeo' => array(
        'name' => 'vimeo_username',
        'link' => 'http://vimeo.com/*',
    ),
    'youtube' => array(
        'name' => 'youtube_username',
        'link' => '*',
    ),
    'dribbble' => array(
        'name' => 'dribbble_username',
        'link' => 'http://dribbble.com/*',
    ),
    'linkedin' => array(
        'name' => 'linkedin_username',
        'link' => '*'
    ),
    'soundcloud' => array(
        'name' => 'soundcloud_username',
        'link' => '*'
    ),
    'rss' => array(
        'name' => 'rss_username',
        'link' => 'http://*/feed'
    )
);
// To excerpt
//=======================================================
if (!function_exists('to_excerpt')) {

    function to_excerpt($str, $length) {
        $str = strip_tags($str);
        $str = explode(" ", $str);
        return implode(" ", array_slice($str, 0, $length));
    }

}

// Go url
//=======================================================
if (!function_exists('to_url')) {

    function to_url($url) {
        if (!preg_match_all('!https?://[\S]+!', $url, $matches))
            $url = "http://" . $url;
        return $url;
    }

}

// Page,Post get, print content
//=======================================================

function loop_content() {
    global $tw_options, $more;
    $more = 0;

    if (has_excerpt()) {
        the_excerpt();
    } elseif (has_more()) {
        the_content("");
        //echo '<a href="' . get_permalink() . '" class="more-link">' . $readMore . '</a>';
    } elseif ($tw_options['excerpt_count'] != '') {
        echo to_excerpt(strip_shortcodes(get_the_content()), $tw_options['excerpt_count']);
        //echo '<a href="' . get_permalink() . '" class="more-link">' . $readMore . '</a>';
    } else {
        echo apply_filters("the_content", strip_shortcodes(get_the_content("")));
    }
}

function tw_option($index1, $index2 = false) {
    global $smof_data;
    if ($index2) {
        $output = isset($smof_data[$index1][$index2]) ? $smof_data[$index1][$index2] : false;
        return $output;
    }
    $output = isset($smof_data[$index1]) ? $smof_data[$index1] : false;
    return $output;
}

// Page, Post custom metaboxes
//=======================================================
function get_metabox($name) {
    global $post;
    if ($post) {
        $metabox = get_post_meta($post->ID, 'themewaves_' . strtolower(THEMENAME) . '_options', true);
        return isset($metabox[$name]) ? $metabox[$name] : "";
    }
    return false;
}

function set_metabox($name, $val) {
    global $post;
    if ($post) {
        $metabox = get_post_meta($post->ID, 'themewaves_' . strtolower(THEMENAME) . '_options', true);
        $metabox[$name] = $val;
        return update_post_meta($post->ID, 'themewaves_' . strtolower(THEMENAME) . '_options', $metabox);
    }
    return false;
}

// Print menu
//=======================================================
function theme_menu() {
    $nav_menu = get_metabox('page_menu');
    if ($nav_menu) {
        wp_nav_menu(array(
            'container' => 'div',
            'container_class' => 'tw-menu-container',
            'menu' => $nav_menu,
            'menu_id' => 'menu',
            'menu_class' => 'sf-menu',
            'fallback_cb' => 'no_main')
        );
    } else {
        wp_nav_menu(array(
            'container' => 'div',
            'container_class' => 'tw-menu-container',
            'menu_id' => 'menu',
            'menu_class' => 'sf-menu',
            'fallback_cb' => 'no_main',
            'theme_location' => 'main')
        );
    }
}

function no_main() {
    echo "<div class='tw-menu-container clearfix'><ul id='menu' class='sf-menu'>";
    wp_list_pages(array('title_li' => ''));
    echo "</ul></div>";
}

function mobile_menu() {
    $nav_menu = get_metabox('page_menu');
    if ($nav_menu) {
        wp_nav_menu(array(
            'container' => false,
            'menu' => $nav_menu,
            'menu_id' => '',
            'menu_class' => 'clearfix',
            'fallback_cb' => 'no_mobile')
        );
    } else {
        wp_nav_menu(array(
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'clearfix',
            'fallback_cb' => 'no_mobile',
            'theme_location' => 'main')
        );
    }
}

function no_mobile() {
    echo "<ul class='clearfix'>";
    wp_list_pages(array('title_li' => ''));
    echo "</ul>";
}

// Footer menu
//=======================================================
function footer_menu() {
    wp_nav_menu(array('container' => false,
        'menu_class' => 'footer-menu inline',
        'fallback_cb' => 'no_footer',
        'depth' => 1,
        'theme_location' => 'footer'));
}

function no_footer() {
    //echo "<ul class='footer-menu inline'>"; wp_list_pages(array('depth'=>1,'title_li'=>'')); echo "</ul>";
}

// Print logo
//=======================================================
function theme_logo() {
    $top = tw_option('logo_top') != "" ? (' padding-top:' . tw_option('logo_top') . 'px;') : '';
    $bottom = tw_option('logo_bottom') != "" ? (' padding-bottom:' . tw_option('logo_bottom') . 'px;') : '';
    $bgcolor = tw_option('logo_bg') ? '' : (' background-color: transparent;');
    echo '<div class="tw-logo" style="' . $top . $bottom . $bgcolor . '">';
    echo '<a class="logo" href="' . home_url() . '">';
    if (tw_option("theme_logo") == "") {
        bloginfo('name');
    } else {
        if (tw_option("logo_retina"))
            echo '<img class="logo-img" src="' . tw_option("theme_logo_retina") . '" style="width:' . tw_option('logo_width') . 'px" alt="' . get_bloginfo('name') . '"/>';
        else
            echo '<img class="logo-img" src="' . tw_option("theme_logo") . '" alt="' . get_bloginfo('name') . '"/>';
    }
    echo '</a>';
    echo '</div>';
    //echo '<div class="site-description">' . get_bloginfo('description') . '</div>';
}

// Get featured text
//=======================================================
function get_featuredtext() {
    global $post;

    if (is_singular()) {
        $return = "<h1 class='page-title'>" . $post->post_title . "</h1>";
        return $return;
    } elseif (is_category()) {
        $return = "<h1 class='page-title'>";
        $return .= (tw_option('pt_category') ? tw_option('pt_category') : __("Category", "themewaves")) . " : " . single_cat_title("", false);
        $return .= "</h1>";
        return $return;
    } elseif (is_tax('cat_portfolio')) {
        $return = "<h1 class='page-title'>";
        $return .= (tw_option('pt_portfolio') ? tw_option('pt_portfolio') : __("Portfolio", "themewaves")) . " : " . single_cat_title("", false);
        $return .= "</h1>";
        return $return;
    } elseif (is_tag()) {
        $return = "<h1 class='page-title'>";
        $return .= (tw_option('pt_tag') ? tw_option('pt_tag') : __("Tag", "themewaves")) . " : " . single_tag_title("", false);
        $return .= "</h1>";
        return $return;
    } elseif (is_404()) {
        $return = "<h1 class='page-title'>" . tw_option('pt_nothing_found') ? tw_option('pt_nothing_found') : __("Nothing Found!", "themewaves") . "</h1>";
        return $return;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        $return = "<h1 class='page-title'>" . (tw_option('pt_author') ? tw_option('pt_author') : __("Author: ", "themewaves")) . $userdata->display_name . "</h1>";
        return $return;
    } elseif (is_archive()) {
        $return = "<h1 class='page-title'>";
        if (is_day()) {
            $return .= (tw_option('pt_daily_arch') ? tw_option('pt_daily_arch') : __("Daily Archives", "themewaves")) . " : " . get_the_date();
        } elseif (is_month()) {
            $return .=(tw_option('pt_monthly_arch') ? tw_option('pt_monthly_arch') : __("Monthly Archives", "themewaves")) . " : " . get_the_date("F Y");
        } elseif (is_year()) {
            $return .= (tw_option('pt_yearly_arch') ? tw_option('pt_yearly_arch') : __("Yearly Archives", "themewaves")) . " : " . get_the_date("Y");
        } else {
            $return .= tw_option('pt_blog_arch') ? tw_option('pt_blog_arch') : __("Blog Archives", "themewaves");
        }
        $return .= "</h1>";
        return $return;
    } elseif (is_search()) {
        $return = "<h1 class='page-title'>" . (tw_option('pt_search_result') ? tw_option('pt_search_result') : __("Search results for", "themewaves")) . " : " . get_search_query() . "</h1>";
        return $return;
    }
}

// Sidebar
//=======================================================
function sidebar($sidebar = 'sidebar') {
    if (function_exists('dynamic_sidebar') && dynamic_sidebar($sidebar)) {
        
    }
}

function print_styles($links) {
    for ($i = 0; $i < count($links); $i++) {
        echo '<link type="text/css" rel="stylesheet" href="' . file_require(get_template_directory_uri() . '/' . $links[$i], true) . '" />';
    }

    echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=' . str_replace(" ", "+", get_settings_value('head_felement')) . ':300,300italic,400,400italic,700,700italic,600,600italic" />';
    if (get_settings_value('body_felement') != get_settings_value('head_felement')) {
        echo '<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=' . str_replace(" ", "+", get_settings_value('body_felement')) . ':400,400italic,700,700italic" />';
    }
}

function favicon() {
    if (tw_option('theme_favicon') == "") {
        echo '<link rel="shortcut icon" href="' . THEME_DIR . '/assets/img/favicon.ico"/>';
    } else {
        echo '<link rel="shortcut icon" href="' . tw_option('theme_favicon') . '"/>';
    }
    if (tw_option('favicon_retina')) {
        echo tw_option('favicon_iphone') != "" ? ('<link rel="apple-touch-icon" href="' . tw_option('favicon_iphone') . '"/>') : '';
        echo tw_option('favicon_iphone_retina') != "" ? ('<link rel="apple-touch-icon" sizes="114x114" href="' . tw_option('favicon_iphone_retina') . '"/>') : '';
        echo tw_option('favicon_ipad') != "" ? ('<link rel="apple-touch-icon" sizes="72x72" href="' . tw_option('favicon_ipad') . '"/>') : '';
        echo tw_option('favicon_ipad_retina') != "" ? ('<link rel="apple-touch-icon" sizes="144x144" href="' . tw_option('favicon_ipad_retina') . '"/>') : '';
    }
}

function portfolio_image($width = 270, $height = "", $prettyphoto = true, $prettyVideoURL = '') {
    global $post, $portAtts;
    if (has_post_thumbnail($post->ID)) {
        $portAtts['hide_hover'] = isset($portAtts['hide_hover']) ? $portAtts['hide_hover'] : 'false';
        $portAtts['link_type'] = isset($portAtts['link_type']) ? $portAtts['link_type'] : 'view_large';
        $portURL = post_image_show(0, 0, true);
        if ($portAtts['link_type'] === 'permalink') {
            $portURL = get_permalink($post->ID);
        } elseif ($portAtts['link_type'] === 'preview_url') {
            $portURL = get_metabox("preview_url");
        } elseif (!empty($prettyVideoURL)) {
            $portURL = $prettyVideoURL;
        }
        ?>
        <div class="loop-image"><?php
            if ($prettyphoto && $portAtts['hide_hover'] === 'true') {
                echo'<a href="' . $portURL . '"' . ($portAtts['link_type'] === 'view_large' ? ' rel="prettyPhoto"' : '') . '>';
            }
            echo post_image_show($width, $height);
            if ($prettyphoto && $portAtts['hide_hover'] === 'true') {
                echo'</a>';
            }
            if ($prettyphoto && $portAtts['hide_hover'] === 'false') {
                ?>
                <div class="image-overlay">
                    <div class="image-links">
                        <a class="btn btn-border"<?php
                        if ($portAtts['link_type'] === 'view_large') {
                            echo 'rel="prettyPhoto"';
                        }
                        ?> href="<?php echo $portURL; ?>"><?php echo empty($portAtts['button_text']) ? __('View Large', 'themewaves') : $portAtts['button_text']; ?></a>
                    </div>
                </div><?php }
                    ?>
        </div><?php }
                ?>
    <?php
}

function portfolio_gallery($width = 270, $height = "", $ids = "", $prettyphoto = true) {
    if (!empty($ids)) {
        ?>
        <div class="gallery-container clearfix">
            <div class="gallery-slide">
                <?php
                foreach (explode(',', $ids) as $id) {
                    if (!empty($id)) {
                        $imgurl0 = aq_resize(wp_get_attachment_url($id), $width, $height, true);
                        $imgurl = !empty($imgurl0) ? $imgurl0 : wp_get_attachment_url($id);
                        ?>
                        <div class="slide-item">
                            <div class="loop-image">
                                <img src="<?php echo $imgurl; ?>" alt="<?php the_title(); ?>">
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>                  
            </div>
            <div class="carousel-arrow">
                <a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>
                <a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>
            </div>  
        </div>    
        <?php
    }
}

function format_standard() {
    global $post;
    if (has_post_thumbnail($post->ID)) {
        $overlay = "hover-link";
        $link = get_permalink();
        $rell = '';
        $width = 870;
        $height = get_metabox('image_height');
        if (is_single()) {
            $lrg_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
            $link = $lrg_img[0];
            $overlay = "hover-zoom";
            $rell = ' rel="prettyPhoto"';
        }
        ?>
        <div class="loop-image">
            <a href="<?php echo $link; ?>"<?php echo $rell; ?> title="<?php echo the_title(); ?>">
        <?php echo post_image_show($width, $height); ?>
            </a>
        </div>
        <?php
    }
}

function format_gallery() {
    global $post;
    $ids = get_post_meta($post->ID, 'gallery_image_ids', true);
    $height = get_post_meta($post->ID, 'format_image_height', true);
    $width = 870;
    if (!empty($ids)) {
        ?>
        <div class="loop-gallery gallery-container clearfix">
            <div class="gallery-slide">
                <?php
                foreach (explode(',', $ids) as $id) {
                    if (!empty($id)) {
                        $imgurl0 = aq_resize(wp_get_attachment_url($id), $width, $height, true);
                        $imgurl = !empty($imgurl0) ? $imgurl0 : wp_get_attachment_url($id);
                        ?>
                        <div class="slide-item">
                            <img src="<?php echo $imgurl; ?>" alt="<?php the_title(); ?>">                                  
                        </div>
                        <?php
                    }
                }
                ?>                  
            </div>
            <div class="carousel-arrow">
                <a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>
                <a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>
            </div>  
        </div>    
        <?php
    }
}

function format_image() {
    format_standard();
}

function jplayer_script() {
    wp_enqueue_script('jplayer_script', THEME_DIR . '/assets/js/jquery.jplayer.min.js', false, false, true);
}

function format_audio() {
    global $post;

    $audio_url = get_post_meta($post->ID, 'format_audio_mp3', true);
    $embed = get_post_meta($post->ID, 'format_audio_embed', true);
    if (!empty($embed)) {
        echo apply_filters("the_content", htmlspecialchars_decode($embed));
    } else {
        echo post_image_show();
        if (!empty($audio_url)) {
            add_action('wp_footer', 'jplayer_script');
            ?>
            <div id="jquery_jplayer_<?php echo $post->ID; ?>" class="jp-jplayer jp-jplayer-audio" data-pid="<?php echo $post->ID; ?>" data-mp3="<?php echo $audio_url; ?>"></div>
            <div class="jp-audio-container">
                <div class="jp-audio">
                    <div class="jp-type-single">
                        <div id="jp_interface_<?php echo $post->ID; ?>" class="jp-interface">
                            <ul class="jp-controls">
                                <li><div class="seperator-first"></div></li>
                                <li><div class="seperator-second"></div></li>
                                <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                                <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                                <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                                <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                            </ul>
                            <div class="jp-progress-container">
                                <div class="jp-progress">
                                    <div class="jp-seek-bar">
                                        <div class="jp-play-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-volume-bar-container">
                                <div class="jp-volume-bar">
                                    <div class="jp-volume-bar-value"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

function format_video() {
    global $post;
    $video_embed = get_post_meta($post->ID, 'format_video_embed', true);
    $video_thumb = get_post_meta($post->ID, 'format_video_thumb', true);
    $video_m4v = get_post_meta($post->ID, 'format_video_m4v', true);

    if (!empty($video_embed)) {
        echo apply_filters("the_content", htmlspecialchars_decode($video_embed));
    } elseif (!empty($video_m4v)) {
        add_action('wp_footer', 'jplayer_script');
        ?>

        <div id="jquery_jplayer_<?php echo $post->ID; ?>" class="jp-jplayer jp-jplayer-video" data-pid="<?php echo $post->ID; ?>" data-m4v="<?php echo $video_m4v; ?>" data-thumb="<?php echo $video_thumb; ?>"></div>
        <div class="jp-video-container">
            <div class="jp-video">
                <div class="jp-type-single">
                    <div id="jp_interface_<?php echo $post->ID; ?>" class="jp-interface">
                        <ul class="jp-controls">
                            <li><div class="seperator-first"></div></li>
                            <li><div class="seperator-second"></div></li>
                            <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                            <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                            <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                            <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                        </ul>
                        <div class="jp-progress-container">
                            <div class="jp-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="jp-volume-bar-container">
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

function format_quote() {
    global $post;

    $quote_text = get_post_meta($post->ID, 'format_quote_text', true);
    $quote_author = get_post_meta($post->ID, 'format_quote_author', true);

    if (!empty($quote_text)) {
        echo '<blockquote>';
        echo "<p>" . $quote_text . "</p>";
        if (!empty($quote_author)) {
            echo "<span>" . $quote_author . "</span>";
        }
        echo "</blockquote>";
    }
}

function format_link() {
    global $post;

    $link_url = get_post_meta($post->ID, 'format_link_url', true);
    $url = !empty($link_url) ? to_url($link_url) : "#";
    echo '<div class="link-content">';
    echo '<h2 class="link-text"><a href="' . $url . '" target="_blank">' . get_the_title() . '</a></h2>';
    echo '<a href="' . $url . '" target="_blank"><span class="sub-title">' . $url . '</span></a></div>';
}

function format_status() {
    global $post;

    $status_url = get_post_meta($post->ID, 'format_status_url', true);
    if (!empty($status_url)) {
        echo apply_filters("the_content", $status_url);
    }
}

function pagination() {
    global $wp_query;

    $pages = $wp_query->max_num_pages;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if (empty($pages)) {
        $pages = 1;
    }

    if (1 != $pages) {

        $big = 9999; // need an unlikely integer
        echo "<div class='tw-pagination pagination'>";

        $pagination = paginate_links(
                array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'end_size' => 3,
                    'mid_size' => 6,
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $wp_query->max_num_pages,
                    'type' => 'list',
                    'prev_text' => __('&laquo;', 'themewaves'),
                    'next_text' => __('&raquo;', 'themewaves'),
        ));

        echo $pagination;

        echo "</div>";
    }
}

if (!function_exists('infinite')) {

    function infinite() {
        global $wp_query;
        $pages = intval($wp_query->max_num_pages);
        $paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
        if (empty($pages)) {
            $pages = 1;
        }
        if (1 != $pages) {
            echo '<div class="tw-pagination tw-infinite-scroll" data-has-next="' . ($paged === $pages ? 'false' : 'true') . '">';
            echo '<a class="btn btn-small no-more" href="#">' . __('No more posts', 'themewaves') . '</a>';
            echo '<a class="btn btn-small loading" href="#">' . __('Loading posts ...', 'themewaves') . '</a>';
            echo '<a class="btn btn-small next" href="' . get_pagenum_link($paged + 1) . '"><i class="fa fa-repeat"></i>' . __('Load More Items', 'themewaves') . '</a>';
            echo '</div>';
        }
    }

}

function comment_count() {

    if (comments_open()) {

//        if (get_settings_value('facebook_comment')) {
//            return '<fb:comments-count data-href="' . get_permalink() . '"></fb:comments-count>';
//        } else {

        $comment_count = get_comments_number('0', '1', '%');
        if ($comment_count == 0) {
            $comment_trans = __('No comment', 'themewaves');
        } elseif ($comment_count == 1) {
            $comment_trans = __('One comment', 'themewaves');
        } else {
            $comment_trans = $comment_count . ' ' . __('comments', 'themewaves');
        }
        return "<a href='" . get_comments_link() . "' title='" . $comment_trans . "' class='comment-count'>" . $comment_trans . "</a>";
//        }
    }
}

if (!function_exists('mytheme_comment')) {

    function mytheme_comment($comment, $args, $depth) {

        $GLOBALS['comment'] = $comment;
        print '<div class="comment-block">';
        ?>	
        <div class="comment" id="comment-<?php comment_ID(); ?>">
            <div class="comment-author"><span class="reply-line"></span>
                        <?php echo get_avatar($comment, $size = '70'); ?>
                <div class="comment-meta">
                    <span class="comment-author-link">
                        <?php echo __('By', 'themewaves') . " " . get_comment_author_link() . " - "; ?>
                    </span>                            
                    <span class="comment-date">
        <?php printf(__('%1$s', 'themewaves'), get_comment_date('j F Y')); ?>
                    </span>
                    <span class="comment-replay-link"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
                </div>
            </div>
            <div class="comment-body">
        <?php comment_text() ?>
            </div>
        </div><?php
    }

}






if (!function_exists('tw_comment_form')) {

    function tw_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();

        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<div><div class="comment-form-author"><p>' .
            '<input placeholder="' . __('Name', 'themewaves') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
            'email' => '<p class="comment-form-email">' .
            '<input placeholder="' . __('Email', 'themewaves') . '" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p></div></div>'
        );
        return $fields;
    }

    add_filter('comment_form_default_fields', 'tw_comment_form');
}
if (!function_exists('post_image_show')) {

    function post_image_show($width = 0, $height = "", $returnURL = false) {
        global $post;
        if (has_post_thumbnail($post->ID)) {
            $attachment = get_post(get_post_thumbnail_id($post->ID));
            if (isset($attachment)) {
                $lrg_img = wp_get_attachment_image_src($attachment->ID, 'full');
                $url = $lrg_img[0];
                if ($returnURL) {
                    return $url;
                } else {
                    $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                    $alt = !empty($alt) ? $alt : $attachment->post_title;
                    if ($width != 0) {
                        $url = aq_resize($url, $width, $height, true);
                    }
                    $urll = !empty($url) ? $url : $lrg_img[0];
                    return '<img src="' . $urll . '" alt="' . $alt . '"/>';
                }
            } else
                return false;
        }
        return false;
    }

}
if (!function_exists('about_author')) {

    function about_author() {
        $tw_author = false;
        if (get_metabox("post_authorr") == "true") {
            $tw_author = true;
        } else if (get_metabox("post_authorr") != "false") {
            if (tw_option('post_author')) {
                $tw_author = true;
            }
        }
        if ($tw_author) {
            ?>
            <div class="tw-author clearfix">
                <div class="author-image"><?php
                    $tw_author_email = get_the_author_meta('email');
                    echo get_avatar($tw_author_email, $size = '70');
                    ?>
                </div>
                <h3><?php
                    _e("Written by ", "themewaves");
                    if (is_author())
                        the_author();
                    else
                        the_author_posts_link();
                    ?>
                </h3>
                <div class="author-title-line"></div>
                <p><?php
                    $description = get_the_author_meta('description');
                    if ($description != '')
                        echo $description;
                    else
                        _e('The author didnt add any Information to his profile yet', 'themewaves');
                    ?>
                </p>
            </div><?php
        }
    }

}

function related_portfolios() {
    global $post, $tw_options, $portAtts;

    $tags = wp_get_post_terms($post->ID, 'cat_portfolio', array("fields" => "ids"));

    if ($tags) {
        $notin = $post->ID;
        $rel_title = tw_option('translate_relatedportfolio') ? tw_option('translate_relatedportfolio') : __('Related portfolio items', 'themewaves');
        echo do_shortcode('[tw_item_title title="' . $rel_title . '"]');
        $tag_ids = array();
        foreach ($tags as $tag)
            $tag_ids[] = $tag;
        $query = Array(
            'post_type' => 'tw_portfolio',
            'posts_per_page' => '4',
            'post__not_in' => array($notin),
            'tax_query' => Array(Array(
                    'taxonomy' => 'cat_portfolio',
                    'terms' => $tag_ids,
                    'field' => 'id'
                ))
        );
        query_posts($query);
        $tw_options['pagination'] = 'none';
        $portAtts['hide_favorites'] = tw_option('hide_favorites') ? 'true' : 'false';
        $portAtts['hide_hover'] = tw_option('port_related_hide_hover') ? 'true' : 'false';
        $portAtts['button_text'] = tw_option('port_related_button_text') ? tw_option('port_related_button_text') : '';
        $portAtts['link_type'] = 'view_large';
        if (tw_option('port_related_link_type') === 'Permalink') {
            $portAtts['link_type'] = 'permalink';
        } elseif (tw_option('port_related_link_type') === 'Preview URL') {
            $portAtts['link_type'] = 'preview_url';
        }
        echo '<div class="row"><div class="span12 related_portfolios"><div class="tw-portfolio">';
        get_template_part("loop", "portfolio");
        echo '</div></div></div>';
    }
    unset($portAtts);
}

function tw_social() {
    global $tw_socials;
    foreach ($tw_socials as $key => $social) {
        if (tw_option($social['name']) != "") {
            echo '<a href="' . str_replace('*', tw_option($social['name']), $social['link']) . '" target="_blank" title="' . $key . '" class="' . $key . '"><span class="tw-icon-' . $key . '"></span></a>';
        }
    }
}

function vimeo_youtube_image($embed) {

    preg_match('/src=\"(.*?)\"/si', $embed, $filteredContent);

    if (!empty($filteredContent[1])) {
        $url = $filteredContent[1];
        $youtube = strpos($url, 'youtube.com');
        $youtu = strpos($url, 'youtu.be');
        $vimeo = strpos($url, 'vimeo.com');

        $video_id = '';
        $spliturl = explode("/", $url);
        $video_id = $spliturl[count($spliturl) - 1];
        if ($video_id == "") {
            $video_id = $spliturl[count($spliturl) - 2];
        }
    } else {
        $url = $embed;
        $youtube = strpos($url, 'youtube.com');
        $youtu = strpos($url, 'youtu.be');
        $vimeo = strpos($url, 'vimeo.com');

        $video_id = '';
        $spliturl = explode("/", $url);
        $video_id = $spliturl[count($spliturl) - 1];
        if ($video_id == "") {
            $video_id = $spliturl[count($spliturl) - 2];
        } else {
            $spliturl = explode("=", $url);
            $video_id = $spliturl[count($spliturl) - 1];
        }
    }

    $video_img = '';

    if ($youtube || $youtu) {
        $video_img = '<img src="http://img.youtube.com/vi/' . $video_id . '/0.jpg" class="image_youtube" />';
    } else if ($vimeo) {
        $json = @file_get_contents("http://vimeo.com/api/oembed.json?url=http%3A//vimeo.com/" . $video_id, true);
        if (strpos($http_response_header[0], "200")) {
            $data = json_decode($json, true);
            $video_thumb = $data['thumbnail_url'];
            $video_thumb = str_replace("_1280", "_640", $video_thumb);
            $video_img = '<img src="' . $video_thumb . '" class="image_vimeo" />';
        }
        if (strlen($video_img) < 1) {
            $video_img = "";
        }
    }

    return $video_img;
}

if (isset($_REQUEST['liked_pid'])) {
    $pid = intval($_REQUEST['liked_pid']);
    $liked = get_post_meta($pid, 'post_likeit', true);
    if (!isset($_COOKIE['likeit-' . $pid])) {
        if (empty($liked)) {
            $liked = 1;
        } else {
            $liked = (intval($liked) + 1);
        }
        update_post_meta($pid, 'post_likeit', $liked);
        setcookie('likeit-' . $pid, 1);
    }
    print "<div><div id='portfolio_liked'>$liked</div></div>";
    die;
}

function tw_social_share() {
    $post_link = get_permalink();

    $output = '<div class="tw_post_sharebox clearfix">';

    if (tw_option('facebook_share'))
        $output .= '<div class="facebook_share"><iframe src="http' . (is_ssl() ? 's' : '') . '://www.facebook.com/plugins/like.php?href=' . urlencode($post_link) . '&amp;layout=button_count&amp;show_faces=false&amp;width=70&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>';

    if (tw_option('googleplus_share'))
        $output .= '<div class="googleplus_share"><g:plusone size="medium" href="' . $post_link . '"></g:plusone></div>';

    if (tw_option('twitter_share')) {
        $post_title = get_the_title();
        $output .= '<div class="twitter_share"><a href="http' . (is_ssl() ? 's' : '') . '://twitter.com/share" class="twitter-share-button" data-url="' . $post_link . '" data-width="100"  data-text="' . $post_title . '" data-count="horizontal"></a></div>';
    }

    if (tw_option('pinterest_share')) {
        $post_image = post_image_show(0, 0, true);
        $output .= '<div class="pinterest_share"><a href="http' . (is_ssl() ? 's' : '') . '://pinterest.com/pin/create/button/?url=' . $post_link . '&media=' . $post_image . '" class="pin-it-button" count-layout="horizontal"></a></div>';
    }

    if (tw_option('linkedin_share'))
        $output .= '<div class="linkedin_share"><script type="in/share" data-url="' . $post_link . '" data-counter="right"></script></div>';

    $output .= '</div>';

    return $output;
}

function isMobile() {
    return(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']));
}
