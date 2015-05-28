<?php
global $tw_options, $tw_isArchive;
$block = isset($tw_options['block']) ? intval($tw_options['block']) : 1;
$layout = !empty($tw_options['layout']) ? $tw_options['layout'] : 'standard';
$show_pagination = isset($tw_options['show_pagination']) ? $tw_options['show_pagination'] : true;
if (!empty($tw_options['more_text'])) {
    $readMore = $tw_options['more_text'];
} else {
    $readMore = tw_option('translate_readmore') ? tw_option('translate_readmore') : __('Continue Reading', 'themewaves');
}

if ($tw_isArchive || is_tag() || is_search()) {
    $nofeatured = true;
    $layout = 'standard';
    $tw_options['excerpt_count'] = 50;
}
if ( is_category()) {
    $tw_options['excerpt_count'] = 50;
}


if (have_posts()) {

    $width = 870;
    $class = '';
    if ($layout != 'standard') {
        $class = "span" . $layout;
        $width = 270;
        if ($class == 'span6') {
            $width = 570;
        } elseif ($class == 'span4') {
            $width = 370;
        }
    }

    echo $layout != 'standard' ? "<div class='row'><div class='isotope-container'>" : "";

    while (have_posts()) : the_post();
        $format = get_post_format() == "" ? "standard" : get_post_format();
        $featured = true;
        if (!has_post_thumbnail($post->ID)) {
            if (in_array($format, array('aside', 'chat', 'standard')))
                $featured = false;
        }

        if ($layout == 'standard') {
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class("loop"); ?>>
            <?php if ($format == 'link' || $format == 'quote') { ?>
                    <div class="loop-block">                    
                        <div class="loop-media">
                            <div class="loop-format">
                                <span class="post-format <?php echo $format; ?>"></span>
                            </div>
                    <?php call_user_func('format_' . $format); ?>
                        </div>
                    </div><?php
                } else {
                    ?>
                        <?php if (!isset($nofeatured) && $featured) { ?>
                        <div class="loop-media">
                        <?php call_user_func('format_' . $format); ?>
                        </div>
                <?php } ?>
                    <div class="loop-block">
                        <h2 class="loop-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="loop-content clearfix">
                <?php loop_content(); ?>
                        </div>
                        <div class="meta-container">
                            <ul class="loop-meta inline">                                                
                                <li class="date"><?php echo tw_option('pp_date') ? tw_option('pp_date') : __('Posted on', 'themewaves'); ?> <span class="date"><?php the_time('j M Y'); ?></span></li>
                                <li class="author"><?php echo tw_option('pp_author') ? tw_option('pp_author') : __('By', 'themewaves'); ?> <?php the_author_posts_link() ?></li>
                                <li class="category"><?php echo tw_option('pp_cateogry') ? tw_option('pp_cateogry') : __('In', 'themewaves'); ?> <?php echo get_the_category_list(', '); ?></li>
                            </ul>
                            <a href="<?php the_permalink(); ?>" class="more-link"><?php echo apply_filters("widget_title", $readMore); ?></a>
                        </div>
                    </div>
            <?php } ?>
            </article>
            <?php } else {
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class("loop $class"); ?>>
            <?php if ($format == 'link' || $format == 'quote') { ?>                
                    <div class="loop-media">
                        <div class="loop-format">
                            <span class="post-format <?php echo $format; ?>"></span>
                        </div>
                    <?php call_user_func('format_' . $format); ?>
                    </div>
                    <?php
                } else {
                    ?>

                        <?php if (!isset($nofeatured) && $featured) { ?>
                        <div class="loop-media">
                        <?php call_user_func('format_' . $format); ?>
                        </div>
                <?php } ?>
                    <div class="loop-block">                    
                        <div class="meta-container">
                            <div class="carousel-meta clearfix">
                                <div class="date"><i class="fa fa-calendar-o"></i><?php the_time('j M Y'); ?></div>
                                <div class="comment-count"><i class="fa fa-comments-o"></i><?php echo comment_count(); ?></div>
                            </div>							
                        </div>              
                        <h2 class="loop-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="loop-content clearfix">
                <?php loop_content(); ?>
                        </div>
                        <?php if($tw_options['excerpt_count']!='0') { ?>
                        <div class="read-more-container">						
                            <a href="<?php the_permalink(); ?>" class="more-link"><?php echo apply_filters("widget_title", $readMore); ?></a>
                        </div>
                        <?php } ?>
                    </div>
            <?php } ?>
            </article>

            <?php
        }
    endwhile;
    echo $layout != 'standard' ? "</div></div>" : "";
    if(isset($tw_options['pagination'])){
        if($tw_options['pagination']=="simple"){
            pagination();
        }elseif($tw_options['pagination']=="infinite"){
            infinite();
        }
    }else{
        if ($show_pagination) {
            pagination();
        }
    }
    wp_reset_query();
}