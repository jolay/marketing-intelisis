<?php
if (!function_exists('add_tw_tinymce_plugin')){
    function add_tw_tinymce_plugin($plugin_array) {
       $plugin_array['twshortcodegenerator'] = get_template_directory_uri().'/framework/shortcode/js/shortcode.js';
       return $plugin_array;
    }
}
if (!function_exists('register_tw_button')){
    function register_tw_button($buttons) {
       array_push($buttons, "|", "twshortcodegenerator");
       return $buttons;
    }
}
if (!function_exists('add_tw_button')){
    function add_tw_button() {
       if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
         return;
       if ( get_user_option('rich_editing') == 'true') {
         add_filter('mce_external_plugins', 'add_tw_tinymce_plugin');
         add_filter('mce_buttons', 'register_tw_button');
       }
    }
}
add_action('init', 'add_tw_button');

if (!function_exists('my_refresh_mce')){
    function my_refresh_mce($ver) {
      $ver += 3;
      return $ver;
    }
}
add_filter( 'tiny_mce_version', 'my_refresh_mce');
require_once (THEME_PATH . "/framework/shortcode/shortcode_render.php");
//====== START - Functions ======
if (!function_exists('init_admin_shortcode_html')){
    function init_admin_shortcode_html(){
        global $tw_pbItems; ?>
        <div id="tw-shortcode-template" style="display: none;">
            <div class="general-field-container">
                <div class="field-item clearfix type-select">
                    <div class="field-title">Select Shortcode</div>
                    <div class="field-data">
                        <select id="style_shortcode" data-type="select" class="field">
                            <option value="none"><?php _e('Select Shortcode','themewaves'); ?></option><?php
                            if(!empty($tw_pbItems)){
                                foreach ($tw_pbItems as $pbItemSlug => $pbItemArray) {
                                    if(empty($pbItemArray['only']) || $pbItemArray['only']==='shortcode'){
                                        echo '<option value="' . $pbItemSlug . '" >' . $pbItemArray['name'] . '</option>';
                                    }
                                }
                            } ?>
                        </select>
                        <span class="select-text"></span>
                    </div>
                    <div class="field-desc">Select Shortcode</div>
                </div>
            </div>
            <div class="custom-field-container"></div>
        </div><?php
    }
}
add_action( 'admin_head', 'init_admin_shortcode_html', 1 );

if (!function_exists('getModalShortcode')) {
    function getModalShortcode() {
        if (!empty($_REQUEST['shortcode_name'])) {            
            die(pbGetItem($_REQUEST['shortcode_name']));
        }
    }
} add_action('wp_ajax_get_modal_shortcode', 'getModalShortcode');

if (!function_exists('getPrintShortcode')) {
    function getPrintShortcode() {
        if (!empty($_REQUEST['get_print_shortcode'])) {            
            die(pbGetItem($_REQUEST['get_print_shortcode']));
        }
        die('<div class="error">Empty Reqeist</div>');
    }
} add_action('wp_ajax_get_print_shortcode', 'getPrintShortcode');

if (!function_exists('getPrintedItem')) {
    function getPrintedItem(){
        if (!empty($_REQUEST['data'])) {
            $item_array = json_decode(rawUrlDecode(str_replace("\'","'",$_REQUEST['data'])), true);
            die(pbGetContentBuilderItem($item_array));
        }
        die('<div class="error">Empty Reqeist</div>');
    }
} add_action('wp_ajax_get_printed_item', 'getPrintedItem');