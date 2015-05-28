<?php
get_header();
?>

<div class="row">
    <div class="span12">
        <section class="content">
            <div id="error404-container">
                <h3 class="error404"><?php _e("Error", "themewaves");?> <span><?php _e("404", "themewaves");?></span> <?php _e("Page", "themewaves");?></h3>
                <h2 class="errorh2"><?php _e("Oops! We couldn’t find it ...", "themewaves");?></h2>

                <div class="tw-404-error">
                    <ul class="borderlist">
                        <li><?php _e("Always double check your spelling.", "themewaves");?></li>
                        <li><?php _e("Try similar keywords, for example: tablet instead of laptop.", "themewaves");?></li>
                        <li><?php _e("Try using more than one keyword.", "themewaves");?></li>
                    </ul>
                </div>
                <div class="tw-404-search-container">
                <?php get_search_form(); ?><div class="error4button"><a href="<?php echo home_url(); ?>" target="_blank" class="btn btn-border btn-small btn-hover2" style="border-color: #fff;color: #fff"><?php _e("Go to Home Page", "themewaves");?></a></div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
get_footer();
?>