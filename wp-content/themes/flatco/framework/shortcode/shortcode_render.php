<?php
/* ================================================================================== */
/*      Accordion Shortcode
  /* ================================================================================== */

// Accordion container
if (!function_exists('shortcode_tw_accordion')) {

    function shortcode_tw_accordion($atts, $content) {
        $output = '<div class="tw-accordion">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_accordion', 'shortcode_tw_accordion');
// Accordion Item
if (!function_exists('shortcode_tw_accordion_item')) {

    function shortcode_tw_accordion_item($atts, $content) {
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $expand = (!empty($atts['item_expand']) && $atts['item_expand'] == 'true') ? true : false;
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        
        $output = '<div class="accordion-group '.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= '<div class="accordion-heading">';
        $output .= '<a class="accordion-toggle ' . ($expand ? ' active' : '') . '" data-toggle="collapse" data-parent="" href="#" style="background-color:' . $atts['color'] . ';">';
        $output .= $atts['item_title'];
        $output .= '<span class="tw-check"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '<div class="accordion-body collapse' . ($expand ? ' in' : '') . '" >';
        $output .= '<div class="accordion-inner">';
        $output .= apply_filters("the_content", $content);
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';


        return $output;
    }

}
add_shortcode('tw_accordion_item', 'shortcode_tw_accordion_item');



/* ================================================================================== */
/*      List Shortcode
  /* ================================================================================== */

// List container
if (!function_exists('shortcode_tw_list')) {

    function shortcode_tw_list($atts, $content) {
        $output = '<ul class="tw-list">';
        $output .= do_shortcode($content);
        $output .= '</ul>';
        return $output;
    }

}
add_shortcode('tw_list', 'shortcode_tw_list');
// List Item
if (!function_exists('shortcode_tw_list_item')) {

    function shortcode_tw_list_item($atts, $content) {
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        $output = '<li class="'.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'><i class="fa ' . $atts['item_icon'] . '"></i>' . do_shortcode($content) . '</li>';
        return $output;
    }

}
add_shortcode('tw_list_item', 'shortcode_tw_list_item');



/* ================================================================================== */
/*      Toggle Shortcode
  /* ================================================================================== */

// Toggle container
if (!function_exists('shortcode_tw_toggle')) {

    function shortcode_tw_toggle($atts, $content) {
        $output = '<div class="tw-toggle">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_toggle', 'shortcode_tw_toggle');
// Toggle Item
if (!function_exists('shortcode_tw_toggle_item')) {

    function shortcode_tw_toggle_item($atts, $content) {
        $atts['color'] = isset($atts['color'])?$atts['color']:'';
        $expand = (!empty($atts['item_expand']) && $atts['item_expand'] == 'true') ? true : false;
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        $output = '<div class="accordion-group'.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= '<div class="accordion-heading ' . ($expand ? ' active' : '') . '">';
        $output .= '<a class="accordion-toggle toggle ' . ($expand ? ' active' : '') . '" data-toggle="collapse" href="#" style="background-color:' . $atts['color'] . ';">';
        $output .= $atts['item_title'];
        $output .= '<span class="tw-check"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '<div class="accordion-body collapse' . ($expand ? ' in' : '') . '" >';
        $output .= '<div class="accordion-inner">';
        $output .= apply_filters("the_content", $content);
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

}
add_shortcode('tw_toggle_item', 'shortcode_tw_toggle_item');



/* ================================================================================== */
/*      Tab Shortcode
  /* ================================================================================== */

// Tab container
if (!function_exists('shortcode_tw_tab')) {

    function shortcode_tw_tab($atts, $content) {
        $position = (!empty($atts['position']) || $atts['position'] != 'top') ? (' tabs-' . $atts['position']) : '';
        $output = '<div class="tw-tab tabbable' . $position . '">';
        $output .= do_shortcode($content);
        $output .= '<ul class="nav nav-tabs"></ul>';
        $output .= '<div class="tab-content"></div>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_tab', 'shortcode_tw_tab');
// Tab Item
if (!function_exists('shortcode_tw_tab_item')) {

    function shortcode_tw_tab_item($atts, $content) {
        $atts = shortcode_atts(array(
            'title_icon' => '',
            'title' => '',
                ), $atts);
        $output = '<li>';
        $output .= '<a href="">';
        if (!empty($atts['title_icon'])) {
            $output .= '<i class="fa ' . $atts['title_icon'] . '"></i>';
        }
        if (!empty($atts['title'])) {
            $output .= '<span>' . $atts['title'] . '</span>';
        }
        $output .= '</a>';
        $output .= '</li>';
        $output .= '<div class="tab-pane" id="">';
        $output .= apply_filters("the_content", $content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_tab_item', 'shortcode_tw_tab_item');



/* ================================================================================== */
/*      Blog Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_blog')) {

    function shortcode_tw_blog($atts, $content) {
        global $tw_options;
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        } elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $output = '<div class="tw-blog">';
        $query = Array(
            'post_type' => 'post',
            'posts_per_page' => $atts['post_count'],
            'paged' => $paged,
        );
        $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
        if ($cats) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'category',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        $tw_options['pagination'] = isset($atts['pagination'])?$atts['pagination']:'none';
        $tw_options['excerpt_count'] = $atts['excerpt_count'];
        $tw_options['more_text'] = $atts['more_text'];
		
		$atts['layout'] = !empty($atts['layout']) ? $atts['layout'] : 'standard';
		
        if($atts['layout_size']==='span9'){
			$tw_options['layout'] = 'standard';
            if($atts['layout']!='standard')
                $tw_options['layout']='3';
        }elseif($atts['layout_size']==='span12'){
            switch ($atts['layout']){
                case '2':{ $tw_options['layout']='6';break;}
                case '3':{ $tw_options['layout']='4';break;}
                case '4':{ $tw_options['layout']='3';break;}
                case 'standard':{ $tw_options['layout']='standard';break;}
            }
        }
        
        if($tw_options['pagination']==='infinite'){
            wp_enqueue_script('blog-infinitescroll', THEME_DIR . '/assets/js/blog-infinitescroll.js', false, false, true);
        }
        if($tw_options['layout'] != 'standard'){
            add_action('wp_footer', 'portfolio_script');
        }
		
        query_posts($query);
        ob_start();
        get_template_part("loop");
        $output .= ob_get_clean();
        wp_reset_query();
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_blog', 'shortcode_tw_blog');



/* ================================================================================== */
/*      Column Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_column')) {

    function shortcode_tw_column($atts, $content) {
        $content = htmlspecialchars_decode($content);
        $output = apply_filters("the_content", $content);
        return $output;
    }

}
add_shortcode('tw_column', 'shortcode_tw_column');



/* ================================================================================== */
/*      Item Shortcode Container
  /* ================================================================================== */
if (!function_exists('shortcode_tw_item')) {

    function shortcode_tw_item($atts, $content) {
        if ($atts['row_type'] === 'row') {
            $atts['size'] = $atts['layout_size'];
        } else {
            if ($atts['layout_size'] === 'span3') {
                $atts['size'] = 'span12';
            }
        }
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        
        $output = '<div class="tw-element ' . $atts['size'] . ' ' . $atts['class'] .$class. '" '.($animated?'data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>' . do_shortcode($content) . '</div>';
        return $output;
    }

}
add_shortcode('tw_item', 'shortcode_tw_item');



/* ================================================================================== */
/*      Item Title Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_item_title')) {

    function shortcode_tw_item_title($atts, $content) {
        $output = '<div class="tw-title-container"><h3 class="tw-title">' . rawUrlDecode($atts['title']) . '</h3><span class="tw-title-border"></span></div>';
        return $output;
    }

}
add_shortcode('tw_item_title', 'shortcode_tw_item_title');



/* ================================================================================== */
/*      Layout Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_layout')) {

    function shortcode_tw_layout($atts, $content) {
        $output = '<div class="' . pbTextToFoundation($atts['size']) . ' ' . $atts['layout_custom_class'] . '">' . do_shortcode($content) . '</div>';
        return $output;
    }

}
add_shortcode('tw_layout', 'shortcode_tw_layout');



/* ================================================================================== */
/*      Core Content Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_content')) {

    function shortcode_tw_content() {
        return apply_filters("the_content", get_the_content());
    }

}
add_shortcode('tw_content', 'shortcode_tw_content');



/* ================================================================================== */
/*      Service Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_service')) {

    function shortcode_tw_service($atts, $content) {
        $output = '<div class="tw-service">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_service', 'shortcode_tw_service');



// Service Item
if (!function_exists('shortcode_tw_service_item')) {

    function shortcode_tw_service_item($atts, $content) {
        $style = '';
        $thumb = '';
        $thumbType = isset($atts['thumb_type']) ? $atts['thumb_type'] : 'fa';
        $style_for_desc = '';
        $margin_for_desc = '';
        if ($atts['service_style'] === 'style_2') {
            $style = 'left-service';
            $style_for_desc = 'desc_unstyle';
            $margin_for_desc = 'margin-left:' . ($thumbType === 'fa' ? ($atts['fa_size'] + $atts['fa_padding'] + $atts['fa_padding'] + 30) : ($thumbType === 'image'?(intval($atts['service_thumb_width']) + 30):(intval($atts['cc_size']) + 15))) . 'px;';
            if($thumbType === 'cc'){$margin_for_desc.='margin-right:15px;';}
        }
        if ($thumbType === 'image') {
            $thumb = isset($atts['service_thumb']) ? '<img title="' . $atts['title'] . '" width="' . $atts['service_thumb_width'] . '" src="' . $atts['service_thumb'] . '" />' : '';
        } elseif ($thumbType === 'fa') {
            $thumb = do_shortcode('[tw_fontawesome fa_type="' . $atts['fa_type'] . '" fa_size="' . $atts['fa_size'] . '" fa_padding="' . $atts['fa_padding'] . '" fa_color="' . $atts['fa_color'] . '" fa_bg_color="' . $atts['fa_bg_color'] . '" fa_border_color="' . $atts['fa_border_color'] . '" fa_rounded="' . $atts['fa_rounded'] . '" fa_icon="' . $atts['fa_icon'] . '"]');
        } elseif ($thumbType === 'cc') {
            $thumb = do_shortcode('[tw_chart_circle cc_type="' . $atts['cc_type'] . '" cc_line_width="' . $atts['cc_line_width'] . '" cc_text="' . $atts['cc_text'] . '" cc_percent="' . $atts['cc_percent'] . '" cc_size="' . $atts['cc_size'] . '" cc_font_size="' . $atts['cc_font_size'] . '" cc_font_color="' . $atts['cc_font_color'] . '" cc_color="' . $atts['cc_color'] . '" cc_track_color="' . $atts['cc_track_color'] . '" cc_icon="' . $atts['cc_icon'] . '"]');
        }
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }

        $output = '<div class="tw-service-box ' . $style .$class. '"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= '<div class="tw-service-icon">' . $thumb . '</div>';
        $output .= '<div class="tw-service-content ' . $style_for_desc . '" style="' . $margin_for_desc . '">';
        $output .= '<h3>' . $atts['title'] . '</h3>';
        $output .= '<p>' . do_shortcode($content) . '</p>';
        if (!empty($atts['more_url']))
            $output .= '<p><a href="' . $atts['more_url'] . '" target="' . $atts['more_target'] . '">' . $atts['more_text'] . '</a></p>';
        $output .= '</div>';
        $output .= "</div>";
        return $output;
    }

}
add_shortcode('tw_service_item', 'shortcode_tw_service_item');



/* ================================================================================== */
/*      Milestones Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_milestones')) {

    function shortcode_tw_milestones($atts, $content) {
        $output = '<div class="tw-milestones">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_milestones', 'shortcode_tw_milestones');

// Milestones Item
if (!function_exists('shortcode_tw_milestones_item')) {

    function shortcode_tw_milestones_item($atts, $content) {
        $atts['thumb_type']=isset($atts['thumb_type'])?$atts['thumb_type']:'fa';
        $thumb='';
        if($atts['thumb_type']==='fa'){
            $thumb = do_shortcode('[tw_fontawesome fa_type="' . $atts['fa_type'] . '" fa_size="' . $atts['fa_size'] . '" fa_padding="' . $atts['fa_padding'] . '" fa_color="' . $atts['fa_color'] . '" fa_bg_color="' . $atts['fa_bg_color'] . '" fa_border_color="' . $atts['fa_border_color'] . '" fa_rounded="' . $atts['fa_rounded'] . '" fa_icon="' . $atts['fa_icon'] . '"]');
        }else{
            $thumb = '<img src="'.$atts['image'].'" />';
        }
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        $output = '<div class="tw-milestones-box tw-animate'.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= '<div class="tw-milestones-icon">' . $thumb . '</div>';
        $output .= '<div class="tw-milestones-content">';
        $output .= '<div class="tw-milestones-count clearfix">';
        foreach (str_split($atts['count']) as $count) {
            $output .= '<div class="tw-milestones-show">';
            $output .= '<ul class="">';
            $count = intval($count);
            for ($i = 0; $i <= $count; $i++) {
                $output .= '<li class="">';
                $output .= $i;
                $output .= '</li>';
            }
            $output .= '</ul>';
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '<p>' . $atts['title'] . '</p>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_milestones_item', 'shortcode_tw_milestones_item');



/* ================================================================================== */
/*      Font Awesome Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_fontawesome')) {

    function shortcode_tw_fontawesome($atts, $content) {
        $atts['fa_size']=str_replace('px','',$atts['fa_size']);
        $atts['fa_padding']=str_replace('px','',$atts['fa_padding']);
        $atts['fa_rounded']=str_replace('px','',$atts['fa_rounded']);
        $style = 'text-align:center;';
        $style .='font-size:' . $atts['fa_size'] . 'px;';
        $style .='width:' . $atts['fa_size'] . 'px;';
        $style .='line-height:' . $atts['fa_size'] . 'px;';
        $style .='padding:' . $atts['fa_padding'] . 'px;';
        $style .='color:' . $atts['fa_color'] . ';';
        $style .='background-color:' . $atts['fa_bg_color'] . ';';
        $style .='border-color:' . $atts['fa_border_color'] . ';';
        $style .='border-width:' . $atts['fa_rounded'] . 'px;';
        $output = '<i class="tw-font-awesome fa ' . $atts['fa_icon'] . ' ' . $atts['fa_type'] . '" style="display: inline-block;border-style: solid;' . $style . '"></i>';
        return $output;
    }

}
add_shortcode('tw_fontawesome', 'shortcode_tw_fontawesome');



/* ================================================================================== */
/*      Chart Circle Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_chart_circle')) {

    function shortcode_tw_chart_circle($atts, $content) {
        wp_enqueue_script('easy-pie-chart', THEME_DIR . '/assets/js/jquery.easy-pie-chart.js', false, false, true);
        $atts = shortcode_atts(array(
            'cc_type' => 'cc',
            'cc_line_width' => '10',
            'cc_text' => '40%',
            'cc_percent' => '40',
            'cc_size' => '100',
            'cc_font_size' => '24',
            'cc_font_color' => '#000',
            'cc_color' => '#ecf0f1',
            'cc_track_color' => '#2dcb73',
            'cc_icon' => 'fa-umbrella',
            'item_animation_delay'=>'',
        ), $atts);
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation_offset']='none';}
        $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';

        $style = 'display:block; text-align:center; margin: 0 auto;';
        $style.='width:' . $atts['cc_size'] . 'px;';
        $style.='line-height:' . $atts['cc_size'] . 'px;';
        $cStyle = '';
        $cStyle.='color:' . $atts['cc_font_color'] . ';';
        $cStyle.='font-size:' . $atts['cc_font_size'] . 'px;';
        $data = '';
        $data .= ' data-percent="0"';
        $data .= ' data-percent-update="' . $atts['cc_percent'] . '"';
        $data .= ' data-line-width="' . $atts['cc_line_width'] . '"';
        $data .= ' data-size="' . $atts['cc_size'] . '"';
        $data .= ' data-color="' . $atts['cc_color'] . '"';
        $data .= ' data-track-color="' . $atts['cc_track_color'] . '"';
        $data .= ' data-gen-offset="90%"';
        $data .= ' data-gen-delay="'.$atts['item_animation_delay'].'"';
        $output = '';
        $output .='<div class="tw-circle-chart tw-animate"' . $data . '>';
        $output .='<span style="' . $cStyle . '">';
        if ($atts['cc_type'] === 'fa') {
            $output .='<i class="fa ' . $atts['cc_icon'] . '" style="' . $style . '"></i>';
        } else {
            $output .=$atts['cc_text'];
        }
        $output .='</span>';
        $output .='</div>';
        return $output;
    }

}
add_shortcode('tw_chart_circle', 'shortcode_tw_chart_circle');



/* ================================================================================== */
/*      Chart Graph Shortcode
  /* ================================================================================== */

// Chart Graph Container
if (!function_exists('shortcode_tw_chart_graph')) {

    function shortcode_tw_chart_graph($atts, $content) {
        wp_enqueue_script('chart', THEME_DIR . '/assets/js/Chart.min.js', false, false, true);
        $atts = shortcode_atts(array(
            'labels' => '',
            'item_height' => '',
            'type' => 'Line',
            'begin_at_zero' => 'false',
            'item_animation_delay'=>'',
        ), $atts);
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation_offset']='none';}
        $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        
        $atts['item_height'] = str_replace(' ','',$atts['item_height']);
        $output  = '<div class="tw-chart-graph tw-animate tw-redraw not-drawed" data-zero="' . $atts['begin_at_zero'] . '" data-labels="' . $atts['labels'] . '" data-type="' . $atts['type'] . '" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" data-item-height="'.$atts['item_height'].'">';
            $output .= '<ul style="display:none;" class="data">';
                $output .= do_shortcode($content);
            $output .= '</ul>';
            $output .= '<canvas></canvas>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_chart_graph', 'shortcode_tw_chart_graph');
// Chart Graph Item
if (!function_exists('shortcode_tw_chart_graph_item')) {

    function shortcode_tw_chart_graph_item($atts, $content) {
        $atts = shortcode_atts(array(
            'datas' => '',
            'fill_color' => '',
            'fill_text' => '',
                ), $atts);
        $output = '<li data-datas="' . $atts['datas'] . '" data-fill-color="' . $atts['fill_color'] . '" data-fill-text="' . $atts['fill_text'] . '"></li>';
        return $output;
    }

}
add_shortcode('tw_chart_graph_item', 'shortcode_tw_chart_graph_item');



/* ================================================================================== */
/*      Chart Pie Shortcode
  /* ================================================================================== */

// Chart Pie Container
if (!function_exists('shortcode_tw_chart_pie')) {

    function shortcode_tw_chart_pie($atts, $content) {
        wp_enqueue_script('chart', THEME_DIR . '/assets/js/Chart.min.js', false, false, true);
        $atts = shortcode_atts(array(
            'type' => 'PolarArea',
            'begin_at_zero' => 'false',
            'label_list' => 'false',
            'item_animation_delay'=>'',
        ), $atts);
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation_offset']='none';}
        $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        $output = '<div class="tw-chart-pie tw-animate tw-redraw not-drawed" data-labellist="' . $atts['label_list'] . '" data-zero="' . $atts['begin_at_zero'] . '" data-type="' . $atts['type'] . '" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'">';
            $output .= '<ul style="display:none;" class="data">';
                $output .= do_shortcode($content);
            $output .= '</ul>';
            $output .= '<canvas></canvas>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_chart_pie', 'shortcode_tw_chart_pie');
// Chart Pie Item
if (!function_exists('shortcode_tw_chart_pie_item')) {

    function shortcode_tw_chart_pie_item($atts, $content) {
        $atts = shortcode_atts(array(
            'value' => '',
            'color' => '',
            'fill_text' => '',
        ), $atts);
        $output = '<li data-value="' . $atts['value'] . '" data-color="' . $atts['color'] . '" data-fill-text="' . $atts['fill_text'] . '"></li>';
        return $output;
    }

}
add_shortcode('tw_chart_pie_item', 'shortcode_tw_chart_pie_item');



/* ================================================================================== */
/*      Divider Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_divider')) {

    function shortcode_tw_divider($atts, $content) {
        if ($atts['type'] == 'space')
            $output = '<div class="tw-divider-space" style="margin-bottom:' . $atts['height'] . 'px;"></div>';
        else
            $output = '<div class="tw-divider" style="margin-bottom:' . $atts['height']/2 . 'px;margin-top:' . $atts['height']/2 . 'px;"></div>';
        return $output;
    }

}
add_shortcode('tw_divider', 'shortcode_tw_divider');



/* ================================================================================== */
/*      Image Slider Shortcode
  /* ================================================================================== */
//  Image Slider Container
if (!function_exists('shortcode_tw_image')) {

    function shortcode_tw_image($atts, $content) {
        $output = '<div class="gallery-container clearfix">';
        $output .= '<div class="gallery-slide">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        $output .= '<div class="carousel-arrow">';
        $output .= '<a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>';
        $output .= '<a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_image', 'shortcode_tw_image');
//  Image Slider Item
if (!function_exists('shortcode_tw_image_item')) {

    function shortcode_tw_image_item($atts, $content) {
        $output = '<div class="slide-item">';
        $output .= '<img src="' . $atts['url'] . '" alt="' . get_the_title() . '" style="width:100%;">';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_image_item', 'shortcode_tw_image_item');































/* ================================================================================== */
/*      Messagebox Shortcode
  /* ================================================================================== */

// Messagebox container
if (!function_exists('shortcode_message_box')) {

    function shortcode_message_box($atts, $content) {
        $output = '<div class="tw-message-box">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_message_box', 'shortcode_message_box');
// Messagebox Item
if (!function_exists('shortcode_tw_message_box_item')) {

    function shortcode_tw_message_box_item($atts, $content) {
        $type = "alert-default";
        $icon = '';
        if ($atts['type'] == 'default') {
            
        } elseif ($atts['type'] == 'alert') {
            $type = "";
            $icon = '<i class="fa fa-warning"></i>';
        } elseif ($atts['type'] == 'info') {
            $type = "alert-info";
            $icon = '<i class="fa fa-info-circle"></i>';
        } elseif ($atts['type'] == 'success') {
            $type = "alert-success";
            $icon = '<i class="fa fa-check-circle"></i>';
        } elseif ($atts['type'] == 'error') {
            $type = "alert-error";
            $icon = '<i class="fa fa-remove"></i>';
        }
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        $output  = '<div class="alert ' . $type . $class . '"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        $output .= do_shortcode($content);
        $output .= $icon;
        $output .= '</div>';

        return $output;
    }

}
add_shortcode('tw_message_box_item', 'shortcode_tw_message_box_item');



/* ================================================================================== */
/*      Progress Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_progress')) {

    function shortcode_tw_progress($atts, $content) {
        return do_shortcode($content);
    }

}
add_shortcode('tw_progress', 'shortcode_tw_progress');
if (!function_exists('shortcode_tw_progress_item')) {

    function shortcode_tw_progress_item($atts, $content) {
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        
        $output = '<div class="progress'.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        if ($atts['type'] == 'animated')
            $output = '<div class="progress progress-striped active'.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        elseif ($atts['type'] == 'striped')
            $output = '<div class="progress progress-striped'.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= '<div class="bar ' . ($atts['type'] == 'default' ? 'tw-bi' : '') . '" style="width: ' . $atts['percent'] . '%;background-color: ' . $atts['color'] . '">' . $atts['progress_title'] . '</div><span>' . $atts['percent'] . '%</span>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_progress_item', 'shortcode_tw_progress_item');





/* ================================================================================== */
/*      Sidebar Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_sidebar')) {

    function shortcode_tw_sidebar($atts, $content) {
        ob_start();
        echo '<section id="sidebar">';
        if (!dynamic_sidebar($atts['name'])) {
            print 'There is no widget. You should add your widgets into <strong>';
            print $atts['name'];
            print '</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard. <br/><br/>';
        }
        echo '</section>';
        $output = ob_get_clean();
        return $output;
    }

}
add_shortcode('tw_sidebar', 'shortcode_tw_sidebar');






/* ================================================================================== */
/*      Video Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_video')) {

    function shortcode_tw_video($atts, $content) {

        $video_embed = $content;
        $video_thumb = $atts['video_thumb'];
        $video_m4v = $atts['video_m4v'];
        $video_type = $atts['insert_type'];

        ob_start();

        if ($video_type == 'type_bg') {
            echo '<div class="bg-video-container">';
                echo '<i class="bg-video-play tw-font-icon fa fa-play"></i>';
                echo '<h2 class="bg-video-text">'.$atts['video_text'].'</h2>';
            echo '</div>';
        } elseif ($video_type == 'type_embed') {
            echo apply_filters("the_content", $video_embed);
        } elseif (!empty($video_m4v)) {
            global $post;
            add_action('wp_footer', 'jplayer_script');
            ?>

            <div id="jquery_jplayer_<?php echo $post->ID; ?>" class="jp-jplayer jp-jplayer-video" data-pid="<?php echo $post->ID; ?>" data-m4v="<?php echo $video_m4v; ?>" data-thumb="<?php echo $video_thumb; ?>"></div>
            <div class="jp-video-container">
                <div class="jp-video">
                    <div class="jp-type-single">
                        <div id="jp_interface_<?php echo $post->ID; ?>" class="jp-interface">
                            <ul class="jp-controls">
                                <li><div class="seperator-first"></div></li>
                                <li><div class="seperator-second"></div></li>
                                <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                                <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                                <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                                <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                            </ul>
                            <div class="jp-progress-container">
                                <div class="jp-progress">
                                    <div class="jp-seek-bar">
                                        <div class="jp-play-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-volume-bar-container">
                                <div class="jp-volume-bar">
                                    <div class="jp-volume-bar-value"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        $output = ob_get_clean();
        return $output;
    }

}
add_shortcode('tw_video', 'shortcode_tw_video');





/* ================================================================================== */
/*      Callout Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_callout')) {
    function shortcode_tw_callout($atts, $content) {
        $Callout_bt = isset($atts['btn_text']) ? $atts['btn_text'] : '';
        $Callout_bt_url = !empty($atts['btn_url']) ? $atts['btn_url'] : '#';
        $Callout_bt_color = !empty($atts['btn_url']) ? (' style="background-color:'.$atts['btn_color'].';border-color:'.$atts['btn_color'].'"') : '#';
        $Callout_bt_target = isset($atts['btn_target']) ? $atts['btn_target'] : '_blank';
        $Callout_bt_full = '<a href="' . $Callout_bt_url . '"' . $Callout_bt_color . ' target="' . $Callout_bt_target . '" class="btn btn-flat btn-large">' . $Callout_bt . '</a>';
        
        $output = '<div class="tw-callout' . (!empty($Callout_bt) ? ' with-button' : '') . '">';
        $output .= '<div class="callout-text">';
        $output .= '<h1>' . do_shortcode($content) . '</h1>';
        $output .= '<p>' . $atts['description'] . '</p>';
        $output .=!empty($Callout_bt) ? $Callout_bt_full : '';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
add_shortcode('tw_callout', 'shortcode_tw_callout');


/* ================================================================================== */
/*      Slider Shortcode
/* ================================================================================== */
function shortcode_tw_slider($atts, $content) {
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'layout_size' => 'col-md-12',
        'class' => '',
        'element_padding' => '',
        'element_color' => '',
        'element_dark_light' => 'light',
        'animation' => 'none',
        'animation_delay' => '',
        // ----------------
        'slider_type'     => 'masterslider',
        'masterslider_id' => '',
        'layerslider_id'  => '',
        'revslider_id'    => '',
    ), $atts);
    $output = '<div class="waves-slider">';
        $slider='';
        $id='';
        if($atts['slider_type']==='masterslider'&&!empty($atts['masterslider_id'])){
            $slider='[masterslider id="'.esc_attr($atts['masterslider_id']).'"]';
        }elseif($atts['slider_type']==='layerslider'&&!empty($atts['layerslider_id'])){
            $slider='[layerslider id="'.esc_attr($atts['layerslider_id']).'"]';
        }elseif($atts['slider_type']==='revslider'&&!empty($atts['revslider_id'])){
            $slider='[rev_slider '.esc_attr($atts['revslider_id']).']';
        }
        if(!empty($slider)){
            $output .= do_shortcode($slider);
        }else{
            $output .= '<pre>'.esc_html__('Choose Slider','themewaves').'</pre>';
        }
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_slider', 'shortcode_tw_slider');


/* ================================================================================== */
/*      Pricing Table Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_pricing_table')) {

    function shortcode_tw_pricing_table($atts, $content) {
        $output = '<div class="tw-pricing clearfix">';
        $query = Array(
            'post_type' => 'tw_price',
            'posts_per_page' => $atts['column'],
        );
        $cats = empty($atts['price_category_list']) ? false : explode(",", $atts['price_category_list']);
        if ($cats) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'cat_price',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        switch ($atts['column']) {
            case'2': {
                    $columnWidth = 'tw-pricing-two';
                    break;
                }
            case'3': {
                    $columnWidth = 'tw-pricing-three';
                    break;
                }
            case'4': {
                    $columnWidth = 'tw-pricing-four';
                    break;
                }
            case'5': {
                    $columnWidth = 'tw-pricing-five';
                    break;
                }
        }
        query_posts($query);
        while (have_posts()) {
            the_post();
            $subprice = get_metabox('subprice') ? get_metabox('subprice') : '.00';
            $color = get_metabox('color') != '' ? (' style="background:' . get_metabox('color') . '"') : '';
            $output .= '<div class="' . $columnWidth . ' tw-pricing-col">';
            $output .= '<div class="tw-pricing-box">';
            $output .= '<div class="tw-pricing-header"' . $color . '>';
            $output .= '<h1>' . get_the_title() . '</h1>';
//                        if(get_metabox('subtitle')!="") $output .= ('<p>'.get_metabox('subtitle').'</p>');
            $output .= '</div>';
            $output .= '<div class="tw-pricing-top">';
            $output .= '<span>' . get_metabox('price') . '</span><span><span>'.$subprice.'</span>' . get_metabox('time') . '</span>';
            $output .= '</div>';
            $output .= '<div class="tw-pricing-bottom">';
            $output .= get_the_content();
            $output .= '</div>';
            if (get_metabox('buttontext') != "") {
                $output .= '<div class="tw-pricing-footer">';
                $output .= '<a href="' . (get_metabox('buttonlink') != "" ? get_metabox('buttonlink') : "#") . '" class="btn"' . $color . '>' . get_metabox('buttontext') . '</a>';
                $output .= '</div>';
            }
            $output .= '</div>';
            $output .= '</div>';
        }
        wp_reset_query();
        $output .= '</div>';

        return $output;
    }

}
add_shortcode('tw_pricing_table', 'shortcode_tw_pricing_table');





/* ================================================================================== */
/*      Testimonials Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_testimonials')) {

    function shortcode_tw_testimonials($atts, $content) {
        $direction = empty($atts['direction']) ? 'up' : $atts['direction'];
        $duration = empty($atts['duration']) ? '1000' : $atts['duration'];
        $timeout = empty($atts['timeout']) ? '2000' : $atts['timeout'];
        $bg_color = empty($atts['bg_color']) ? '' : (' style="background:' . $atts['bg_color'] . '"');
        $text_color = empty($atts['text_color']) ? '' : (' style="color:' . $atts['text_color'] . '"');
        $name_color = empty($atts['name_color']) ? '' : (' style="color:' . $atts['name_color'] . '"');
        $output = '<div class="tw-testimonials clearfix" data-direction="' . $direction . '" data-duration="' . $duration . '" data-timeout="' . $timeout . '"><ul>';
        $query = Array(
            'post_type' => 'tw_testimonial',
            'posts_per_page' => $atts['count'],
        );
        $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
        if ($cats) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'cat_testimonial',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        query_posts($query);
        while (have_posts()) {
            the_post();
            $output .= '<li>';
            $output .= '<div class="testimonial-item clearfix"' . $bg_color . '>';
            $output .= '<div class="testimonial-author">';
            $output .= post_image_show(70, 70);
            $output .= '</div>';
            $output .= '<div class="testimonial-content"' . $text_color . '>';
            $output .= get_the_content();
            $output .= '<p' . $name_color . '>' . get_metabox('name') . ' <a href="' . get_metabox('url') . '"' . $name_color . '>/ ' . get_metabox('company') . ' /</a></p>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</li>';
        }
        wp_reset_query();
        $output .= '</ul>';
        $output .= '<div class="carousel-arrow">';
        $output .= '<a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>';
        $output .= '<a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

}
add_shortcode('tw_testimonials', 'shortcode_tw_testimonials');





/* ================================================================================== */
/*      Team Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_team')) {

    function shortcode_tw_team($atts, $content) {
        $output = '<div class="tw-our-team">';
        $query = Array(
            'post_type' => 'tw_team',
            'posts_per_page' => $atts['count'],
        );
        $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
        if ($cats) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'cat_team',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        $width = 270;
        $height = $atts['height'];
        query_posts($query);
        while (have_posts()) {
            the_post();
            $output .= '<div class="team-member span3">';
                $output .= '<div class="member-image loop-image">';
                    $output .= post_image_show($width, $height);
                    $teamContent=get_the_content();
                    if(!empty($teamContent)){
                        $output .='<div class="image-overlay">';
                            $output .='<div class="team-content">';
                                $output .=$teamContent;
                            $output .='</div>';
                        $output .='</div>';
                    }
                $output .='</div>';

                if (get_metabox('bg_color') != "")
                    $output .= '<div class="member-title" style="background:' . get_metabox('bg_color') . '">';
                else
                    $output .= '<div class="member-title">';
                $output .= '<h2>';
                    if(get_metabox('custom_link')){$output .= '<a title="'.get_the_title().'" href="'.get_metabox('custom_link').'">';}
                        $output .=  get_the_title();
                    if(get_metabox('custom_link')){$output .= '</a>';}
                $output .= '</h2>';
                if (get_metabox('position') != "")
                    $output .= '<span>' . get_metabox('position') . '</span>';
            $output .= '</div>';


            if (get_metabox('facebook') != "" || get_metabox('google') != "" || get_metabox('twitter') != "" || get_metabox('linkedin') != "") {
                $output .= '<div class="member-social"><div class="tw-social-icon clearfix">';
                if (get_metabox('facebook') != "")
                    $output .= '<a href="' . to_url(get_metabox('facebook')) . '" target="_blank" class="facebook"><span class="tw-icon-facebook"></span></a>';
                if (get_metabox('google') != "")
                    $output .= '<a href="' . to_url(get_metabox('google')) . '" target="_blank" class="gplus"><span class="tw-icon-gplus"></span></a>';
                if (get_metabox('twitter') != "")
                    $output .= '<a href="' . to_url(get_metabox('twitter')) . '" target="_blank" class="twitter"><span class="tw-icon-twitter"></span></a>';
                if (get_metabox('linkedin') != "")
                    $output .= '<a href="' . to_url(get_metabox('linkedin')) . '" target="_blank" class="linkedin"><span class="tw-icon-linkedin"></span></a>';
                if (get_metabox('soundcloud') != "")
                    $output .= '<a href="' . to_url(get_metabox('soundcloud')) . '" target="_blank" class="soundcloud"><span class="tw-icon-soundcloud"></span></a>';
                $output .= '</div></div>';
            }
            $output .= '</div>';
        }
        wp_reset_query();
        $output .= '</div>';

        return $output;
    }

}
add_shortcode('tw_team', 'shortcode_tw_team');





/* ================================================================================== */
/*      Twitter Shortcode
  /* ================================================================================== */

function twitter_build($atts) {
    require_once (THEME_PATH . "/framework/twitteroauth.php");
    $atts = shortcode_atts(array(
        'consumerkey' => tw_option('consumerkey'),
        'consumersecret' => tw_option('consumersecret'),
        'accesstoken' => tw_option('accesstoken'),
        'accesstokensecret' => tw_option('accesstokensecret'),
        'cachetime' => '1',
        'username' => 'themewaves',
        'tweetstoshow' => '10',
            ), $atts);
    //check settings and die if not set
    if (empty($atts['consumerkey']) || empty($atts['consumersecret']) || empty($atts['accesstoken']) || empty($atts['accesstokensecret']) || !isset($atts['cachetime']) || empty($atts['username'])) {
        return '<p>' . __('Due to Twitter API changed you must insert Twitter APP. Check Our theme Options there you have Option for FB Twitter API, insert the Keys One Time', 'themewaves') . '</p>';
    }
    //check if cache needs update
    $tw_twitter_last_cache_time = get_option('tw_twitter_last_cache_time_' . $atts['username']);
    $diff = time() - $tw_twitter_last_cache_time;
    $crt = $atts['cachetime'] * 3600;

    //yes, it needs update			
    if ($diff >= $crt || empty($tw_twitter_last_cache_time)) {
        $connection = new TwitterOAuth($atts['consumerkey'], $atts['consumersecret'], $atts['accesstoken'], $atts['accesstokensecret']);
        $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $atts['username'] . "&count=10") or die('Couldn\'t retrieve tweets! Wrong username?');
        if (!empty($tweets->errors)) {
            if ($tweets->errors[0]->message == 'Invalid or expired token') {
                return '<strong>' . $tweets->errors[0]->message . '!</strong><br />'.__('You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!','themewaves');
            } else {
                return '<strong>' . $tweets->errors[0]->message . '</strong>';
            }
            return;
        }
        $tweets_array = array();
        for ($i = 0; is_array($tweets) && $i <= count($tweets); $i++) {
            if (!empty($tweets[$i])) {
                $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
                $tweets_array[$i]['text'] = $tweets[$i]->text;
                $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
            }
        }
        //save tweets to wp option 		
        update_option('tw_twitter_tweets_' . $atts['username'], rawUrlEncode(serialize($tweets_array)));
        update_option('tw_twitter_last_cache_time_' . $atts['username'], time());
        echo '<!-- twitter cache has been updated! -->';
    }
    //convert links to clickable format
    if (!function_exists('convert_links')) {

        function convert_links($status, $targetBlank = true, $linkMaxLen = 250) {
            // the target
            $target = $targetBlank ? " target=\"_blank\" " : "";
            // convert link to url
            $status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);
            // convert @ to follow
            $status = preg_replace("/(@([_a-z0-9\-]+))/i", "<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>", $status);
            // convert # to search
            $status = preg_replace("/(#([_a-z0-9\-]+))/i", "<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>", $status);
            // return the status
            return $status;
        }

    }
    //convert dates to readable format
    if (!function_exists('relative_time')) {

        function relative_time($a) {
            //get current timestampt
            $b = strtotime("now");
            //get timestamp when tweet created
            $c = strtotime($a);
            //get difference
            $d = $b - $c;
            //calculate different time values
            $minute = 60;
            $hour = $minute * 60;
            $day = $hour * 24;
            $week = $day * 7;
            if (is_numeric($d) && $d > 0) {
                //if less then 3 seconds
                if ($d < 3)
                    return (tw_option('tw_car_rn') ? tw_option('tw_car_rn') : __('right now', 'themewaves'));
                //if less then minute
                if ($d < $minute)
                    return floor($d) . (tw_option('tw_car_sa') ? tw_option('tw_car_sa') : __(' seconds ago', 'themewaves'));
                //if less then 2 minutes
                if ($d < $minute * 2)
                    return (tw_option('tw_car_aoma') ? tw_option('tw_car_aoma') : __('about 1 minute ago', 'themewaves'));
                //if less then hour
                if ($d < $hour)
                    return floor($d / $minute) . (tw_option('tw_car_ma') ? tw_option('tw_car_ma') : __(' minutes ago', 'themewaves'));
                //if less then 2 hours
                if ($d < $hour * 2)
                    return (tw_option('tw_car_aoha') ? tw_option('tw_car_aoha') : __('about 1 hour ago', 'themewaves'));
                //if less then day
                if ($d < $day)
                    return floor($d / $hour) . (tw_option('tw_car_ha') ? tw_option('tw_car_ha') : __(' hours ago', 'themewaves'));
                //if more then day, but less then 2 days
                if ($d > $day && $d < $day * 2)
                    return (tw_option('tw_car_yes') ? tw_option('tw_car_yes') : __('yesterday', 'themewaves'));
                //if less then year
                if ($d < $day * 365)
                    return floor($d / $day) . (tw_option('tw_car_da') ? tw_option('tw_car_da') : __(' days ago', 'themewaves'));
                //else return more than a year
                return __("over a year ago","themewaves");
                return (tw_option('tw_car_oaya') ? tw_option('tw_car_oaya') : __('over a year ago', 'themewaves'));
            }
        }

    }
    $tw_twitter_tweets = maybe_unserialize(rawUrlDecode(get_option('tw_twitter_tweets_' . $atts['username'])));
    return $tw_twitter_tweets;
}

if (!function_exists('shortcode_tw_twitter')) {

    function shortcode_tw_twitter($atts, $content) {
        $tw_twitter_tweets = twitter_build($atts);
        if (is_array($tw_twitter_tweets)) {
            $output = '<div class="tw-twitter">';
            $output.='<ul class="jtwt">';
            $fctr = '1';
            foreach ($tw_twitter_tweets as $tweet) {
                $output.='<li><span>' . convert_links($tweet['text']) . '</span><br /><a class="twitter_time" target="_blank" href="http://twitter.com/' . $atts['username'] . '/statuses/' . $tweet['status_id'] . '">' . relative_time($tweet['created_at']) . '</a></li>';
                if ($fctr == $atts['tweetstoshow']) {
                    break;
                }
                $fctr++;
            }
            $output.='</ul>';
            $output.='<div class="twitter-follow">'  . (tw_option('tw_car_follow') ? tw_option('tw_car_follow') : __('Follow Us', 'themewaves')) . ' - <a target="_blank" href="http://twitter.com/' . $atts['username'] . '">@' . $atts['username'] . '</a></div>';
            $output.='</div>';
            return $output;
        } else {
            return $tw_twitter_tweets;
        }
    }

}
add_shortcode('tw_twitter', 'shortcode_tw_twitter');



if (!function_exists('shortcode_tw_twitter_carousel')) {

    function shortcode_tw_twitter_carousel($atts, $content) {
        $tw_twitter_tweets = twitter_build($atts);
        if (is_array($tw_twitter_tweets)) {
            $arrow = '<div class="carousel-arrow tw-carrow">';
            $arrow .= '<a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>';
            $arrow .= '<a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>';
            $arrow .= '</div>';
            $output = '<div class="tw-twitter">';
            $output .= '<div class="carousel-container">';
            $output .= '<div class="tw-carousel-twitter list_carousel">';
            $output .='<i class="fa fa-twitter"></i>';
            $output.='<ul class="jtwt tw-carousel">';
            $fctr = '1';
            foreach ($tw_twitter_tweets as $tweet) {
                $output.='<li><span>' . convert_links($tweet['text']) . '</span><br />- <a class="twitter_time" target="_blank" href="http://twitter.com/' . $atts['username'] . '/statuses/' . $tweet['status_id'] . '">' . relative_time($tweet['created_at']) . '</a></li>';
                if ($fctr == $atts['tweetstoshow']) {
                    break;
                }
                $fctr++;
            }
            $output.='</ul>';
            $output.='<div class="twitter-follow">' . (tw_option('tw_car_follow') ? tw_option('tw_car_follow') : __('Follow Us', 'themewaves')) . ' - <a target="_blank" href="http://twitter.com/' . $atts['username'] . '">@' . $atts['username'] . '</a></div>';
            $output .= $arrow;
            $output.='</div>';
            $output.='</div>';
            $output.='</div>';
            return $output;
        } else {
            return $tw_twitter_tweets;
        }
    }

}
add_shortcode('tw_twitter_carousel', 'shortcode_tw_twitter_carousel');





/* ================================================================================== */
/*      Portfolio Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_portfolio')) {

    function shortcode_tw_portfolio($atts, $content) {
        $atts = shortcode_atts(array(
            'layout_size' => 'span12',
            'pagination' => 'simple',
            'height' => '',
            'column' => '4',
            'count' => 12,
            'filter' => 'none',
            'category_ids' => '',
            'hide_hover' => 'false',
            'hide_favorites' => 'false',
            'button_text' => '',
            'link_type'   => 'view_large',
            'order' => ''
        ), $atts);
        global $portAtts, $paged, $tw_options;
        $portAtts = $atts;
        if ($atts['layout_size'] === 'span3') {
            $tw_options['column'] = '1';
        } elseif ($atts['layout_size'] === 'span9') {
            $tw_options['column'] = '3';
        } elseif ($atts['layout_size'] === 'span12') {
            switch ($atts['column']) {
                case '2': {
                        $tw_options['column'] = '6';
                        break;
                    }
                case '3': {
                        $tw_options['column'] = '4';
                        break;
                    }
                case '4': {
                        $tw_options['column'] = '3';
                        break;
                    }
            }
        }

        if (get_query_var('paged'))
            $my_page = get_query_var('paged');
        else {
            if (get_query_var('page'))
                $my_page = get_query_var('page');
            else
                $my_page = 1;
            set_query_var('paged', $my_page);
        }
        add_action('wp_footer', 'portfolio_script');
        $tw_options['pagination'] = $atts['pagination'];
        $tw_options['height'] = $atts['height'];
        $query = Array(
            'post_type' => 'tw_portfolio',
            'posts_per_page' => $atts['count'],
        );
        if ($tw_options['pagination'] == "simple" || $tw_options['pagination'] == "infinite") {
            $query['paged'] = $my_page;
        }
        $cats = empty($atts['category_ids']) ? false : explode(",", $atts['category_ids']);
        if ($cats) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'cat_portfolio',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        if (!empty($atts['order'])) {
            switch ($atts['order']) {
                case "date_asc":
                    $query['orderby'] = 'date';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_asc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_desc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'DESC';
                    break;
                case "random":
                    $query['orderby'] = 'rand';
                    break;
            }
        }
        $output = '<div class="tw-portfolio">';
        $filter = (!empty($atts['filter']) && $atts['filter'] == 'true') ? true : false;
        if ($filter) {
            $output .= '<div class="tw-filter">';
            $output .= '<ul class="filters option-set clearfix post-category inline" data-option-key="filter">';
            $output .= '<li><a href="#filter" data-option-value="*" class="selected">' . (tw_option('portfolio_show_all') ? tw_option('portfolio_show_all') : __('Show All', 'themewaves')) . '</a></li>';
            if ($cats) {
                $filters = $cats;
            } else {
                $filters = get_terms('cat_portfolio');
            }
            foreach ($filters as $category) {
                if ($cats) {
                    $category = get_term_by('id', $category, 'cat_portfolio');
                }
                $output .= '<li class="hidden"><a href="#filter" data-option-value=".category-' . $category->slug . '" title="' . $category->name . '">' . $category->name . '</a></li>';
            }
            $output .= '</ul></div>';
        }
        if(!is_tax())
            query_posts($query);
        ob_start();
        get_template_part("loop", "portfolio");
        $output .= ob_get_clean();
        wp_reset_query();
        $output .= '</div>';
        return $output;
    }

}

function portfolio_script() {
    wp_enqueue_script('isotope', THEME_DIR . '/assets/js/jquery.isotope.min.js', false, false, true);
}

add_shortcode('tw_portfolio', 'shortcode_tw_portfolio');












/* ================================================================================== */
/*      Recent Posts Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_recent_posts')) {

    function shortcode_tw_recent_posts($atts, $content) {
        global $portAtts;
        $portAtts = $atts;
        $atts['excerpt_count']=isset($atts['excerpt_count'])?intval($atts['excerpt_count']):50;
        $more_text      = !empty($atts['more_text'])     ?$atts['more_text']     :(tw_option('translate_readmore') ? tw_option('translate_readmore') : __('Continue Reading', 'themewaves'));
        $more_text_show = isset($atts['more_text_show'])?$atts['more_text_show']:'false';
        
        $hide_meta      = isset($atts['hide_meta'])?$atts['hide_meta']:'false';
        $post_count     = isset($atts['post_count']) ? $atts['post_count'] : '';
        $post_category_list = isset($atts['post_category_list']) ? $atts['post_category_list'] : '';
        $arrow = '<div class="carousel-arrow tw-carrow">';
        $arrow .= '<a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>';
        $arrow .= '<a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>';
        $arrow .= '</div>';

        $output = '<div class="carousel-container">';
        $output .= '<div class="tw-carousel-post list_carousel">';
        $output .= '<ul class="tw-carousel">';
        $query = Array(
            'post_type' => 'post',
            'posts_per_page' => $post_count,
        );
        $cats = explode(",", $post_category_list);
        if (!empty($cats[0])) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'category',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        if (!empty($atts['order'])) {
            switch ($atts['order']) {
                case "date_asc":
                    $query['orderby'] = 'date';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_asc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_desc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'DESC';
                    break;
                case "random":
                    $query['orderby'] = 'rand';
                    break;
            }
        }
        $imgwidth = 370;
        // START - LOOP
        query_posts($query);
        while (have_posts()){ the_post();
            $imgheight = $atts['image_height'];
            $output .= '<li>';
                if(get_post_format()=="video"){
                    $output .= '<div class="carousel-video" style="height:'.$imgheight.'px;">';
                    ob_start();
                    format_video();
                    $output .= ob_get_clean();
                    $output .= '</div>';
                }else{
                    if(post_image_show()){
                        ob_start();
                        portfolio_image($imgwidth, $imgheight);
                        $output .= ob_get_clean();
                    }
                }
                $output .= '<div class="carousel-content">';
                    if($hide_meta==='false'){
                        $output .= '<div class="carousel-meta clearfix"><div class="date"><i class="fa fa-calendar-o"></i>'.get_the_time('j M Y').'</div><div class="comment-count"><i class="fa fa-comment-o"></i>'.comment_count().'</div></div>';
                    }
                    $output .= '<h3><a href="'.get_permalink().'" class="carousel-post-title">'.get_the_title().'</a></h3>';
                    $output .= '<p>'.to_excerpt(get_the_content(), $atts['excerpt_count']).'</p>';
                    if($more_text_show==='true'){
                        $output .= '<div class="read-more-container"><a href="'.get_permalink().'" class="more-link">'.apply_filters("widget_title", $more_text).'</a></div>';
                    }
                $output .= '</div>';
            $output .= '</li>';
        }
        wp_reset_query();
        // END   - LOOP
        $output .= '</ul>';
        $output .= '<div class="clearfix"></div>';
        $output .= $arrow;
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_recent_posts', 'shortcode_tw_recent_posts');









/* ================================================================================== */
/*      Recent Portfolios Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_recent_portfolios')) {

    function shortcode_tw_recent_portfolios($atts, $content) {
        global $portAtts;
        $hide_favorites = isset($atts['hide_favorites']) ? $atts['hide_favorites'] : 'false';
        $portAtts = $atts;
        $post_count = isset($atts['post_count']) ? $atts['post_count'] : '';
        $desc_title = !empty($atts['description_title']) ? $atts['description_title'] : '';
        $desc_text = !empty($atts['description_text']) ? $atts['description_text'] : '';
        $port_category_list = isset($atts['port_category_list']) ? $atts['port_category_list'] : '';
        $arrow = '<div class="carousel-arrow tw-carrow">';
        $arrow .= '<a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>';
        $arrow .= '<a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>';
        $arrow .= '</div>';
        $output = '';
        if (!empty($desc_text)) {
            $output .= '<div class="row-fluid carousel-container">';
            $output .= '<div class="span3 carousel-text tw-title-container">';
            $output .=!empty($desc_title) ? ('<div class="tw-title-container"><h3 class="tw-title">' . $desc_title . '</h3><span class="tw-title-border"></span></div>') : '';
            $output .= '<p>' . $desc_text . '</p>';
            $output .= $arrow . '</div>';
            $output .= '<div class="span9">';
        } else {
            $output .= '<div class="carousel-container">';
        }


        $output .= '<div class="tw-carousel-portfolio list_carousel">';
        $output .= '<ul class="tw-carousel">';
        $query = Array(
            'post_type' => 'tw_portfolio',
            'posts_per_page' => $post_count,
        );
        $cats = explode(",", $port_category_list);
        if (!empty($cats[0])) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'cat_portfolio',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        if (!empty($atts['order'])) {
            switch ($atts['order']) {
                case "date_asc":
                    $query['orderby'] = 'date';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_asc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_desc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'DESC';
                    break;
                case "random":
                    $query['orderby'] = 'rand';
                    break;
            }
        }
        $imgwidth = 270;
        // START - LOOP
        query_posts($query);
        while (have_posts()){ the_post();
            global $post;
            $imgheight = $atts['image_height'];
            $likeit = get_post_meta($post->ID, 'post_likeit', true);
            $likecount = empty($likeit) ? '0' : $likeit;
            $likedclass = 'likeit';
            if (isset($_COOKIE['likeit-' . $post->ID])) {
                $likedclass .= ' liked';
            }

            $output .= '<li>';
                $ids = get_metabox('gallery_image_ids');
                $video_embed = get_metabox('format_video_embed');
                $video_url   = get_metabox('pretty_video_url');
                ob_start();                
                
                if (has_post_thumbnail($post->ID)) {
                    if(!empty($video_url)&&get_metabox('pretty_video')==='true'){
                        portfolio_image($imgwidth,$imgheight,true,$video_url);                            
                    }else{
                        portfolio_image($imgwidth,$imgheight);
                    }
                } elseif($ids!="false" && $ids!="") {
                    portfolio_gallery($imgwidth,$imgheight,$ids);
                } elseif(!empty($video_embed)) {
                    echo '<div class="carousel-video">';
                    echo apply_filters("the_content", htmlspecialchars_decode($video_embed));
                    echo '</div>';
                }
                
                $output .= ob_get_clean();

                $output .= '<div class="portfolio-content">';
                        $output .= '<h2 class="portfolio-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                        if($hide_favorites==='false'){
                            $output .= '<div data-ajaxurl="'.home_url().'" data-pid="'.$post->ID.'" class="'.$likedclass.'">';
                                $output .= '<i class="fa fa-heart"></i><span>'.$likecount.'</span>';
                            $output .= '</div>';
                        }
                $output .= '</div>';
            $output .= '</li>';
        }
        wp_reset_query();
        // END   - LOOP
        $output .= '</ul>';
        $output .= '<div class="clearfix"></div>';
        if(empty($desc_text)) $output .= $arrow;
        $output .= '</div>';
        if (!empty($desc_text)) {
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }
}
add_shortcode('tw_recent_portfolios', 'shortcode_tw_recent_portfolios');









/* ================================================================================== */
/*      Partner Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_partner')) {

    function shortcode_tw_partner($atts, $content) {
        $category_list = isset($atts['partner_category_list']) ? $atts['partner_category_list'] : '';
        $arrow = '<div class="carousel-arrow tw-carrow">';
        $arrow .= '<a class="carousel-prev" href="#"><i class="fa fa-chevron-left"></i></a>';
        $arrow .= '<a class="carousel-next" href="#"><i class="fa fa-chevron-right"></i></a>';
        $arrow .= '</div>';

        $output = '<div class="carousel-container">';

        $output .= '<div class="tw-carousel-partner list_carousel">';
        $output .= '<ul class="tw-carousel">';
        $query = Array(
            'post_type' => 'tw_partner',
            'posts_per_page' => -1,
        );
        $cats = explode(",", $category_list);
        $imgwidth = 270;
        if (!empty($cats[0])) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'cat_partner',
                    'terms' => $cats,
                    'field' => 'id'
                )
            );
        }
        if (!empty($atts['order'])) {
            switch ($atts['order']) {
                case "date_asc":
                    $query['orderby'] = 'date';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_asc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'ASC';                    
                    break;
                case "title_desc":
                    $query['orderby'] = 'title';
                    $query['order'] = 'DESC';
                    break;
                case "random":
                    $query['orderby'] = 'rand';
                    break;
            }
        }
        // START - LOOP
        query_posts($query);
        while (have_posts()) {
            the_post();
            $imgheight = $atts['image_height'];
            $output .= '<li>';
            if (get_metabox('link') != '') {
                $output .= '<a href="' . to_url(get_metabox('link')) . '" target="_blank">';
                $output .= post_image_show($imgwidth, $imgheight);
                $output .= '</a>';
            } else {
                $output .= post_image_show($imgwidth, $imgheight);
            }
            $output .= '</li>';
        }
        wp_reset_query();
        // END   - LOOP
        $output .= '</ul>';
        $output .= '<div class="clearfix"></div>';
        $output .= $arrow;
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_partner', 'shortcode_tw_partner');








/* ================================================================================== */
/*      Dropcap Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_dropcap')) {

    function shortcode_tw_dropcap($atts, $content) {
        $class = '';
        $style = 'style="background-color: ' . $atts['color'] . ';"';
        if ($atts['style'] == 'circle') {
            $class = ' cap_circle';
        } elseif ($atts['style'] == 'circle_border') {
            $class = ' cap_circle cap_border';
            $style = 'style="border-color: ' . $atts['color'] . '; color: ' . $atts['color'] . '"';
        } elseif ($atts['style'] == 'square_border') {
            $class = ' cap_border';
            $style = 'style="border-color: ' . $atts['color'] . '; color: ' . $atts['color'] . '"';
        }
        return '<span class="tw-dropcap' . $class . '" ' . $style . '>' . $content . '</span>';
    }

}
add_shortcode('tw_dropcap', 'shortcode_tw_dropcap');





/* ================================================================================== */
/*      Button Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_button')) {

    function shortcode_tw_button($atts, $content) {
        $rounded = !empty($atts['rounded']) && $atts['rounded'] == 'true' ? ' rounded' : '';
        $link = !empty($atts['link']) ? $atts['link'] : '#';
        $style = !empty($atts['style']) ? (' btn-' . $atts['style']) : '';
        $hover = !empty($atts['hover']) ? (' btn-' . $atts['hover']) : '';
        $size = !empty($atts['size']) ? (' btn-' . $atts['size']) : '';
        $target = !empty($atts['target']) ? ($atts['target']) : '_blank';
        $color = '';
        if(!empty($atts['color'])) {
            $color = ' style="border-color:' . $atts['color'] . ';';
            $color .= (!empty($atts['style']) && $atts['style'] === 'border' ? ('color:' . $atts['color']) : ('background-color:' . $atts['color'])).'"';
        }
        return '<a href="' . $link . '" target="' . $target . '" class="btn' . $rounded . $style . $size . $hover . '"' . $color . '>' . $content . '<span></span></a>';
    }

}
add_shortcode('tw_button', 'shortcode_tw_button');





/* ================================================================================== */
/*      Label Shortcode
  /* ================================================================================== */

if (!function_exists('shortcode_tw_label')) {

    function shortcode_tw_label($atts, $content) {
        $color = !empty($atts['color']) ? (' style="background:' . $atts['color'] . '"') : '';
        return '<span class="label"' . $color . '>' . $content . '</span>';
    }

}
add_shortcode('tw_label', 'shortcode_tw_label');




/* ================================================================================== */
/*      ColumnShortcode Shortcode
  /* ================================================================================== */

// ColumnShortcode container
if (!function_exists('shortcode_tw_sh_column')) {

    function shortcode_tw_sh_column($atts, $content) {
        $output = '<div class="tw-column-shortcode row-fluid">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_sh_column', 'shortcode_tw_sh_column');
// ColumnShortcode Item
if (!function_exists('shortcode_tw_sh_column_item')) {

    function shortcode_tw_sh_column_item($atts, $content) {
        extract(shortcode_atts(array(
            'column_size'           => '1 / 3',
            'item_animation'        => 'none',
            'item_animation_delay' => '',
        ), $atts));
        if(isMobile()&&!tw_option('moblile_animation')){$atts['item_animation']='none';}
        $class='';
        $animated=false;
        if(isset($atts['item_animation'])&&$atts['item_animation']!=='none'){
            $animated=true;
            $class .= ' tw-animate-gen';
            $atts['item_animation_delay'] = isset($atts['item_animation_delay']) ? str_replace(' ','',$atts['item_animation_delay']) : '';
        }
        $output = '<div class="' . pbTextToFoundation($column_size) . ' '.$class.'"'.($animated?' data-gen="'.$atts['item_animation'].'" data-gen-offset="90%" data-gen-delay="'.$atts['item_animation_delay'].'" style="opacity:0;"':'').'>';
        $output .= do_shortcode($content);
        $output .= '</div>';

        return $output;
    }

}
add_shortcode('tw_sh_column_item', 'shortcode_tw_sh_column_item');



/* ================================================================================== */
/*      Coming Soon Shortcode
/* ================================================================================== */

// Coming Soon
if (!function_exists('shortcode_tw_comingsoon')) {
    function shortcode_tw_comingsoon($atts, $content) {
        wp_enqueue_script('coming-soon',  THEME_DIR . '/assets/js/jquery.comingsoon.js', false, false, true);
        $atts = shortcode_atts(array(
            'coming_title'  => '',
            'coming_years'  => '2018',
            'coming_months' => '12',
            'coming_days'   => '28',
            'coming_hours'  => '12',
            'coming_link'   => '',
        ), $atts);
        $output  = '<div class="tw-cs-container"><h1 class="tw-coming-soon-title">'.$atts['coming_title'].'</h1>';
        $output .= '<div class="tw-coming-soon clearfix" data-years="'.$atts['coming_years'].'" data-months="'.$atts['coming_months'].'" data-days="'.$atts['coming_days'].'" data-hours="'.$atts['coming_hours'].'" data-minutes="00" data-seconds="00">';
            $output .= '<div class="days">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('DAYS','themewaves').'</div>';
            $output .= '</div>';
            $output .= '<div class="sep">:</div>';
            $output .= '<div class="hours">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('HOURS','themewaves').'</div>';
            $output .= '</div>';
            $output .= '<div class="sep">:</div>';
            $output .= '<div class="minutes">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('MINUTES','themewaves').'</div>';
            $output .= '</div>';
            $output .= '<div class="sep">:</div>';
            $output .= '<div class="seconds">';
                $output .= '<div class="count"></div>';
                $output .= '<div class="text">'.__('SECONDS','themewaves').'</div>';
            $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="tw-coming-soon-content">'.do_shortcode($content).'</div>';
        if($atts['coming_link']!=='') {
            $feed = $atts['coming_link'];
            $text = __('Your email here', 'themewaves');
            $submit = __('SUBSCRIBE NOW','themewaves');
            $output .= '<div class="subscribe-container">';
                $output .= '<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(\'http://feedburner.google.com/fb/a/mailverify?uri='.$feed.'\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true">';
                    $output .= '<p>';
                        $output .= '<input type="text" value="" placeholder="'.$text.'"  name="email">';
                        $output .= '<input class="btn" type="submit" name="imageField" value="'.$submit.'" alt="Submit" />';
                        $output .= '<input type="hidden" value="'.$feed.'" name="uri"/>';
                        $output .= '<input type="hidden" name="loc" value="en_US" />';
                    $output .= '</p>';
                $output .= '</form>';
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }
}
add_shortcode('tw_comingsoon', 'shortcode_tw_comingsoon');



/* ================================================================================== */
/*      Before After Shortcode
/* ================================================================================== */

// Before After
if (!function_exists('shortcode_tw_before_after')) {
    function shortcode_tw_before_after($atts, $content) {
        wp_enqueue_script('event-move',  THEME_DIR . '/assets/js/jquery.event.move.js', false, false, true);
        wp_enqueue_script('twentytwenty',  THEME_DIR . '/assets/js/jquery.twentytwenty.js', false, false, true);
        wp_enqueue_style('twentytwenty', THEME_DIR . '/assets/css/twentytwenty.css');
        $atts = shortcode_atts(array(
            'before'  => '',
            'after'  => '',
        ), $atts);
        if(empty($atts['before'])){$atts['before']=THEME_DIR.'/assets/img/no-image.png';}
        if(empty($atts['after'] )){$atts['after'] =THEME_DIR.'/assets/img/no-image.png';}
        $output  = '<div class="tw-before-after">';
            $output .= '<img src="'.$atts['before'].'" title="'.__('Before','themewaves').'" />';
            $output .= '<img src="'.$atts['after'] .'" title="'.__('After','themewaves') .'" />';
        $output .= '</div>';
        
        return $output;
    }
}
add_shortcode('tw_before_after', 'shortcode_tw_before_after');



/* ================================================================================== */
/*      PHP Shortcode
/* ================================================================================== */

// Before After
if (!function_exists('shortcode_tw_php')) {
    function shortcode_tw_php($atts, $content) {
        ob_start();
        eval($content);
        $output = ob_get_clean();
        return $output;
    }
}
add_shortcode('tw_php', 'shortcode_tw_php');






/* ================================================================================== */
/*      All Post Type Shortcode
/* ================================================================================== */
if (!function_exists('shortcode_tw_all_post_type')) {
    function shortcode_tw_all_post_type($atts, $content) {
        extract(shortcode_atts(array(
            'layout_size'             => 'span12',
            'post_type'               => 'post',
            'post_type_slugs'         => 'post',
            'cat_post_slugs'          => '',
            'cat_tw_portfolio_slugs'  => '',
            'cat_tw_price_slugs'      => '',
            'cat_tw_team_slugs'       => '',
            'cat_tw_testimonial_slugs'=> '',
            'cat_tw_partner_slugs'    => '',
            'post_count'              => '10',
            'layout'                  => 'standard',
            'pagination'              => 'true',
            'excerpt_count'           => '50',
            'more_text'               => '',
        ), $atts));
        
        global $paged, $tw_options;
        
        $output = '<div class="tw-blog tw-all-posttype">';
                
        $q_post_type_slugs = empty($atts['post_type_slugs']) ? 'post' : explode(",", $atts['post_type_slugs']);
        $query = Array(
            'post_type' => $q_post_type_slugs,
            'posts_per_page' => $atts['post_count'],
            'paged' => $paged,
            'relation' => 'OR',
        );
        
        $tax_query_array=array();
        if(is_array($q_post_type_slugs)){
            foreach($q_post_type_slugs as $q_post_type_slug){
                $taxonomyNames = get_object_taxonomies($q_post_type_slug);
                $cats = empty($atts['cat_'.$q_post_type_slug.'_slugs']) ? false : explode(",", $atts['cat_'.$q_post_type_slug.'_slugs']);
                if ($cats&&isset($taxonomyNames[0])) {
                    array_push(
                        $tax_query_array,
                        Array(
                            'taxonomy' => $taxonomyNames[0],
                            'terms' => $cats,
                            'field' => 'slug'
                        )
                    );
                }
            }
        }
        $tax_query_array['relation']='OR';
        $query['tax_query'] = $tax_query_array;
        $tw_options['pagination'] = isset($atts['pagination'])?$atts['pagination']:'none';
        $tw_options['excerpt_count'] = $atts['excerpt_count'];
        $tw_options['more_text'] = $atts['more_text'];
		
        $atts['layout'] = !empty($atts['layout']) ? $atts['layout'] : 'standard';
		
        if($atts['layout_size']==='span9'){
			$tw_options['layout'] = 'standard';
            if($atts['layout']!='standard')
                $tw_options['layout']='3';
        }elseif($atts['layout_size']==='span12'){
            switch ($atts['layout']){
                case '2':{ $tw_options['layout']='6';break;}
                case '3':{ $tw_options['layout']='4';break;}
                case '4':{ $tw_options['layout']='3';break;}
                case 'standard':{ $tw_options['layout']='standard';break;}
            }
        }
        
        if($tw_options['pagination']==='infinite'){
            wp_enqueue_script('blog-infinitescroll', THEME_DIR . '/assets/js/blog-infinitescroll.js', false, false, true);
        }
        if($tw_options['layout'] != 'standard'){
            add_action('wp_footer', 'portfolio_script');
        }
		
        query_posts($query);
        ob_start();
        get_template_part("loop");
        $output .= ob_get_clean();
        wp_reset_query();
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_all_post_type', 'shortcode_tw_all_post_type');




/* ================================================================================== */
/*      Map Shortcode
  /* ================================================================================== */
if (!function_exists('shortcode_tw_map')) {

    function shortcode_tw_map($atts, $content) {
        $atts = shortcode_atts(array(
                'type'  => 'boxed'
        ), $atts);
    
        $output = '<div class="tw-map'.($atts['type']==='full'?' tw-full-element':'').'">';
            $output .= $content;
        $output .= '</div>';
        return $output;
    }

}
add_shortcode('tw_map', 'shortcode_tw_map');