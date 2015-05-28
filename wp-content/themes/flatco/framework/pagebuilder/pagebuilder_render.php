<?php
if (!function_exists('rowStart')) {
    function rowStart($colCounter,$size){
        if($colCounter===0||$colCounter===12||$colCounter+$size>12 ){return array($size,'true');}
        return array($colCounter+$size,'false');
    }
}
if (!function_exists('pbGetContentBuilderItem')) {
    function pbGetContentBuilderItem($item_array) {
        global $tw_pbItems,$tw_layoutSize;
        ob_start();
        $itemSlug = $item_array['slug'];
        $itemSettingsArray = $item_array['settings'];
        $defaultItem=$tw_pbItems[$itemSlug];
        $defaultItemSettingsArray=$defaultItem['settings'];
        $itemClass = !empty($item_array['item_custom_class']) ? $item_array['item_custom_class'] : '';
        if($item_array['size']!=='shortcode-size'){
            echo '[tw_item size="'.  pbTextToFoundation($item_array['size']).'" class="'.str_replace('"','&quot;',rawUrlDecode($itemClass)).'" layout_size="'.pbTextToFoundation($tw_layoutSize).'" row_type="'.(isset($item_array['row-type'])?$item_array['row-type']:'row-fluid').'" item_animation="'.(isset($item_array['item_animation'])?str_replace('"','&quot;',rawUrlDecode($item_array['item_animation'])):'none').'" item_animation_offset="90%" item_animation_delay="'.(isset($item_array['item_animation_delay'])?str_replace('"','&quot;',rawUrlDecode($item_array['item_animation_delay'])):'').'"]';
        }
            if(!empty($item_array['item_title'])){
                echo'[tw_item_title title="'.$item_array['item_title'].'"]';
            }
            $content_slug=  empty($defaultItem['content'])?'':$defaultItem['content'];
            echo '[tw_'.$itemSlug;
                if($itemSlug==='portfolio' || $itemSlug==='blog' || $itemSlug==='all_post_type'){echo ' layout_size="'.pbTextToFoundation($tw_layoutSize).'"';}
                foreach($defaultItemSettingsArray as $settings_slug=>$default_settings_array){
                    if($content_slug!==$settings_slug&&$default_settings_array['type']!='category'&&$default_settings_array['type']!='button'&&$default_settings_array['type']!='fa'&&$default_settings_array['type']!='cc'){
                        $settings_val=isset($itemSettingsArray[$settings_slug])?$itemSettingsArray[$settings_slug]:(isset($default_settings_array['default'])?$default_settings_array['default']:'');
                        echo ' '.$settings_slug.'="'.str_replace('"','&quot;',rawUrlDecode($settings_val)).'"';
                    }
                }
            echo ']';
            if($content_slug){
                $settings_val='';
                if($defaultItemSettingsArray[$content_slug]['type']==='container'&&isset($defaultItemSettingsArray[$content_slug]['default'][0])){
                    $defaultContainarItem=$defaultItemSettingsArray[$content_slug]['default'][0];
                    $containarItemArray =$itemSettingsArray[$content_slug];
                    foreach($containarItemArray as $index=>$containarItem){
                        $containarItemContent='';
                        $settings_val .= '[tw_'.$itemSlug.'_item';
                        foreach($containarItem as $slug=>$value){
                            if($defaultContainarItem[$slug]['type']!='category'&&$defaultContainarItem[$slug]['type']!='button'&&$defaultContainarItem[$slug]['type']!='fa'&&$default_settings_array['type']!='cc'){
                                if($defaultContainarItem[$slug]['type']==='textArea'){
                                    $containarItemContent=rawUrlDecode($value);
                                }else{
                                    $settings_val .= ' '.$slug.'="'.str_replace('"','&quot;',rawUrlDecode($value)).'"';
                                }
                            }
                        }
                        $settings_val .= ']';
                        if(!empty($containarItemContent)){
                            $settings_val .= $containarItemContent.'[/tw_'.$itemSlug.'_item]';
                        }
                    }
                }else{
                    $settings_val=isset($itemSettingsArray[$content_slug])?$itemSettingsArray[$content_slug]:$defaultItemSettingsArray[$content_slug]['default'];
                    $settings_val=rawUrlDecode($settings_val);
                }
                echo $settings_val.'[/tw_'.$itemSlug.']';
            }
        if($item_array['size']!=='shortcode-size'){ echo '[/tw_item]';}
        $output = ob_get_clean();
        return $output;
    }
}
if (!function_exists('pbGetContentBuilder')) {
    function pbGetContentBuilder() {
        global $post, $tw_startPrinted,$tw_pbItems;
        $endPrint=false;
        ob_start();
        $_pb_row_array=json_decode(rawUrlDecode(get_post_meta($post->ID, '_pb_content', true)),true);
        if(empty($_pb_row_array)){
            return false;
        }else{
            $layoutsEcho='';
            $prllx = false;
            foreach($_pb_row_array as $_pb_row){
                $rowContrast = isset($_pb_row['row_contrast'])?(' '.$_pb_row['row_contrast']):'';
                $rowParallax = (!isMobile() && isset($_pb_row['background_prllx']))?($_pb_row['background_prllx']=='true' ? (' bg-parallax'):''):'';
                $rowCustomClass = !empty($_pb_row['row_custom_class'])?($_pb_row['row_custom_class']):'';
                $bgAttachment = !empty($rowParallax) ? 'fixed' : (isset($_pb_row['background_attachment'])?$_pb_row['background_attachment']:'scroll');
                if(!$prllx){ $prllx = !empty($rowParallax) ? true : false; }
                $class = $rowContrast.$rowParallax.' '.$rowCustomClass;
                $_pb_row['background_color']=isset($_pb_row['background_color'])?str_replace(' ','',$_pb_row['background_color']):'';
                $style='background-attachment:'.$bgAttachment.';';
                $style.=empty($_pb_row['background_color'])?'':('background-color:'.$_pb_row['background_color'].';');
                $style.=empty($_pb_row['background_image'])?'':('background-image:url('.$_pb_row['background_image'].');');
                $style.=empty($_pb_row['background_repeat'])?'':('background-repeat:'.$_pb_row['background_repeat'].';');
                $style.=empty($_pb_row['background_position'])?'':('background-position:'.$_pb_row['background_position'].';');
                //$layoutsEcho .= '<div'.(!empty($rowCustomClass)?(' id="'.$rowCustomClass.'"'):'').' class="row-container'.$class.'" style="'.$style.'"><div class="container"><div class="row">';
                
                
                
                
                $padding_top = $padding_bottom = '';
                if(isset($_pb_row['padding_top']) && $_pb_row['padding_top'] != '') {
                    $padding_top = intval($_pb_row['padding_top']) <= 60 ? ('<div style="margin-top:-'.(60-$_pb_row['padding_top']).'px"></div>') : ('<div style="padding-top:'.($_pb_row['padding_top']-60).'px"></div>');
                }
                if(isset($_pb_row['padding_bottom']) && $_pb_row['padding_bottom'] != '') {
                    $padding_bottom = intval($_pb_row['padding_bottom']) <= 60 ? ('<div style="margin-bottom:-'.(60-$_pb_row['padding_bottom']).'px"></div>') : ('<div style="padding-bottom:'.($_pb_row['padding_top']-60).'px"></div>');
                }                
                
                
                if(!empty($_pb_row['background_video'])){
                    add_action('wp_footer', 'jplayer_script');
                    $style .= 'overflow: hidden;position:relative;';
                    $layoutsEcho .= '<div'.(!empty($rowCustomClass)?(' id="'.$rowCustomClass.'"'):'').' class="row-container'.$class.'" style="'.$style.'">';
                    $layoutsEcho .= '<div class="video-mask"></div><div class="video-mask-color"></div><div class="background-video"><div id="jquery_jplayer_'.$post->ID.'" class="jp-jplayer jp-jplayer-bgvideo" data-pid="'.$post->ID.'" data-m4v="'.$_pb_row['background_video'].'" data-thumb="'.$_pb_row['background_image'].'"></div></div>';
                    $layoutsEcho .= '<div class="container" style="position:relative; z-index:4"><div class="row">'.$padding_top;
                } else {
                    $layoutsEcho .= '<div'.(!empty($rowCustomClass)?(' id="'.$rowCustomClass.'"'):'').' class="row-container'.$class.'" style="'.$style.'"><div class="container"><div class="row">'.$padding_top;
                }
                
                foreach($_pb_row['layouts'] as $_pb_layout){
                    if($_pb_layout['size']!=='size-0-0'){
                        global $tw_layoutSize;
                        $tw_layoutSize = $_pb_layout['size'];
                        $layoutsEcho .= '[tw_layout size="'.pbTextToFoundation($_pb_layout['size']).'" layout_custom_class="'.(isset($_pb_layout['layout_custom_class'])?$_pb_layout['layout_custom_class']:'').'"]';
                            $tw_startPrinted=false;    
                            $colCounter=0;
                            $start='true';
                            foreach ($_pb_layout['items'] as $item_array){
                                list($colCounter,$start)=rowStart($colCounter,pbTextToFoundation($_pb_layout['size'])==='span3'?12:pbTextToInt($item_array['size']));
                                $endPrint=true;
                                $rowClass = $item_array['row-type'] = !empty($tw_pbItems[$item_array['slug']]['row-type'])?$tw_pbItems[$item_array['slug']]['row-type']:'row-fluid';
                                if($start === "true") {
                                    if($tw_startPrinted){$layoutsEcho .= '</div>';}
                                    $tw_startPrinted=true;
                                    $layoutsEcho .= '<div class="'.$rowClass.'">';
                                }
                                $layoutsEcho .= pbGetContentBuilderItem($item_array);
                            }
                            if($tw_startPrinted){$layoutsEcho.='</div>';}
                        $layoutsEcho .= '[/tw_layout]';
                    }
                }
                
                $layoutsEcho .= '</div>'.$padding_bottom.'</div></div>';
            }
            if($prllx) {
                add_action('wp_footer', 'tw_parallax_script');
            }
            if($endPrint){
                echo $layoutsEcho;
            }else{
                return false;
            }
        }
        $output = ob_get_clean();
        return $output;
    }
}
function tw_parallax_script() {
    wp_enqueue_script('parallax', THEME_DIR . '/assets/js/jquery.parallax-1.1.3.js', false, false, true);
} ?>