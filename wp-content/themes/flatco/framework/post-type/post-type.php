<?php
add_action('admin_print_scripts', 'postsettings_admin_scripts');
add_action('admin_print_styles', 'postsettings_admin_styles');
if (!function_exists('postsettings_admin_scripts')) {
    function postsettings_admin_scripts(){
        global $post,$pagenow;

        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            if( isset($post) ) {
                wp_localize_script( 'jquery', 'script_data', array(
                    'post_id' => $post->ID,
                    'nonce' => wp_create_nonce( 'themewaves-ajax' ),
                    'image_ids' => get_post_meta( $post->ID, 'gallery_image_ids', true ),
                    'label_create' => __("Create Featured Gallery", "waves"),
                    'label_edit' => __("Edit Featured Gallery", "waves"),
                    'label_save' => __("Save Featured Gallery", "waves"),
                    'label_saving' => __("Saving...", "waves")
                ));
            }

            wp_register_script('post-colorpicker', THEME_DIR.'/framework/assets/js/colorpicker.js');       
            wp_register_script('post-metaboxes', THEME_DIR.'/framework/assets/js/metaboxes.js');        

            wp_enqueue_script('post-colorpicker');
            wp_enqueue_script('post-metaboxes');
        }
    }
}

if (!function_exists('postsettings_admin_styles')) {
    function postsettings_admin_styles(){
        global $pagenow;
        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            wp_register_style('post-colorpicker', THEME_DIR.'/framework/assets/css/colorpicker.css', false, '1.00', 'screen');
            wp_register_style('post-metaboxes', THEME_DIR.'/framework/assets/css/metaboxes.css', false, '1.00', 'screen');

            wp_enqueue_style('post-colorpicker');
            wp_enqueue_style('post-metaboxes');
        }
    }
}

add_action("manage_posts_custom_column", "posttype_custom_columns");
if (!function_exists('posttype_custom_columns')) {
    function posttype_custom_columns($column) {
        global $post;
        switch ($column) {
            case "thumbnail":
                echo post_image_show() ? post_image_show(45,45) : ("<img src='".THEME_DIR."/resources/images/no-thumb.png'>");
                break;
            case "portfolio":
                echo get_the_term_list($post->ID, 'cat_portfolio', '', ', ', '');
                break;
            case "price":
                echo get_the_term_list($post->ID, 'cat_price', '', ', ', '');
                break;
            case "team":
                echo get_the_term_list($post->ID, 'cat_team', '', ', ', '');
                break;
            case "testimonial":
                echo get_the_term_list($post->ID, 'cat_testimonial', '', ', ', '');
                break;
        }
    }
}

/* * *********************** */
/* Custom post type: Portfolio */
/* * *********************** */

add_action('init', 'portfolio_register');
function portfolio_register() {
    $slug = tw_option('translate_portfolio') ? tw_option('translate_portfolio') : 'portfolio';
    $labels = array(
        'name' => $slug,
        'singular_name' => $slug,
        'add_new' => __('Add New', 'themewaves'),
        'add_new_item' => __('Add New Portfolio', 'themewaves'),
        'edit_item' => __('Edit Portfolio', 'themewaves'),
        'new_item' => __('New Portfolio', 'themewaves'),
        'all_items' => __('All Portfolios', 'themewaves'),
        'view_item' => __('View Portfolio', 'themewaves'),
        'search_items' => __('Search Portfolios', 'themewaves'),
        'not_found' =>  __('No Portfolio found', 'themewaves'),
        'not_found_in_trash' => __('No Portfolio found in Trash', 'themewaves'),
        'menu_name' => __('Portfolios', 'themewaves')
    );    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'hierarchical' => false,

        'menu_icon' => THEME_DIR . '/framework/assets/images/portfolio.png',
        'rewrite' => array( 'slug' => $slug),
        'supports' => array('title', 'editor','page-attributes','thumbnail','revisions','comments','custom-fields')
    );
    register_post_type('tw_portfolio', $args);
    flush_rewrite_rules();
}
$slug = tw_option('translate_portfolio') ? tw_option('translate_portfolio') : 'portfolio';
register_taxonomy("cat_portfolio", array("tw_portfolio"), array("hierarchical" => true, "label" => __("Categories", "themewaves"), "singular_label" => __("Portfolio Category", "themewaves"), 'rewrite' => array( 'slug' => $slug.'_cat')));

