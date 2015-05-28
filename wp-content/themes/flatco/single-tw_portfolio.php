<?php get_header(); ?>
<?php the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio');?>><?php
    if(post_password_required()){
        the_content();
    }else{ ?>
        <div class="row">
            <div class="span8">
                <?php
                global $post;

                $likeit = get_post_meta($post->ID, 'post_likeit', true);
                $likecount = empty($likeit) ? '0' : $likeit;
                $likedclass = 'likeit';
                if (isset($_COOKIE['likeit-' . $post->ID])) {
                    $likedclass .= ' liked';
                }

                $ids = get_metabox('gallery_image_ids');
                $video_embed = get_metabox('format_video_embed');
                if($ids!="false" && $ids!="") {
                    $height = get_metabox('format_image_height');
                    portfolio_gallery(770, $height, $ids, false);
                } elseif(!empty($video_embed)) {
                    echo apply_filters("the_content", htmlspecialchars_decode($video_embed));
                } else {
                    $height = get_metabox('image_height');
                    portfolio_image(770, $height,false);
                }

                if (tw_option('portfolio_share')) {
                    echo tw_social_share();
                }
                ?>
            </div>
            <div class="span4">
                <?php
                $project_desc = tw_option('translate_projectdesc') ? tw_option('translate_projectdesc') : __('Project Description', 'themewaves');
                $live_preview = tw_option('translate_livepreview') ? tw_option('translate_livepreview') : __('LIVE PREVIEW', 'themewaves');
                echo do_shortcode('[tw_item_title title="'.$project_desc.'"]');
                the_content();

                echo get_the_term_list( $post->ID, 'cat_portfolio', '<div class="meta-cat"><i class="fa fa-tags"></i>', ', ', '</div>' );
                if(!tw_option('hide_favorites')){ ?>
                    <div class="meta-fav">
                        <div data-ajaxurl="<?php echo home_url();?>" data-pid="<?php echo $post->ID;?>" class="<?php echo $likedclass;?>">
                            <i class="fa fa-heart"></i><span><?php echo $likecount;?></span>
                        </div>
                        <span><?php _e('Favorites');?></span>
                    </div><?php
                }
                if (get_metabox("preview_url") != "") {?>
                    <a href="<?php echo get_metabox("preview_url"); ?>" target="_blank" class="btn btn-border live-preview"><?php echo $live_preview; ?><span></span></a>
                <?php } ?>
            </div>                
        </div><?php
    } ?>
</article> 

<?php 
if(!tw_option('port_related')) {
    related_portfolios();
}?>

<?php get_footer(); ?>