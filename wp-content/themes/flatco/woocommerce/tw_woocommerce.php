<?php

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

function woocommerce_enabled() {
    if ( class_exists( 'woocommerce' ) )
        return true;
    return false;
}


/* ====== Remove Actions ====== */

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );




/* ====== Remove Page Title ====== */

add_filter('woocommerce_show_page_title', 'title_none');
function title_none(){
    return false;
}




/* ====== Change Wrapper Begin ====== */

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'tt_woocommerce_output_content_wrapper', 10);

function tt_woocommerce_output_content_wrapper() {
    ob_start();
    dynamic_sidebar("woocommerce-widget");
    $wsidebar = ob_get_clean();
    echo "<div class='row'>";
    if($wsidebar)
        echo "<div class='span9'>";
    else
        echo "<div class='span12'>";
}




/* ====== Change Wrapper End ====== */

remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'tt_woocommerce_output_content_wrapper_end', 10);

function tt_woocommerce_output_content_wrapper_end() {
    echo "</div>";
}




/* ====== Change Pagination ====== */

remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
add_action('woocommerce_pagination', 'pagination', 10);




/* ====== Change Breadcrumbs ====== */

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
add_filter( 'woocommerce_breadcrumb_defaults', 'tw_woocommerce_breadcrumbs' );
function tw_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &#47; ',
            'wrap_before' => '<div class="span6"><div class="tw-breadcrumb pull-right" itemprop="breadcrumb">',
            'wrap_after'  => '</div></div>',
            'before'      => '<span>',
            'after'       => '</span>',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}





/* ====== Change Products Columns ====== */

add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns() {
        ob_start();
        dynamic_sidebar("woocommerce-widget");
        $wsidebar = ob_get_clean();
        if($wsidebar)
            return 3; // 3 products per row
        return 4; // 3 products per row
    }
}




/* ====== Change Thumbnail ====== */

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'tw_woocommerce_thumb', 10);

function tw_woocommerce_thumb()
{
	global $product;
	$rating = $product->get_rating_html();	
	$id = get_the_ID();
	$width = 300;	
	echo "<div class='thumbnail_container'>";
                echo post_image_show( $width );
		echo tw_woocommerce_gallery_first_thumb( $id , $width);		
		if(!empty($rating)) echo "<span class='rating_container'>".$rating."</span>";
		echo "<span class='cart-load'></span>";
	echo "</div>";
}
function tw_woocommerce_gallery_first_thumb($id, $width)
{
    $gallery = get_post_meta( $id, '_product_image_gallery', true );
    if(!empty($gallery))
    {
            $woo_gallery = explode(',',$gallery);
            $image_id = $woo_gallery[0];
            $image = aq_resize(wp_get_attachment_url($image_id), $width, "", true);
            $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $alt = !empty($alt) ? $alt : get_the_title();
            if(!empty($image)) return '<img src="'.$image.'" class="product-hover-thumb" alt="'.$alt.'">';
    }
}




/* ====== Change Add To Cart ====== */

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action( 'woocommerce_after_shop_loop_item', 'tw_add_cart_button', 16);
function tw_add_cart_button() {
	global $product;

	if ($product->product_type == 'bundle' ){
		$product = new WC_Product_Bundle($product->id);
	}

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output = ob_get_clean();

	if($product->product_type == 'variable' && empty($output))
	{
		$output = "<a class='add_to_cart_button product_type_variable button' href='".get_permalink($product->id)."'>".__('Select options','themewaves')."</a>";
	}

	if($product->product_type == 'simple')
	{
		$output .= "<a class='show_details_button button' href='".get_permalink($product->id)."'>".__('Show Details','themewaves')."</a>";
	}	
	
	if($output) echo "<div class='tw_cart_buttons button'>$output</div>";
}