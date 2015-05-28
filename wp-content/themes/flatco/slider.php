<?php
if (is_page()) {
    if (get_metabox("header_type") == "slider") {
        ?>
        <section id="slider">
            <?php echo do_shortcode(get_metabox("slider_id")); ?>
        </section>
        <?php
    } elseif (get_metabox("header_type") == "image") {
        $image = post_image_show();
        if ($image) {
            ?>
            <section id="featured-image">
                <div class="container">
                    <?php echo $image; ?>
                </div>
            </section>
            <?php
        }
    } elseif (get_metabox("header_type") == "map") {
        if (get_metabox("googlemap") != "") {
            ?>
            <section id="google-map">
                <?php echo do_shortcode(htmlspecialchars_decode(get_metabox("googlemap"))); ?>
            </section>
            <?php
        }
    } elseif (get_metabox("header_type") != "none") {
        get_template_part('page', 'title');
    }
} else {
    get_template_part('page', 'title');
}?>