<?php get_header();?>

<div class="row">
    <div class="span9">
        <section class="content">
                <?php get_template_part("loop");?>
        </section>
    </div>
    <?php get_template_part("sidebar");?>
</div>

<?php get_footer();?>