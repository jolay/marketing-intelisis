<?php
global $tw_options,$portAtts;
if (have_posts ()) {
    echo '<div class="row">';
        echo '<div class="isotope-container">';
            while (have_posts ()) { the_post();
                $likeit = get_post_meta($post->ID, 'post_likeit', true);
                $likecount = empty($likeit) ? '0' : $likeit;
                $likedclass = 'likeit';
                if (isset($_COOKIE['likeit-' . $post->ID])) {
                    $likedclass .= ' liked';
                }
                $args = array('orderby' => 'none');
                $class = isset($tw_options['column'])?"span".$tw_options['column']:'span3';
                $height = !empty($tw_options['height']) ? $tw_options['height'] : tw_option('port_height');
                $width = 270;
                if($class=='span6'){
                    $width = 570;
                }elseif($class=='span4'){
                    $width = 370;  
                }                
                $cats = wp_get_post_terms($post->ID, 'cat_portfolio', $args);
                foreach ($cats as $catalog) {
                    $class .= " category-" . $catalog->slug;
                } ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>><?php
                    $ids = get_metabox('gallery_image_ids');
                    $video_embed = get_metabox('format_video_embed');
                    $video_url   = get_metabox('pretty_video_url');
                    if (has_post_thumbnail($post->ID)) {
                        if(!empty($video_url)&&get_metabox('pretty_video')==='true'){
                            portfolio_image($width,$height,true,$video_url);                            
                        }else{
                            portfolio_image($width,$height);
                        }
                    } elseif($ids!="false" && $ids!="") {
                        portfolio_gallery($width,$height,$ids);
                    } elseif(!empty($video_embed)) {
                        echo apply_filters("the_content", htmlspecialchars_decode($video_embed));
                    } ?>
                    <div class="portfolio-content">
                        <h2 class="portfolio-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
                        if($portAtts['hide_favorites']==='false'){ ?>
                            <div data-ajaxurl="<?php echo home_url();?>" data-pid="<?php echo $post->ID;?>" class="<?php echo $likedclass;?>">
                                <i class="fa fa-heart"></i><span><?php echo $likecount;?></span>
                            </div><?php
                        } ?>
                    </div>
                </article><?php
            }
        echo '</div>';
    echo '</div>';
    if($tw_options['pagination']=="simple"){
        pagination();
    }elseif($tw_options['pagination']=="infinite"){
        infinite();
    }
    wp_reset_query();
}