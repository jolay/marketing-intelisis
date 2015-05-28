</div>
</section>
<!-- End Main -->
<!-- Start Footer -->
<footer id="footer">
    <?php if (tw_option("footer_widget")) { ?>

        <!-- Start Container-->
        <div class="container">
            <div class="row">
                <?php
                $grid = tw_option('footer_layout') ? tw_option('footer_layout') : '3-3-3-3';
                $i = 1;
                foreach (explode('-', $grid) as $g) {
                    echo '<div class="span' . $g . ' col-' . $i . '">';
                    dynamic_sidebar("footer-sidebar-$i");
                    echo '</div>';
                    $i++;
                }
                ?>
            </div>
        </div>
        <!-- End Container -->
    
    <?php } ?>
        <!-- End Footer -->
    <?php if(tw_option('footer_text')) { ?>
        <div id="bottom">
            <!-- Start Container -->
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <p class="copyright"><?php echo stripslashes(tw_option('copyright_text')); ?></p>
                    </div>
                </div>
            </div>
            <!-- End Container -->
        </div>
    <?php } ?>
</footer>
<?php
global $tw_end;
echo $tw_end;
?>
<?php
/* Google Analytics Code */
echo stripslashes(tw_option('tracking_code'));

$gotop = __('Scroll to top', 'themewaves');
echo '<a id="scrollUp" title="'.$gotop.'"><i class="fa fa-chevron-up"></i></a>';
?>
<?php wp_footer(); ?>
</body>
</html>