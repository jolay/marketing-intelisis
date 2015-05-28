jQuery(document).ready(function($) {
	product_add_to_cart_click();
        var in_cart = jQuery('.widget_shopping_cart_content');
        if(in_cart.text().length == 0) {
            in_cart.html('<li class="empty">No products in the cart.</li>');
        }
});

function product_add_to_cart_click()
{
	var jbody = jQuery('body');

	jbody.on('click', '.add_to_cart_button', function()
	{
		jQuery(this).parents('.product:eq(0)').addClass('adding-to-cart-loading').removeClass('added-to-cart-check');
	})
	
	jbody.bind('added_to_cart', function()
	{
		jQuery('.adding-to-cart-loading').removeClass('adding-to-cart-loading').addClass('added-to-cart-check');
	});
	
}