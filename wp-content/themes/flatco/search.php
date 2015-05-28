<?php get_header(); ?>

<div class="row">
    <div class="span9"><?php
        $_GET["s"]=isset($_GET["s"])?$_GET["s"]:'';
        $query = new WP_Query(array(
            'post_type'=>array('post', 'portfolio', 'page'),
            'meta_key' => '_pb_content',
            'meta_query' => array(
                array(
                    'key' => '_pb_content',
                    'value' => $_GET["s"],
                    'type' => 'whatever',
                    'compare' => 'like'
                )
            )
        ));
        $wp_query->posts = array_merge( $wp_query->posts, $query->posts );
        $wp_query->post_count  = count( $wp_query->posts );
                    if (have_posts ()) {
                        get_template_part('loop');
                    } else { ?>
                            <div id="error404-container">
                                <h3 class="error404"><?php _e("Sorry, but nothing matched your search criteria. Please try again with some different keywords.", "themewaves");?></h3>
                                <?php get_search_form(); ?>
                                <br/>

                                <div class="error-404-child"></div>

                                <div class="tw-404-error"><p><?php _e("For best search results, mind the following suggestions:", "themewaves");?></p>
                                    <ul class="borderlist">
                                        <li><?php _e("Always double check your spelling.", "themewaves");?></li>
                                        <li><?php _e("Try similar keywords, for example: tablet instead of laptop.", "themewaves");?></li>
                                        <li><?php _e("Try using more than one keyword.", "themewaves");?></li>
                                    </ul>
                                </div>
                            </div>
                  <?php  }
                ?>
    </div>
    <?php get_template_part("sidebar"); ?>
</div>

<?php get_footer(); ?>