add_filter('manage_edit-tw_portfolio_columns', 'portfolio_edit_columns');
function portfolio_edit_columns($columns){	
    $newcolumns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __("Portfolio Title", "themewaves"),
        "portfolio" => __("Categories", "themewaves"),
    );
    $columns= array_merge($newcolumns, $columns);
    return $columns;
}

/* * *********************** */
/* Custom post type: Pricing Table */
/* * *********************** */

add_action('init', 'price_register');
function price_register() {
    $labels = array(
        'name' => __('Pricing Tables', 'themewaves'),
        'singular_name' => __('Price Item', 'themewaves'),
        'add_new' => __('Add New', 'themewaves'),
        'add_new_item' => __('Add New Item', 'themewaves'),
        'edit_item' => __('Edit Item', 'themewaves'),
        'new_item' => __('New Item', 'themewaves'),
        'all_items' => __('All Tables', 'themewaves'),
        'view_item' => __('View Price Item', 'themewaves'),
        'search_items' => __('Search Pricing Tables', 'themewaves'),
        'not_found' =>  __('No Tables found', 'themewaves'),
        'not_found_in_trash' => __('No Tables in Trash', 'themewaves'),
        'menu_name' => __('Pricing Tables', 'themewaves')
    );    
    $args = array(
        'labels' => $labels,

        'public' => false,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'hierarchical' => false,

        'menu_icon' => THEME_DIR . '/framework/assets/images/portfolio.png',
        'rewrite' => array( 'slug' => 'price'),
        'supports' => array('title', 'editor','page-attributes','revisions', 'custom-fields')
    );
    register_post_type('tw_price', $args);
    flush_rewrite_rules();
}
register_taxonomy("cat_price", array("tw_price"), array("hierarchical" => true, "label" => __("Categories", "themewaves"), "singular_label" => __("Price Category","themewaves"), "rewrite" => true));

add_filter('manage_edit-tw_price_columns', 'price_edit_columns');
function price_edit_columns($columns){	
    $newcolumns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __("Table name", "themewaves"),
        "price" => __("Categories", "themewaves"),
    );
    $columns= array_merge($newcolumns, $columns);
    return $columns;
}

/* * *********************** */
/* Custom post type: Team */
/* * *********************** */

add_action('init', 'team_register');
function team_register() {    
    $labels = array(
        'name' => __('Member', 'themewaves'),
        'singular_name' => __('Member', 'themewaves'),
        'add_new' => __('Add New', 'themewaves'),
        'add_new_item' => __('Add New Member', 'themewaves'),
        'edit_item' => __('Edit Member', 'themewaves'),
        'new_item' => __('New Member', 'themewaves'),
        'all_items' => __('All Members', 'themewaves'),
        'view_item' => __('View Member', 'themewaves'),
        'search_items' => __('Search Member', 'themewaves'),
        'not_found' =>  __('No member found', 'themewaves'),
        'not_found_in_trash' => __('No member found in Trash', 'themewaves'),
        'menu_name' => __('Team', 'themewaves')
    );    
    $args = array(
        'labels' => $labels,
        
        'public' => false,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'hierarchical' => false,
        
        'menu_icon' => THEME_DIR . '/framework/assets/images/portfolio.png',
        'rewrite' => array( 'slug' => 'team'),
        'supports' => array('title','editor', 'page-attributes', 'thumbnail', 'revisions', 'custom-fields')
    );
    register_post_type('tw_team', $args);
    flush_rewrite_rules();
}
register_taxonomy("cat_team", array("tw_team"), array("hierarchical" => true, "label" => __("Categories", "themewaves"), "singular_label" => __("Team Category", "themewaves"), "rewrite" => true));

