<?php    
$selectsidebar = array();
$selectsidebar["Default sidebar"] = "Default sidebar";
$sidebars = get_option('sbg_sidebars');
if (!empty($sidebars)) {
    foreach ($sidebars as $sidebar) {
        $selectsidebar[$sidebar] = $sidebar;
    }
}
$header_type = array(
    'subtitle'=>'Title and Subtitle',
    'slider'=>'Slider',
    'image'=>'Featured Image',
    'map'=>'Google Map',
    'none'=>'None');
$years = array('2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018');
$months = array('01'=>__('January','themewaves'),'02'=>__('February','themewaves'),'03'=>__('March','themewaves'),
    '04'=>__('April','themewaves'),'05'=>__('May','themewaves'),'06'=>__('June','themewaves'),
    '07'=>__('July','themewaves'),'08'=>__('August','themewaves'),'09'=>__('Septempber','themewaves'),
    '10'=>__('October','themewaves'),'11'=>__('November','themewaves'),'12'=>__('December','themewaves'));
$days = array(
    '01' => '1','02' => '2','03' => '3','04' => '4','05' => '5',
    '06' => '6','07' => '7','08' => '8','09' => '9','10' => '10',
    '11' => '11','12' => '12','13' => '13','14' => '14','15' => '15',
    '16' => '16','17' => '17','18' => '18','19' => '19','20' => '20',
    '21' => '21','22' => '22','23' => '23','24' => '24','25' => '25',
    '26' => '26','27' => '27','28' => '28','29' => '29','30' => '30','31' => '31',
);
$hours = array(
    '00' => '0','01' => '1','02' => '2','03' => '3','04' => '4',
    '05' => '5','06' => '6','07' => '7','08' => '8','09' => '9',
    '10' => '10','11' => '11','12' => '12','13' => '13','14' => '14',
    '15' => '15','16' => '16','17' => '17','18' => '18','19' => '19',
    '20' => '20','21' => '21','22' => '22','23' => '23'
);
/* * *********************** */
/* Post options */
/* * *********************** */
$tw_post_settings = Array(
    Array(        
        'name' => __('Post Author Show?', 'themewaves'),
        'desc' => __('Default setting will take from theme options.', 'themewaves'),
        'id' => 'post_authorr',
        'std' => 'default',
        'type' => 'selectbox'),
    Array(        
        'name' => __('Featured Media Show?', 'themewaves'),
        'desc' => __('Default setting will take from theme options.', 'themewaves'),
        'id' => 'feature_show',
        'std' => 'default',
        'type' => 'selectbox'),
    Array(        
        'name' => __('Featured Image Height?', 'themewaves'),
        'desc' => __('Image height (px).', 'themewaves'),
        'id' => 'image_height',
        'std' => '350',
        'type' => 'text'),
    Array(        
        'name' => __('Breadcrumbs on this page?', 'themewaves'),
        'desc' => __('Default setting will take from theme options.', 'themewaves'),
        'id' => 'breadcrumps',
        'std' => 'default',
        'type' => 'selectbox'),
    Array(
        'name' => __('Sub Title', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'subtitle',
        'type' => 'text'),
    Array(
        'name' => __('Background image of page title', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'bg_image',
        'type' => 'file'),
    Array(        
        'name' => __('Choose Post Layout?', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'layout',
        'std' => 'right',
        'type' => 'layout'),
    Array(        
        'name' => __('Choose Sidebar ?', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'custom_sidebar',
        'options' => $selectsidebar,
        'std' => 'Default sidebar',
        'type' => 'select')
);


/* * *********************** */
/* Page options */
/* * *********************** */
$tw_page_settings = Array(
    Array(
        'name' => __('Header type ?', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'header_type',
        'std' => 'subtitle',
        'options' => $header_type,
        'type' => 'select'),
    Array(
        'name' => __('Select Slideshow', 'themewaves'),
        'desc' => __('All of your created sliders will be included here.', 'themewaves'),
        'id' => 'slider_id',
        'type' => 'slideshow'),
    Array(
        'name' => __('Sub Title', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'subtitle',
        'type' => 'text'),
    Array(
        'name' => __('Background image of page title', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'bg_image',
        'type' => 'file'),
    Array(
        'name' => __('Google Map', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'googlemap',
        'type' => 'textarea'),
    Array(        
        'name' => __('Breadcrumbs on this post?', 'themewaves'),
        'desc' => __('Default setting will take from theme options.', 'themewaves'),
        'id' => 'breadcrumps',
        'std' => 'default',
        'type' => 'selectbox'),
	Array(
        'name' => __('Menu', 'themewaves'),
        'desc' => __('This will helps you ', 'themewaves'),
        'id'   => 'page_menu',
        'type' => 'menu'
    ),
);
$tw_comingsoon_settings = Array(
    Array(
        'name' => __('Years', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id'   => 'coming_years',
        'std'  => '2014',
        'options' => $years,
        'type' => 'select'
    ),
    Array(
        'name' => __('Months', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id'   => 'coming_months',
        'std'  => '01',
        'options' => $months,
        'type' => 'select'
    ),
    Array(
        'name' => __('Days', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id'   => 'coming_days',
        'std'  => '01',
        'options' => $days,
        'type' => 'select'
    ),
    Array(
        'name' => __('Hours', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id'   => 'coming_hours',
        'std'  => '00',
        'options' => $hours,
        'type' => 'select'
    ),
    Array(
        'name' => __('Your Feedburner Title', 'themewaves'),
        'desc' => __('If empty, Subscribe form none', 'themewaves'),
        'id'   => 'coming_link',
        'std'  => '',
        'type' => 'text'
    ),
);
if(!tw_option("pagebuilder")){
    $tw_page_settings[] = Array(
        'name' => __('Page Layout ?', 'themewaves'),
        'desc' => __('Choose the Layout', 'themewaves'),
        'id'   => 'layout',
        'std'  => 'full',
        'type' => 'layout'
    );
    $tw_page_settings[] = Array(
        'name' => __('Sidebar ?', 'themewaves'),
        'desc' => __('Choose your Sidebar', 'themewaves'),
        'id'   => 'custom_sidebar',
        'options' => $selectsidebar,
        'std'  => 'Default sidebar',
        'type' => 'select'
    );
}


/* * *********************** */
/* Portfolio options */
/* * *********************** */
$tw_portfolio_settings = Array(
    Array(
        'name' => __('Sub Title', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'subtitle',
        'type' => 'text'),
    Array(
        'name' => __('Background image of page title', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'bg_image',
        'type' => 'file'),
    Array(
        'name' => __('Preview url', 'themewaves'),
        'desc' => __('Preview url', 'themewaves'),
        'id' => 'preview_url',
        'type' => 'text'),
    Array(
        'name' => __('Image height', 'themewaves'),
        'desc' => __('Image height on single portfolio', 'themewaves'),
        'id' => 'image_height',
        'type' => 'text'),
);
$tw_portfolio_gallery = array(
        array( "name" => __('Upload images', 'themewaves'),
                        "desc" => __('Select the images that should be upload to this gallery', 'themewaves'),
                        "id" => "gallery_image_ids",
                        "type" => 'gallery'
                ),
        array( "name" => __('Gallery height', 'themewaves'),
                        "desc" => __('Gallery height on single portfolio', 'themewaves'),
                        "id" => "format_image_height",
                        "type" => 'text'
                )
);
$tw_portfolio_video = array(
        array( "name" => __('Embeded Code','themewaves'),
                        "desc" => __('If you\'re not using self hosted video then you can include embeded code here.','themewaves'),
                        "id" => "format_video_embed",
                        "type" => "textarea",
                        'std' => ''
        ),
        array(
            'name' => __('Show light box?', 'themewaves'),
            'desc' => __('It works when featured image is selected.', 'themewaves'),
            'id' => 'pretty_video',
            'options' => array('true'=>'Yes','false'=>'No'),
            'std' => 'false',
            'type' => 'select'
        ),
        array( 
            "name" => __('Pretty Video URL', 'themewaves'),
            "desc" => __('', 'themewaves'),
            "id" => "pretty_video_url",
            "type" => 'text'
        ),
);


/* * *********************** */
/* Testimonial options */
/* * *********************** */
$tw_testimonial_settings = Array(
    Array(
        'name' => __('Name', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'name',
        'type' => 'text'),
    Array(
        'name' => __('Company name', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'company',
        'type' => 'text'),
    Array(
        'name' => __('Link to url', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'url',
        'type' => 'text'),
);


/* * *********************** */
/* Team options */
/* * *********************** */
$tw_team_settings = Array(
    Array(
        'name' => __('Custom url', 'themewaves'),
        'desc' => __('Custom url', 'themewaves'),
        'id' => 'custom_link',
        'type' => 'text'),
    Array(
        'name' => __('Position', 'themewaves'),
        'desc' => __('Member position', 'themewaves'),
        'id' => 'position',
        'type' => 'text'),
    Array(
        'name' => __('Background color', 'themewaves'),
        'desc' => __('Choose color', 'themewaves'),
        'id' => 'bg_color',
        'type' => 'color'),
    Array(
        'name' => __('Facebook url', 'themewaves'),
        'desc' => __('Facebook url', 'themewaves'),
        'id' => 'facebook',
        'type' => 'text'),
    Array(
        'name' => __('Google Plus url', 'themewaves'),
        'desc' => __('Google Plus url', 'themewaves'),
        'id' => 'google',
        'type' => 'text'),
    Array(
        'name' => __('Twitter url', 'themewaves'),
        'desc' => __('Twitter url', 'themewaves'),
        'id' => 'twitter',
        'type' => 'text'),
    Array(
        'name' => __('Linkedin url', 'themewaves'),
        'desc' => __('Linkedin url', 'themewaves'),
        'id' => 'linkedin',
        'type' => 'text'),
    Array(
        'name' => __('Soundcloud url', 'themewaves'),
        'desc' => __('Soundcloud url', 'themewaves'),
        'id' => 'soundcloud',
        'type' => 'text'),
);


/* * *********************** */
/* Partner options */
/* * *********************** */
$tw_partner_settings = Array(
    Array(
        'name' => __('Partner Link to URL', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'link',
        'type' => 'text'),
);


/* * *********************** */
/* Pricing table options */
/* * *********************** */
$tw_price_settings = Array(
    Array(
        'name' => __('Color', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'color',
        'type' => 'color'),
    Array(
        'name' => __('Price', 'themewaves'),
        'desc' => __('Please insert with $ symbol.', 'themewaves'),
        'id' => 'price',
        'type' => 'text'),
    Array(
        'name' => __('Sub Price', 'themewaves'),
        'desc' => __('Please insert value.', 'themewaves'),
        'id' => 'subprice',
        'std' => __(".00", "themewaves"),
        'type' => 'text'),
    Array(
        'name' => __('Price Time', 'themewaves'),
        'desc' => __('Price time option. Example: Month, Day, Year etc.', 'themewaves'),        
        'id' => 'time',
        'std' => __("month", "themewaves"),
        'type' => 'text'),
    Array(
        'name' => __('Button text', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'buttontext',
        'type' => 'text'),
    Array(
        'name' => __('Button URL', 'themewaves'),
        'desc' => __('', 'themewaves'),
        'id' => 'buttonlink',
        'type' => 'text'),
);


add_action('admin_init', 'post_settings_custom_box', 1);
if (!function_exists('post_settings_custom_box')) {
    function post_settings_custom_box() {
        global $tw_post_settings;
        add_meta_box('post_meta_settings',__( 'Post settings', 'themewaves' ),'metabox_render','post','normal','high',$tw_post_settings);
    }
}

add_action('admin_init', 'page_settings_custom_box', 1);
if (!function_exists('page_settings_custom_box')) {
    function page_settings_custom_box() {
        global $tw_page_settings, $tw_comingsoon_settings;
        add_meta_box('page_meta_settings',__( 'Page settings', 'themewaves' ),'metabox_render','page','normal','high',$tw_page_settings);
        add_meta_box('comingsoon_meta_settings',__( 'ComingSoon page settings', 'themewaves' ),'metabox_render','page','normal','high',$tw_comingsoon_settings);
    }
}

add_action('admin_init', 'portfolio_settings_custom_box');
if (!function_exists('portfolio_settings_custom_box')) {
    function portfolio_settings_custom_box() {
        global $tw_portfolio_settings,$tw_portfolio_gallery,$tw_portfolio_video;
        add_meta_box('portfolio_meta_settings',__( 'Portfolio settings', 'themewaves' ),'metabox_render','tw_portfolio','normal','high',$tw_portfolio_settings);
        add_meta_box('portfolio_gallery_settings',__( 'Portfolio gallery settings', 'themewaves' ),'metabox_render','tw_portfolio','normal','high',$tw_portfolio_gallery);
        add_meta_box('portfolio_video_settings',__( 'Portfolio video settings', 'themewaves' ),'metabox_render','tw_portfolio','normal','high',$tw_portfolio_video);
    }
}

add_action('admin_init', 'testimonial_settings_custom_box');
if (!function_exists('testimonial_settings_custom_box')) {
    function testimonial_settings_custom_box() {
        global $tw_testimonial_settings;
        add_meta_box('testimonial_meta_settings',__( 'Testimonial settings', 'themewaves' ),'metabox_render','tw_testimonial','normal','high',$tw_testimonial_settings);
    }
}

add_action('admin_init', 'team_settings_custom_box');
if (!function_exists('team_settings_custom_box')) {
    function team_settings_custom_box() {
        global $tw_team_settings;
        add_meta_box('team_meta_settings',__( 'Team settings', 'themewaves' ),'metabox_render','tw_team','normal','high',$tw_team_settings);
    }
}

add_action('admin_init', 'partner_settings_custom_box');
if (!function_exists('partner_settings_custom_box')) {
    function partner_settings_custom_box() {
        global $tw_partner_settings;
        add_meta_box('partner_meta_settings',__( 'Partner settings', 'themewaves' ),'metabox_render','tw_partner','normal','high',$tw_partner_settings);
    }
}

add_action('admin_init', 'price_settings_custom_box');
if (!function_exists('price_settings_custom_box')) {
    function price_settings_custom_box() {
        global $tw_price_settings;
        add_meta_box('price_meta_settings',__( 'Price settings', 'themewaves' ),'metabox_render','tw_price','normal','high',$tw_price_settings);
    }
} ?>