<?php /* template name: Coming Soon */ ?>
<?php get_header('comingsoon');  ?>
<?php the_post(); ?>
<div class="container"><?php 
    $output  = '[tw_comingsoon';
        $output .= ' coming_title="'. get_the_title().'"';
        $output .= ' coming_years="'. get_metabox('coming_years').'"';
        $output .= ' coming_months="'.get_metabox('coming_months').'"';
        $output .= ' coming_days="'.  get_metabox('coming_days').'"';
        $output .= ' coming_hours="'. get_metabox('coming_hours').'"';
        $output .= ' coming_link="'.  get_metabox('coming_link').'"';
    $output .= ']';
        $output .= get_the_content();
    $output .= '[/tw_comingsoon]';
    echo apply_filters('widget_text', $output); ?>
</div>
<?php get_footer('comingsoon'); ?>