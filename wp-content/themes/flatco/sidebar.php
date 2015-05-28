<?php 
$align = "right";
$woo = false;
if(is_singular() && get_metabox("layout")=="left")
    $align = "left";
if(woocommerce_enabled() && get_post_type()=='product')
    $woo = true;
if($woo){
    ob_start();
    dynamic_sidebar("woocommerce-widget");
    $wsidebar = ob_get_clean();
    if($wsidebar) { ?>
        <div class="span3 <?php echo $align;?>-sidebar">
            <section id="sidebar">
                <?php echo $wsidebar;?>
            </section>
        </div>
    <?php
    }
    echo "</div>";
} else { ?>
    <div class="span3 <?php echo $align;?>-sidebar">
        <section id="sidebar">
            <?php
            if(!dynamic_sidebar(get_metabox("custom_sidebar")!="" ? get_metabox("custom_sidebar") : 'default-sidebar')) {
                print 'There is no widget. You should add your widgets into <strong>';
                print 'Default';
                print '</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard. <br/><br/>';
            ?>
                <aside id="archives" class="widget">
                    <h3 class="widget-title">
                        <?php _e('Archives', 'themewaves'); ?>
                    </h3>
                    <ul class="side-nav">
                        <?php wp_get_archives(array('type' => 'monthly')); ?>
                    </ul>
                </aside>
            <?php } ?>
        </section>
    </div>
<?php 
}
?>