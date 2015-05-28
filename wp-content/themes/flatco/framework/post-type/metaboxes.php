<?php
if (!function_exists('settings_checkbox')) {
    function settings_checkbox($settings){
        $default = $settings['value'];
        $datashow = $datahide = $klass = "";
        if (!empty($settings['hide'])) {
            $klass = " check-show-hide";
            $datahide = $settings['hide'];
        }
        if (!empty($settings['show'])) {
            $klass = " check-show-hide";
            $datashow = $settings['show'];
        } ?>
        <tr id="field_<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <input type="hidden" name="<?php echo $settings['id']; ?>" id="<?php echo $settings['id']; ?>" value="0"/>
                <input type="checkbox" class="yesno<?php echo $klass;?>" id="<?php echo $settings['id']; ?>" data-show="<?php echo $datashow;?>" data-hide="<?php echo $datahide;?>" name="<?php echo $settings['id']; ?>" value="1" <?php echo checked($default, 1, false);?> />           
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_textarea')) {
    function settings_textarea($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <textarea rows="5" name="<?php echo $settings['id']; ?>"><?php echo $settings['value']; ?></textarea>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_text')) {
    function settings_text($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <input type="text" name="<?php echo $settings['id']; ?>" id="<?php echo $settings['id']; ?>" value="<?php echo $settings['value']; ?>" />
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_file')) {
    function settings_file($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <input type="text" id="<?php echo $settings['id']; ?>" name="<?php echo $settings['id']; ?>" value="<?php echo $settings['value']; ?>" placeholder="Your Custom BG Image URL" size=""/>
                <a href="#" class="button insert-images theme_button format" onclick="browseimage('<?php echo $settings['id']; ?>')"><?php _e('Insert image', "themewaves"); ?></a>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_selectbox')) {
    function settings_selectbox($settings){
        $settings['options'] = array('true', 'default', 'false'); ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <select class="selectbox" name="<?php echo $settings['id']; ?>" data-value="<?php print $settings['value'];?>"><?php
                    foreach ($settings['options'] as $meta) {
                        echo '<option value="' . $meta . '" ';
                        echo $meta == $settings['value'] ? 'selected ' : '';
                        echo '>' . $meta . '</option>';
                    } ?>
                </select>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_layoutpage')) {
    function settings_layoutpage($settings){}
}
if (!function_exists('settings_layout')) {
    function settings_layout($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <div class="type_layout">
                    <a href="javascript:;" data-value="left" class="left-sidebar"></a>
                    <a href="javascript:;" data-value="right" class="right-sidebar"></a>
                    <a href="javascript:;" data-value="full" class="without-sidebar"></a>
                    <input name="<?php echo $settings['id'];?>" type="hidden" value="<?php echo $settings['value'];?>" />
                </div>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_radio')) {
    function settings_radio($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <td>
                <label for="<?php echo $settings['id']; ?>"><?php echo $settings['name']; ?></label>
                <div class="type_radio"><?php
                    foreach ($settings['options'] as $option) {
                        print '<input type="radio" style="margin-right:5px;" name="' . $settings['name'] . '" value="' . $option . '" ';
                        print $option == $settings['value'] ? 'checked ' : '';
                        print '><span style="margin-right:20px;">' . $option . '</span><br />';
                    } ?>
                </div>
            </td>
            <td>
                <span>
                    <?php echo $settings['desc']; ?>
                </span>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_color')) {
    function settings_color($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>            
            </th>
            <td>
                <div class="color_selector">
                    <div class="color_picker"><div style="background-color: <?php echo $settings['value']; ?>;" class="color_picker_inner"></div></div>
                    <input type="text" class="color_picker_value" id="<?php echo $settings['id']; ?>" name="<?php echo $settings['id']; ?>" value="<?php echo $settings['value']; ?>" />
                </div>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_select')) {
    function settings_select($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <div class="type_select add_item_medium">
                    <select class="medium" name="<?php echo $settings['id']; ?>" data-value="<?php print $settings['value'];?>"><?php
                        foreach($settings['options'] as $key=>$value) { 
                                echo '<option value="'.$key.'">'.$value.'</option>';
                        } ?>
                    </select>
                </div>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_gallery')) {
    function settings_gallery($settings){
        global $post;
        $meta = get_post_meta( $post->ID, 'gallery_image_ids', true );
        $gallery_thumbs = '';
        $button_text = ($meta) ? __('Edit Gallery', 'themewaves') : __('Upload Images', 'themewaves');
        if( $meta ) {
            $thumbs = explode(',', $meta);
            foreach( $thumbs as $thumb ) {
                $gallery_thumbs .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
            }
        } ?>
        <tr id="<?php //echo $settings['id']; ?>">
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <input type="button" class="button" name="<?php echo $settings['id']; ?>" id="gallery_images_upload" value="<?php echo $button_text; ?>" />
                <input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="<?php echo $meta ? $meta : 'false'; ?>" />
                <ul class="gallery-thumbs"><?php echo $gallery_thumbs;?></ul>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_slideshow')) {
    function settings_slideshow($settings){
        global $wpdb;        
        if ( defined('MSWP_AVERTA_VERSION') ) {
            $masters = get_mastersliders();
        }        
        $layer_table = $wpdb->prefix . "layerslider";
        if($wpdb->get_results($wpdb->prepare( "SHOW TABLES LIKE %s", $layer_table ))){
            $layers = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $layer_table
                                            WHERE flag_hidden = %s AND flag_deleted = %s
                                            ORDER BY date_c ASC LIMIT 100", '0', '0' ));
        }
        $revo_table = $wpdb->prefix . "revslider_sliders";
        if($wpdb->get_results($wpdb->prepare( "SHOW TABLES LIKE %s", $revo_table ))){
            $revos = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $revo_table WHERE id <> %s",''));
        }
        ?>
        <tr class="<?php echo esc_attr($settings['id']); ?>">            
            <th>
                <label for="<?php echo esc_attr($settings['id']); ?>">
                    <strong><?php echo esc_html($settings['name']); ?></strong>
                    <span><?php echo esc_html($settings['desc']); ?></span>
                </label>
            </th>
            <td>
                <select class="medium" name="<?php echo esc_attr($settings['id']); ?>" data-value="<?php print balanceTags($settings['value']);?>">
                    <option value="none">None</option><?php
                    if(!empty($masters)) {
                            foreach($masters as $key => $item) {
                                    $name = empty($item['title']) ? ('Unnamed('.$item['ID'].')') : $item['title'];
                                    echo '<option value="[masterslider id=\''.$item['ID'].'\']">'.esc_html($name).' (master)</option>';
                            }
                    }
                    if(!empty($layers)) {
                            foreach($layers as $key => $item) {
                                    $name = empty($item->name) ? ('Unnamed('.$item->id.')') : $item->name;
                                    echo '<option value="[layerslider id=\''.$item->id.'\']">'.esc_html($name).' (layer)</option>';
                            }
                    }
                    if(!empty($revos)) {
                            foreach($revos as $key => $item) {
                                    $name = empty($item->title) ? ('Unnamed('.$item->id.')') : $item->title;
                                    echo '<option value="[rev_slider '.$item->id.']">'.esc_html($name).' (revo)</option>';
                            }
                    } ?>
                </select>
            </td>
        </tr><?php
    }
}
if (!function_exists('settings_menu')) {
    function settings_menu($settings){ ?>
        <tr id="<?php echo $settings['id']; ?>">            
            <th>
                <label for="<?php echo $settings['id']; ?>">
                    <strong><?php echo $settings['name']; ?></strong>
                    <span><?php echo $settings['desc']; ?></span>
                </label>
            </th>
            <td>
                <?php $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
                        if ( !$menus ) {
                                echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
                        } else {
                            echo '<select name="'.$settings['id'].'" data-value="'.$settings['value'].'">';
									echo '<option value="">'. __('Default', 'themewaves') . '</option>';
                            foreach ( $menus as $menu ) {
                                    echo '<option value="' . $menu->term_id . '">'. $menu->name . '</option>';
                            }
                            echo '</select>';
                        } ?>
            </td>
        </tr><?php
    }
}?>