add_filter('manage_edit-tw_team_columns', 'team_edit_columns');
function team_edit_columns($columns){	
        $newcolumns = array(
            "cb" => "<input type=\"checkbox\" />",
            "thumbnail" => __("Image", "themewaves"),
            "title" => __("Name", "themewaves"),
            "team" => __("Categories", "themewaves"),
        );
        $columns= array_merge($newcolumns, $columns);
        return $columns;
}

/* * *********************** */
/* Custom post type: Testimonial */
/* * *********************** */

add_action('init', 'testimonial_register');
function testimonial_register() {    
    $labels = array(
        'name' => __('Testimonial', 'themewaves'),
        'singular_name' => __('Testimonial', 'themewaves'),
        'add_new' => __('Add New', 'themewaves'),
        'add_new_item' => __('Add New Testimonial', 'themewaves'),
        'edit_item' => __('Edit Testimonial', 'themewaves'),
        'new_item' => __('New Testimonial', 'themewaves'),
        'all_items' => __('All Testimonials', 'themewaves'),
        'view_item' => __('View Testimonial', 'themewaves'),
        'search_items' => __('Search Testimonials', 'themewaves'),
        'not_found' =>  __('No testimonial found', 'themewaves'),
        'not_found_in_trash' => __('No testimonial found in Trash', 'themewaves'),
        'menu_name' => __('Testimonials', 'themewaves')
    );    
    $args = array(
        'labels' => $labels,
        
        'public' => false,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'hierarchical' => false,
        
        'menu_icon' => THEME_DIR . '/framework/assets/images/portfolio.png',
        'rewrite' => array( 'slug' => 'testimonial'),
        'supports' => array('title', 'editor', 'page-attributes', 'thumbnail', 'revisions', 'custom-fields')
    );
    register_post_type('tw_testimonial', $args);
    flush_rewrite_rules();
}
register_taxonomy("cat_testimonial", array("tw_testimonial"), array("hierarchical" => true, "label" => __("Categories", "themewaves"), "singular_label" => __("Testimonial Category", "themewaves"), "rewrite" => true));

add_filter('manage_edit-tw_testimonial_columns', 'testimonial_edit_columns');
function testimonial_edit_columns($columns){	
        $newcolumns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __("Name", "themewaves"),
            "testimonial" => __("Categories", "themewaves"),
        );
        $columns= array_merge($newcolumns, $columns);
        return $columns;
}


/* * *********************** */
/* Custom post type: Partner */
/* * *********************** */

add_action('init', 'partner_register');
function partner_register() {    
    $labels = array(
        'name' => __('Our Partners', 'themewaves'),
        'singular_name' => __('Partner', 'themewaves'),
        'add_new' => __('Add New', 'themewaves'),
        'add_new_item' => __('Add New Partner', 'themewaves'),
        'edit_item' => __('Edit Item', 'themewaves'),
        'new_item' => __('New Item', 'themewaves'),
        'all_items' => __('All Partners', 'themewaves'),
        'view_item' => __('View Partner', 'themewaves'),
        'search_items' => __('Search Partners', 'themewaves'),
        'not_found' =>  __('No Partner found', 'themewaves'),
        'not_found_in_trash' => __('No partner in Trash', 'themewaves'),
        'menu_name' => __('Partners', 'themewaves')
    );    
    $args = array(
        'labels' => $labels,
        
        'public' => false,
        'has_archive' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'hierarchical' => false,
        
        'menu_icon' => THEME_DIR . '/framework/assets/images/portfolio.png',
        'rewrite' => array( 'slug' => 'partner'),
        'supports' => array('title', 'page-attributes', 'thumbnail', 'revisions', 'custom-fields')
    );
    register_post_type('tw_partner', $args);
    flush_rewrite_rules();
}
register_taxonomy("cat_partner", array("tw_partner"), array("hierarchical" => true, "label" => __("Categories", "themewaves"), "singular_label" => __("Partner Category", "themewaves"), "rewrite" => true));

