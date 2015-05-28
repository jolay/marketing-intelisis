<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		$of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
		//Testing 
		$of_layout_select 	= array("fullwidth" => "Fullwidth","boxed" => "Boxed Layout");
                $of_options_bg_repeat   = array("stretch" => "Strech Image","repeat" => "repeat","no-repeat" => "no-repeat","repeat-y" => "repeat-y","repeat-x" => "repeat-x");
                $of_options_bg_size   = array("auto" => "Auto","cover" => "Cover","contain" => "Contain");
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
                $border_width   	= array("1px" => "1px","2px" => "2px","3px" => "3px","4px" => "4px","5px" => "5px");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options,$tw_googlefonts;
$of_options = array();

/*      ThemeWaves custom admin section started     */
//      General TAB
$of_options[] = array( 	"name" 		=> "General",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "General",
						"desc" 		=> "",
						"id" 		=> "general_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">General Options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Page builder ?",
						"desc" 		=> "This will enable, disable PageBuilder.",
						"id" 		=> "pagebuilder",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Preloader ?",
						"desc" 		=> "This will enable, disable Preloader.",
						"id" 		=> "preloader",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Nice Scroll ?",
						"desc" 		=> "This will enable, disable NiceScroll.",
						"id" 		=> "nicescroll",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Theme Layout",
						"desc" 		=> "",
						"id" 		=> "layout_theme_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Theme Layout</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Theme Layout Style",
						"desc" 		=> "Choose the Theme layout style.",
						"id" 		=> "theme_layout",
						"std" 		=> "Fullwidth",
						"type" 		=> "select",
						"options" 	=> $of_layout_select
				);
$of_options[] = array( 	"name" 		=> "Layout Options if boxed",
						"desc" 		=> "",
						"id" 		=> "layout_opt_boxed_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">If boxed Theme Layout Style chosen.</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Background Color",
						"desc" 		=> "Choose the background color.",
						"id" 		=> "background_color",
						"std" 		=> "#d1d1d1",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Background Image",
						"desc" 		=> "This option will only works under boxed layout chosen.",
						"id" 		=> "background_image",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Background Image Repeat",
						"desc" 		=> "Choose the repeat or stretch image option.",
						"id" 		=> "background_repeat",
						"std" 		=> "repeat",
						"type" 		=> "select",
						"options" 	=> $of_options_bg_repeat
				);
