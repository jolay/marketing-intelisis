<?php
if (!is_singular('post') || tw_option('blog_title') != "") {
    if (is_singular('post') || is_home()) {
        if (tw_option('blog_title') != "") {
            $title = "<h1 class='page-title'>" . apply_filters('widget_title', tw_option('blog_title')) . "</h1>";
            $subtitle = tw_option('blog_subtitle') != "" ? ('<h3>' . apply_filters('widget_title', tw_option("blog_subtitle")) . '</h3>') : '';
        }
        if (get_metabox("subtitle") != "") {
            $subtitle = "<h3>" . apply_filters('widget_text', get_metabox("subtitle")) . "</h3>";
        }
        if (get_metabox("bg_image") != "") {
            $bgimage = get_metabox("bg_image");
        }
    } else {
        $subtitle = "";
        if (is_page() || is_singular('tw_portfolio')) {
            $title = get_featuredtext();
            if (get_metabox("subtitle") != "") {
                $subtitle = "<h3>" . apply_filters('widget_text', get_metabox("subtitle")) . "</h3>";
            }
            if (get_metabox("bg_image") != "") {
                $bgimage = get_metabox("bg_image");
            }
        } else {
            $title = get_featuredtext();
        }
    }
}


$breadcrumb = false;
$class = 'span12';
if (get_metabox("breadcrumps") == "true") {
    $breadcrumb = true;
    $class = 'span6';
} else if (get_metabox("breadcrumps") != "false") {
    if (tw_option("breadcrumps")) {
        $breadcrumb = true;
        $class = 'span6';
    }
}
$ebreadcrumb = "";
if ($breadcrumb) {
    ob_start();
    echo '<div class="span6">';
    breadcrumbs();
    echo '</div>';
    $ebreadcrumb = ob_get_clean();
}


$background = isset($bgimage) ? $bgimage : tw_option('title_bg_image');

if (woocommerce_enabled() && get_post_type() == 'product') {
    ob_start();
    echo "<h1 class='page-title'>";
    woocommerce_page_title();
    echo "</h1>";
    $title = ob_get_clean();
    ob_start();
    woocommerce_breadcrumb();
    $ebreadcrumb = ob_get_clean();
}

if (isset($title)) {
    ?>
    <!-- Start Feature -->
    <section id="page-title"<?php echo!empty($background) ? (' style="background-image: url(' . $background . ')"') : ''; ?>>
        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <div class="<?php echo $class; ?>">
    <?php echo $title . $subtitle; ?>
                </div>                
    <?php echo $ebreadcrumb; ?>
            </div>
        </div>
        <!-- End Container -->
    </section>
    <!-- End Feature -->
<?php } ?>