add_filter('manage_edit-tw_partner_columns', 'partner_edit_columns');
function partner_edit_columns($columns){	
        $newcolumns = array(
            "cb" => "<input type=\"checkbox\" />",
            "thumbnail" => __("Image", "themewaves"),
            "title" => __("Partners", "themewaves"),
            "partner" => __("Categories", "themewaves"),
        );
        $columns= array_merge($newcolumns, $columns);
        return $columns;
}

require_once ( THEME_PATH . '/framework/post-type/metaboxes.php');
require_once ( THEME_PATH . '/framework/post-type/post-options.php');   

function metabox_render($post, $metabox) {
    global $post; 
    $options = get_post_meta($post->ID, 'themewaves_'.strtolower(THEMENAME).'_options', true);?>
        <input type="hidden" name="themewaves_meta_box_nonce" value="<?php echo wp_create_nonce(basename(__FILE__));?>" />
        <table class="form-table tw-metaboxes">
            <tbody>
                    <?php	                              
                    foreach ($metabox['args'] as $settings) {
                        $settings['value'] = isset($options[$settings['id']]) ? $options[$settings['id']] : (isset($settings['std']) ? $settings['std'] : '');
                        call_user_func('settings_'.$settings['type'], $settings);	
                    }
                    ?>
            </tbody>
        </table>
<?php 
}

add_action('save_post', 'savePostMeta');
function savePostMeta($post_id) {
    global $tw_post_settings, $tw_page_settings, $tw_comingsoon_settings, $tw_portfolio_settings, $tw_portfolio_gallery, $tw_portfolio_video, $tw_price_settings, $tw_testimonial_settings, $tw_team_settings, $tw_partner_settings;

    $meta = 'themewaves_'.strtolower(THEMENAME).'_options';
    
    // verify nonce
    if (!isset($_POST['themewaves_meta_box_nonce']) || !wp_verify_nonce($_POST['themewaves_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
    }
    
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                    return $post_id;
            }
    } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
    
    if($_POST['post_type']=='post')
        $metaboxes = $tw_post_settings;
    elseif($_POST['post_type']=='page')
        $metaboxes = array_merge($tw_page_settings,$tw_comingsoon_settings);
    elseif($_POST['post_type']=='tw_portfolio') {
        $metaboxes = array_merge($tw_portfolio_settings,$tw_portfolio_gallery,$tw_portfolio_video);
        if(!get_post_meta($post_id, 'post_likeit', true))
            update_post_meta($post_id, 'post_likeit', 0);
    }
    elseif($_POST['post_type']=='tw_team')
        $metaboxes = $tw_team_settings;
    elseif($_POST['post_type']=='tw_testimonial')
        $metaboxes = $tw_testimonial_settings; 
    elseif($_POST['post_type']=='tw_price')
        $metaboxes = $tw_price_settings; 
    elseif($_POST['post_type']=='tw_partner')
        $metaboxes = $tw_partner_settings; 
    
    if(!empty($metaboxes)) {
        $myMeta = array();

        foreach ($metaboxes as $metabox) {
            $myMeta[$metabox['id']] = isset($_POST[$metabox['id']]) ? $_POST[$metabox['id']] : "";
        }

        update_post_meta($post_id, $meta, $myMeta);        

    }
}

/* ================================================================================== */
/*      Save gallery images
/* ================================================================================== */

function themewaves_save_images() {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'themewaves-ajax' ) )
		return;
	
	if ( !current_user_can( 'edit_posts' ) ) return;
 
	$ids = strip_tags(rtrim($_POST['ids'], ','));
	update_post_meta($_POST['post_id'], 'gallery_image_ids', $ids);

	// update thumbs
	$thumbs = explode(',', $ids);
	$gallery_thumbs = '';
	foreach( $thumbs as $thumb ) {
		$gallery_thumbs .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
	}

	echo $gallery_thumbs;

	die();
}
add_action('wp_ajax_themewaves_save_images', 'themewaves_save_images');
?>