$of_options[] = array( 	"name" 		=> "Margin from Top",
						"desc" 		=> "Boxed Layout margin top.",
						"id" 		=> "margin_top",
						"std" 		=> "60",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Margin from Bottom",
						"desc" 		=> "Boxed Layout margin bottom.",
						"id" 		=> "margin_bottom",
						"std" 		=> "60",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Tracking",
						"desc" 		=> "",
						"id" 		=> "track_code_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Tracking</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Tracking Code",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
						"id" 		=> "tracking_code",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
//      Header and Footer TAB
$of_options[] = array( 	"name" 		=> "Additional",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "Enable animations on mobile?",
						"desc" 		=> "If it's On then it will be enabled on mobile, Off will be disabled on mobile.",
						"id" 		=> "moblile_animation",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Breadcrumps?",
						"desc" 		=> "This will enable or disable Breadcrumps.",
						"id" 		=> "breadcrumps",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Page Title Background Image",
						"desc" 		=> "Inserted picture must be above 1600px width and height is atleast 120px. You can redefine or choose other option to your specific page on meta options.",
						"id" 		=> "title_bg_image",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Portfolio additional heading",
						"desc" 		=> "",
						"id" 		=> "port_add_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Portfolios</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Portfolio post type slug",
						"desc" 		=> "Portfolio post type slug.",
						"id" 		=> "translate_portfolio",
						"std" 		=> "portfolio",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Portfolio Page",
						"desc" 		=> "",
						"id" 		=> "port_page",
						"std" 		=> "",
						"type" 		=> "select",
						"options"       => $of_pages
				);
$of_options[] = array( 	"name" 		=> "Hide portfolio favorites on single?",
						"desc" 		=> "",
						"id" 		=> "hide_favorites",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Portfolio image height",
						"desc" 		=> "Related portfolios height and Default portfolio image height.",
						"id" 		=> "port_height",
						"std" 		=> "250",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Hide related portfolios on single?",
						"desc" 		=> "",
						"id" 		=> "port_related",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Blog Additional heading",
						"desc" 		=> "",
						"id" 		=> "blog_rel_por_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Related Portfolio Single Link</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Disable Hover Feature on single?",
						"desc" 		=> "",
						"id" 		=> "port_related_hide_hover",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "'View Large' text Change",
						"desc" 		=> "Empty: VIEW LARGE.",
						"id" 		=> "port_related_button_text",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Link Open Type?",
						"desc" 		=> "Preview Url is located in Portfolio Single.",
						"id" 		=> "port_related_link_type",
						"std" 		=> "view_large",
						"type" 		=> "select",
						"options" 	=> array('view_large'=>'View large','permalink'=>'Permalink','preview_url'=>'Preview URL')
				);
$of_options[] = array( 	"name" 		=> "Blog Additional heading",
						"desc" 		=> "",
						"id" 		=> "blog_add_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Blog</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Meta on Blog Post Single?",
						"desc" 		=> "If it's On then it will be showed, Off will be hidden.",
						"id" 		=> "meta_on_single",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Featured Media section on post single?",
						"desc" 		=> "If it's On then it will be showed, Off will be hidden.",
						"id" 		=> "feature_show",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Post Author section on post single?",
						"desc" 		=> "If it's On then it will be showed, Off will be hidden.",
						"id" 		=> "post_author",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Blog Page Title",
						"desc" 		=> "Insert Title of your Blog page.",
						"id" 		=> "blog_title",
						"std" 		=> "Blog",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Blog Page Subtitle",
						"desc" 		=> "Insert Sub Title of your Blog page.",
						"id" 		=> "blog_subtitle",
						"std" 		=> "",
						"type" 		=> "text"
				);


//      Header and Footer TAB
$of_options[] = array( 	"name" 		=> "Header and Footer",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "Is Menu fixed position?",
						"desc" 		=> "IF it's ON menu will fixed. Off will disable.",
						"id" 		=> "menu_fixed",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Show Logo background color",
						"desc" 		=> "IF it's ON logo background color will be showed.",
						"id" 		=> "logo_bg",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Logo option heading",
						"desc" 		=> "",
						"id" 		=> "logo_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Logo options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Upload Standard Logo",
						"desc" 		=> "Please insert your logo.",
						"id" 		=> "theme_logo",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);				
$of_options[] = array( 	"name" 		=> "Logo Margin from Top",
						"desc" 		=> "Note: You need to insert only value.",
						"id" 		=> "logo_top",
						"std" 		=> "0",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Logo Margin from Bottom",
						"desc" 		=> "Note: You need to insert only value.",
						"id" 		=> "logo_bottom",
						"std" 		=> "0",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Retina Logo",
						"desc" 		=> "",
						"id" 		=> "logo_retina",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Upload Retina Logo (2x)",
						"desc" 		=> "Note: You retina logo must be larger than 2x. Example: Main logo 120x200 then Retina must be 240x400.",
						"id" 		=> "theme_logo_retina",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "logo_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Standard Logo Width",
						"desc" 		=> "You need to insert Non retina logo width. Height auto",
						"id" 		=> "logo_width",
						"std" 		=> "",
						"fold" 		=> "logo_retina", /* the checkbox hook */
						"type" 		=> "text"
				);				
$of_options[] = array( 	"name" 		=> "Favicon option heading",
						"desc" 		=> "",
						"id" 		=> "favicon_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Favicon options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Upload Standard Favicon",
						"desc" 		=> "Please insert your favicon 16x16 icon. You may use <a href='http://www.favicon.cc/' target='_blank'>favicon.cc</a>",
						"id" 		=> "theme_favicon",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Favicon",
						"desc" 		=> "",
						"id" 		=> "favicon_retina",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Favicon for iPhone (57x57)",
						"desc" 		=> "Please upload your favicon 57x57.",
						"id" 		=> "favicon_iphone",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Favicon for iPhone (114x114)",
						"desc" 		=> "Please upload your favicon 114x114.",
						"id" 		=> "favicon_iphone_retina",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Favicon for iPad (72x72)",
						"desc" 		=> "Please upload your favicon 72x72.",
						"id" 		=> "favicon_ipad",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Favicon for iPad (144x144)",
						"desc" 		=> "Please upload your favicon 144x144.",
						"id" 		=> "favicon_ipad_retina",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);

$of_options[] = array( 	"name" 		=> "Top Bar",
						"desc" 		=> "",
						"id" 		=> "topbar_colors_main",
						"std" 		=> "<h3 style=\"margin: 3px;\">Top Bar</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Top bar",
						"desc" 		=> "Insert your social icons in Social Icons Tab.",
						"id" 		=> "top_bar",
						"std" 		=> 0,
                                                "folds" 	=> 1,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Footer section",
						"desc" 		=> "",
						"id" 		=> "footer_section_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Footer section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Footer Widget",
						"desc" 		=> "",
						"id" 		=> "footer_widget",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
                                );
$url =  ADMIN_DIR . 'assets/images/footer/';
$of_options[] = array( 	"name" 		=> "Footer Layout",
						"desc" 		=> "Choose footer layout.",
						"id" 		=> "footer_layout",
						"std" 		=> "3-3-3-3",
						"type" 		=> "images",
                                                "fold" 		=> "footer_widget", /* the checkbox hook */
						"options" 	=> array(
											'12' 	  => $url . '1.png',
											'6-6' 	  => $url . '2.png',
											'4-4-4'   => $url . '3.png',
											'3-3-3-3' => $url . '4.png'
										)
				);
$of_options[] = array( 	"name" 		=> "Footer text",
						"desc" 		=> "",
						"id" 		=> "footer_text",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
                                );
$of_options[] = array( 	"name" 		=> "Copyright Text",
						"desc" 		=> "Insert Copyright Text.",
						"id" 		=> "copyright_text",
                                                "fold" 		=> "footer_text",
						"std" 		=> "<a href='http://themeforest.net/user/themewaves/portfolio' title='Wordpress is the Best!'>Flacto</a> - Responsive & Multipurpose WP Theme by ThemeWaves. Proudly Powered by <a href='http://wordpress.org/' title='Wordpress is the Best!'>Wordpress </a>",
						"type" 		=> "textarea"
				);
//      Colors and Styling TAB
$of_options[] = array( 	"name" 		=> "Colors and Styling",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "General",
						"desc" 		=> "",
						"id" 		=> "colors_and_styling_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">General</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Primary Color",
						"desc" 		=> "Theme Primary color has all of accent colors of this theme. Default: #2dcb73",
						"id" 		=> "primary_color",
						"std" 		=> "#2dcb73",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Link Color",
						"desc" 		=> "Pick a tag color (default: #2dcb73).",
						"id" 		=> "link_color",
						"std" 		=> "#2dcb73",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Link Hover Color",
						"desc" 		=> "Pick a tag's hover color (default: #2dcb73).",
						"id" 		=> "link_hover_color",
						"std" 		=> "#2dcb73",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Header Colors",
						"desc" 		=> "",
						"id" 		=> "header_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Header</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Header Background Color",
						"desc" 		=> "Pick a background color for the header (default: #fff).",
						"id" 		=> "header_background",
						"std" 		=> "#fff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Top Bar Color",
						"desc" 		=> "",
						"id" 		=> "topbar_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Top Bar Color</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Top bar Background Color",
						"desc" 		=> "Insert your top bar background color.",
						"id" 		=> "top_bar_bg",
						"std" 		=> "#fff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Menu Colors Options",
						"desc" 		=> "",
						"id" 		=> "menu_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Menu</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Menu Background Color",
						"desc" 		=> "Default: transparent",
						"id" 		=> "menu_background",
						"std" 		=> "transparent",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Menu Link Hover&Active Color",
						"desc" 		=> "Default: #2DCB73",
						"id" 		=> "menu_hover",
						"std" 		=> "#2DCB73",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Menu Link Hover&Active Background Color",
						"desc" 		=> "Default: transparent",
						"id" 		=> "menu_hover_background",
						"std" 		=> "transparent",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sub Menu Background Color",
						"desc" 		=> "Default: #2f2f2f",
						"id" 		=> "submenu_bg",
						"std" 		=> "#2f2f2f",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sub Menu Link Color",
						"desc" 		=> "Default: #aaa",
						"id" 		=> "submenu_link",
						"std" 		=> "#aaa",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sub Menu Hover Background Color",
						"desc" 		=> "Default: #2f2f2f",
						"id" 		=> "submenu_hover_background",
						"std" 		=> "#2f2f2f",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sub Menu Link Hover Color",
						"desc" 		=> "Default: #fff",
						"id" 		=> "submenu_hover",
						"std" 		=> "#fff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Body Colors",
						"desc" 		=> "",
						"id" 		=> "body_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Body</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Body Background Color",
						"desc" 		=> "Pick a background color for the body (default: #fff).",
						"id" 		=> "body_background",
						"std" 		=> "#fff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Footer Colors",
						"desc" 		=> "",
						"id" 		=> "footer_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Footer</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Footer Background Color",
						"desc" 		=> "Pick a background color for the footer (default: #2a303c).",
						"id" 		=> "footer_background",
						"std" 		=> "#2a303c",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Footer Text Color",
						"desc" 		=> "Pick a footers text color (default: #fff).",
						"id" 		=> "footer_text_color",
						"std" 		=> "#fff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Footer Link Color",
						"desc" 		=> "Pick a footers a tag color (default: #aaaaaa).",
						"id" 		=> "footer_link_color",
						"std" 		=> "#aaaaaa",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Footer Link Hover Color",
						"desc" 		=> "Pick a footers a tag hover color (default: #2dcb73).",
						"id" 		=> "footer_link_hover_color",
						"std" 		=> "#2dcb73",
						"type" 		=> "color"
				);
//      Typography TAB
$of_options[] = array( 	"name" 		=> "Typography",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "Body",
						"desc" 		=> "",
						"id" 		=> "body_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Body</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Body text font",
						"desc" 		=> "Specify the body font properties",
						"id" 		=> "body_text_font",
						"std" 		=> array('size' => '13px','face' => 'Open Sans','style' => 'normal','color' => '#aaa'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Widget",
						"desc" 		=> "",
						"id" 		=> "menu_link_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Menu</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Menu Link customize",
						"desc" 		=> "Specify the body font properties",
						"id" 		=> "menu_font",
						"std" 		=> array('size' => '13px','face' => 'Montserrat','style' => 'bold','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Widget",
						"desc" 		=> "",
						"id" 		=> "widget_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Widget</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Widgets Title",
						"desc" 		=> "Specify the sidebar headline font properties",
						"id" 		=> "sidebar_widgets_title",
						"std" 		=> array('size' => '16px','face' => 'Montserrat','style' => 'normal','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Footer Widgets Title",
						"desc" 		=> "Specify the sidebar headline font properties",
						"id" 		=> "footer_widgets_title",
						"std" 		=> array('size' => '18px','face' => 'Montserrat','style' => 'bold','color' => '#fff'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Headers font styling",
						"desc" 		=> "",
						"id" 		=> "header_font_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Headlines</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Heading Font Family",
						"desc" 		=> "",
						"id" 		=> "heading_font",
						"std" 		=> "Montserrat",
						"type" 		=> "select_google_font",
						"options" 	=> $tw_googlefonts
				);
$of_options[] = array( 	"name" 		=> "H1 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h1_spec_font",
						"std" 		=> array('size' => '28px','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H2 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h2_spec_font",
						"std" 		=> array('size' => '22px','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H3 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h3_spec_font",
						"std" 		=> array('size' => '18px','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H4 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h4_spec_font",
						"std" 		=> array('size' => '16px','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H5 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h5_spec_font",
						"std" 		=> array('size' => '14px','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H6 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h6_spec_font",
						"std" 		=> array('size' => '12px','color' => '#2f2f2f'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Google Font Subset",
						"desc" 		=> "",
						"id" 		=> "google_font_subset",
						"std" 		=> "<h3 style=\"margin: 3px;\">Google Font Subset</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Google Font Subset",
						"desc" 		=> "Some of Google fonts have additional subsets. Please insert those subsets seperated with comma (,). More information <a href='https://developers.google.com/fonts/docs/getting_started' target='_blank'>Google Font Subset</a>",
						"id" 		=> "google_font_subset",
						"std" 		=> "",
						"type" 		=> "text"
				);
//      Social Icons TAB
$of_options[] = array( 	"name" 		=> "Social Icons",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "Social Icons heading",
						"desc" 		=> "",
						"id" 		=> "social_icons_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Inserted Social Icons will be displayed on top Header section.</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Facebook ID",
						"desc" 		=> "Enter the Facebook ID.",
						"id" 		=> "facebook_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Tumblr Username",
						"desc" 		=> "Enter the Tumblr Username.",
						"id" 		=> "tumblr_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Flickr Username",
						"desc" 		=> "Enter the Flickr Username.",
						"id" 		=> "flickr_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Google + ID",
						"desc" 		=> "Enter the Google + Username.",
						"id" 		=> "googleplus_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Twitter Username",
						"desc" 		=> "Enter the Twitter Username.",
						"id" 		=> "twitter_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Instagram Username",
						"desc" 		=> "Enter the Instagram Username.",
						"id" 		=> "instagram_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "RSS URL",
						"desc" 		=> "Enter the RSS URL.",
						"id" 		=> "rss_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Pinterest Username",
						"desc" 		=> "Enter the Pinterest Username.",
						"id" 		=> "pinterest_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Skype Username",
						"desc" 		=> "Enter the Skype Username.",
						"id" 		=> "skype_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Vimeo Username",
						"desc" 		=> "Enter the Vimeo Username.",
						"id" 		=> "vimeo_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Youtube URL",
						"desc" 		=> "Enter the Youtube URL.",
						"id" 		=> "youtube_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Dribbble Username",
						"desc" 		=> "Enter the Dribbble Username.",
						"id" 		=> "dribbble_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Linkedin URL",
						"desc" 		=> "Enter the Linkedin URL.",
						"id" 		=> "linkedin_username",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "SoundCloud URL",
						"desc" 		=> "Enter the SoundCloud URL.",
						"id" 		=> "soundcloud_username",
						"std" 		=> "",
						"type" 		=> "text"
				);

//      FB Twitter TAB

$of_options[] = array( 	"name" 		=> "FB Twitter API",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Social Share on Posts",
						"desc" 		=> "",
						"id" 		=> "social_share_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Social Share on Posts</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> "Social Share on Posts?",
						"desc" 		=> "",
						"id" 		=> "social_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Social Share on Portfolios?",
						"desc" 		=> "",
						"id" 		=> "portfolio_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Facebook Like",
						"desc" 		=> "",
						"id" 		=> "facebook_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Twitter",
						"desc" 		=> "",
						"id" 		=> "twitter_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "GooglePlus",
						"desc" 		=> "",
						"id" 		=> "googleplus_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Pinterest",
						"desc" 		=> "",
						"id" 		=> "pinterest_share",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "LinkedIn",
						"desc" 		=> "",
						"id" 		=> "linkedin_share",
						"std" 		=> 0,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Facebook & Twitter",
						"desc" 		=> "",
						"id" 		=> "facebook_twitter_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Facebook Comment API section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Facebook comment?",
						"desc" 		=> "On will be enabling facebook comment, Off will be Wordpress default comment.",
						"id" 		=> "facebook_comment",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Facebook api key",
						"desc" 		=> "Create your own Facebook Application and <a href='https://developers.facebook.com/apps' target='_blank'>get ID</a>.",
						"id" 		=> "facebook_app_id",
						"std" 		=> "",
                                                "fold" 		=> "facebook_comment", /* the checkbox hook */
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Facebook & Twitter",
						"desc" 		=> "",
						"id" 		=> "facebook_twitter_info2",
						"std" 		=> "<h3 style=\"margin: 3px;\">Twitter API section (Note this will Required!)</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Consumer key",
                                                "desc" 		=> "You need to Create your Twitter APP and <a href='https://dev.twitter.com/apps' target='_blank'>insert the ID</a>.",
                                                "id" 		=> "consumerkey",
                                                "std" 		=> "",
                                                "type" 		=> "text");
$of_options[] = array( 	"name" 		=> "Consumer secret",
                                                "desc" 		=> "",
                                                "id" 		=> "consumersecret",
                                                "std" 		=> "",
                                                "type" 		=> "text");
$of_options[] = array( 	"name" 		=> "Access token",
                                                "desc" 		=> "",
                                                "id" 		=> "accesstoken",
                                                "std" 		=> "",
                                                "type" 		=> "text");
$of_options[] = array( 	"name" 		=> "Access token secret",
                                                "desc" 		=> "",
                                                "id" 		=> "accesstokensecret",
                                                "std" 		=> "",
                                                "type" 		=> "text");

//      Translate option TAB
$of_options[] = array( 	"name" 		=> "Translate",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "Translate text",
						"desc" 		=> "",
						"id" 		=> "translate_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">All of our theme additional translation text translate able here.</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Continue Reading",
						"desc" 		=> "Continue Reading text on category page.",
						"id" 		=> "translate_readmore",
						"std" 		=> "Continue Reading",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Project Description",
						"desc" 		=> "Project Description text on portfolio single page.",
						"id" 		=> "translate_projectdesc",
						"std" 		=> "Project Description",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Live Preview",
						"desc" 		=> "Live Preview text on portfolio single page.",
						"id" 		=> "translate_livepreview",
						"std" 		=> "Live Preview",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Related Portfolio",
						"desc" 		=> "Related Portfolio text on portfolio single page.",
						"id" 		=> "translate_relatedportfolio",
						"std" 		=> "Related Portfolio",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Show All",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "portfolio_show_all",
						"std" 		=> "Show All",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Posts",
						"desc" 		=> "",
						"id" 		=> "translate_post",
						"std" 		=> "<h3 style=\"margin: 3px;\">Posts</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Posted on",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pp_date",
						"std" 		=> "Posted on",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "By",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pp_author",
						"std" 		=> "By",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "In",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pp_cateogry",
						"std" 		=> "In",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Twitter section",
						"desc" 		=> "",
						"id" 		=> "translate_post",
						"std" 		=> "<h3 style=\"margin: 3px;\">Twitter and Twitter Carousel</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Follow Us",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_follow",
						"std" 		=> "Follow Us",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Right now",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_rn",
						"std" 		=> "right now",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> " Seconds ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_sa",
						"std" 		=> " seconds ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "About 1 minute ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_aoma",
						"std" 		=> "about 1 minute ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> " Minutes ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_ma",
						"std" 		=> " minutes ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "About 1 hour ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_aoha",
						"std" 		=> "about 1 hour ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> " Hours ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_ha",
						"std" 		=> " hours ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Yesterday",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_yes",
						"std" 		=> "yesterday",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> " Days ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_da",
						"std" 		=> " days ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> " Over a year ago",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "tw_car_oaya",
						"std" 		=> "over a year ago",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Page Title section",
						"desc" 		=> "",
						"id" 		=> "translate_page_title",
						"std" 		=> "<h3 style=\"margin: 3px;\">Page Title section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Category",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_category",
						"std" 		=> "Category",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Portfolio",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_portfolio",
						"std" 		=> "Portfolio",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Tag",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_tag",
						"std" 		=> "Tag",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Nothing Found",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_nothing_found",
						"std" 		=> "Nothing Found",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Author",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_author",
						"std" 		=> "Author",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Daily Archives",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_daily_arch",
						"std" 		=> "Daily Archives",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Monthly Archives",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_monthly_arch",
						"std" 		=> "Monthly Archives",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Yearly Archives",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_yearly_arch",
						"std" 		=> "Yearly Archives",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Blog Archives",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_blog_arch",
						"std" 		=> "Blog Archives",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Search results for",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "pt_search_result",
						"std" 		=> "Search results for",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Breadcrump text",
						"desc" 		=> "",
						"id" 		=> "translate_breadcrump",
						"std" 		=> "<h3 style=\"margin: 3px;\">Breadcrump section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Home",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "br_home",
						"std" 		=> "Home",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Archive by Category",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "br_category",
						"std" 		=> "Archive by Category",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Search Results for",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "br_search",
						"std" 		=> "Search Results for",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Posts Tagged",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "br_tag",
						"std" 		=> "Posts Tagged",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Articles Posted by",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "br_author",
						"std" 		=> "Articles Posted by",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Error 404",
						"desc" 		=> "Change it to your custom translate.",
						"id" 		=> "br_404",
						"std" 		=> "Error 404",
						"type" 		=> "text"
				);


//      Custom CSS TAB
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "",
						"id" 		=> "custom_css_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Enter the Custom CSS of your custom Modify.</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Paste your own customized CSS code.",
						"id" 		=> "custom_css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

//     Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
