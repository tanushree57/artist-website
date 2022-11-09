<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
$eventsia_settings = eventsia_get_theme_options();
/********************** Eventsia WordPreess default Panel ***********************************/
$wp_customize->add_panel('eventsia_frontpage_panel',array(
    'title'=> __('FrontPage Features','eventsia'),
    'priority'=> 10,
));

$wp_customize->add_section('header_image', array(
	'title' => __('Header Media', 'eventsia'),
	'priority' => 20,
	'panel' => 'eventsia_wordpress_default_panel'
));
$wp_customize->add_section('colors', array(
	'title' => __('Colors', 'eventsia'),
	'priority' => 30,
	'panel' => 'eventsia_wordpress_default_panel'
));
$wp_customize->add_section('background_image', array(
	'title' => __('Background Image', 'eventsia'),
	'priority' => 40,
	'panel' => 'eventsia_wordpress_default_panel'
));
$wp_customize->add_section('nav', array(
	'title' => __('Navigation', 'eventsia'),
	'priority' => 50,
	'panel' => 'eventsia_wordpress_default_panel'
));
$wp_customize->add_section('static_front_page', array(
	'title' => __('Static Front Page', 'eventsia'),
	'priority' => 60,
	'panel' => 'eventsia_wordpress_default_panel'
));
$wp_customize->add_section('title_tagline', array(
	'title' => __('Site Title & Logo Options', 'eventsia'),
	'priority' => 10,
	'panel' => 'eventsia_wordpress_default_panel'
));

$wp_customize->add_section('eventsia_custom_header', array(
	'title' => __('Options', 'eventsia'),
	'priority' => 500,
	'panel' => 'eventsia_options_panel'
));

$wp_customize->add_section( 'eventsia_frontpage_about_us', array(
	'title' => __('About Us Section','eventsia'),
	'priority' => 510,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section( 'eventsia_upcoming_features', array(
	'title' => __('Upcoming Event Section','eventsia'),
	'description' => __('Upcoming Event will be displayed when your post is scheduled','eventsia'),
	'priority' => 520,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section( 'eventsia_our_speaker_features', array(
	'title' => __('Our Speaker Section','eventsia'),
	'priority' => 530,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section( 'eventsia_our_gallery_features', array(
	'title' => __('Our Gallery Section','eventsia'),
	'priority' => 540,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section( 'eventsia_lastestfrom_blog_features', array(
	'title' => __('Latest from Blog Section','eventsia'),
	'priority' => 550,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section( 'eventsia_our_testimonial_features', array(
	'title' => __('Our Testimonial Section','eventsia'),
	'priority' => 560,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section( 'eventsia_our_clientbox_features', array(
	'title' => __('Our Client Box Section','eventsia'),
	'priority' => 570,
	'panel' =>'eventsia_frontpage_panel'
));

$wp_customize->add_section('eventsia_footer_image', array(
	'title' => __('Footer Background Image', 'eventsia'),
	'priority' => 600,
	'panel' => 'eventsia_options_panel'
));

/********************  EVENTSIA THEME OPTIONS ******************************************/

$wp_customize->add_setting('eventsia_theme_options[eventsia_header_display]', array(
	'capability' => 'edit_theme_options',
	'default' => $eventsia_settings['eventsia_header_display'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_header_display]', array(
	'label' => __('Site Logo/ Text Options', 'eventsia'),
	'priority' => 105,
	'section' => 'title_tagline',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'header_text' => __('Display Site Title Only','eventsia'),
		'header_logo' => __('Display Site Logo Only','eventsia'),
		'show_both' => __('Show Both','eventsia'),
		'disable_both' => __('Disable Both','eventsia'),
	),
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_search_custom_header]', array(
	'default' => $eventsia_settings['eventsia_search_custom_header'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_search_custom_header]', array(
	'priority'=>20,
	'label' => __('Disable Search Form', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_side_menu]', array(
	'default' => $eventsia_settings['eventsia_side_menu'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_side_menu]', array(
	'priority'=>25,
	'label' => __('Disable Side Menu', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_stick_menu]', array(
	'default' => $eventsia_settings['eventsia_stick_menu'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_stick_menu]', array(
	'priority'=>30,
	'label' => __('Disable Stick Menu', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_scroll]', array(
	'default' => $eventsia_settings['eventsia_scroll'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_scroll]', array(
	'priority'=>40,
	'label' => __('Disable Goto Top', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_top_social_icons]', array(
	'default' => $eventsia_settings['eventsia_top_social_icons'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_top_social_icons]', array(
	'priority'=>50,
	'label' => __('Disable Header Social Icons', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_side_menu_social_icons]', array(
	'default' => $eventsia_settings['eventsia_side_menu_social_icons'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_side_menu_social_icons]', array(
	'priority'=>60,
	'label' => __('Disable Side Menu Social Icons', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_buttom_social_icons]', array(
	'default' => $eventsia_settings['eventsia_buttom_social_icons'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_buttom_social_icons]', array(
	'priority'=>70,
	'label' => __('Disable Bottom Social Icons', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_display_page_single_featured_image]', array(
	'default' => $eventsia_settings['eventsia_display_page_single_featured_image'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_display_page_single_featured_image]', array(
	'priority'=>100,
	'label' => __('Disable Page/Single Featured Image', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_main_menu]', array(
	'default' => $eventsia_settings['eventsia_disable_main_menu'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_main_menu]', array(
	'priority'=>120,
	'label' => __('Disable Main Menu', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_reset_all]', array(
	'default' => $eventsia_settings['eventsia_reset_all'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'eventsia_reset_alls',
	'transport' => 'postMessage',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_reset_all]', array(
	'priority'=>150,
	'label' => __('Reset all default settings. (Refresh it to view the effect)', 'eventsia'),
	'section' => 'eventsia_custom_header',
	'type' => 'checkbox',
));

/********************** Footer Background Image ***********************************/
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_img-upload-footer-image]',array(
	'default'	=> $eventsia_settings['eventsia_img-upload-footer-image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eventsia_theme_options[eventsia_img-upload-footer-image]', array(
	'label' => __('Footer Background Image','eventsia'),
	'description' => __('Image will be displayed on footer','eventsia'),
	'priority'	=> 50,
	'section' => 'eventsia_footer_image',
	)
));

/********************** Header Image ***********************************/

$wp_customize->add_setting('eventsia_theme_options[eventsia_enable_header_image]', array(
	'capability' => 'edit_theme_options',
	'default' => $eventsia_settings['eventsia_enable_header_image'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_enable_header_image]', array(
	'label' => __('Display Header Image/ Slider Sidebar Widget Section', 'eventsia'),
	'priority' => 40,
	'section' => 'header_image',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'frontpage' => __('Front Page','eventsia'),
		'enitresite' => __('Entire Site','eventsia'),
		'off' => __('Disable','eventsia'),
	),
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_header_image_title]', array(
	'default'           => $eventsia_settings['eventsia_header_image_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_header_image_title]', array(
	'label' => __('Title','eventsia'),
	'section' => 'header_image',
	'type'     => 'text',
	'priority'	=> 50,
	)
);

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_header_sub_title]', array(
	'default'           => $eventsia_settings['eventsia_header_sub_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_header_sub_title]', array(
	'label' => __('Sub Title','eventsia'),
	'section' => 'header_image',
	'type'     => 'text',
	'priority'	=> 60,
	)
);

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_header_image_button]', array(
	'default'           => $eventsia_settings['eventsia_header_image_button'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_header_image_button]', array(
	'label' => __('Button Text','eventsia'),
	'section' => 'header_image',
	'type'     => 'text',
	'priority'	=> 70,
	)
);

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_header_image_link]', array(
	'default'           => $eventsia_settings['eventsia_header_image_link'],
	'sanitize_callback' => 'esc_url_raw',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_header_image_link]', array(
	'label' => __('Link','eventsia'),
	'section' => 'header_image',
	'type'     => 'text',
	'priority'	=> 80,
	)
);

$wp_customize->add_setting('eventsia_theme_options[eventsia_header_image_with_bg_color]', array(
	'capability' => 'edit_theme_options',
	'default' => $eventsia_settings['eventsia_header_image_with_bg_color'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_header_image_with_bg_color]', array(
	'label' => __('Header image With background color', 'eventsia'),
	'priority' => 100,
	'section' => 'header_image',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'default' => __('Off','eventsia'),
		'with-bg-color' => __('On','eventsia'),
	),
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_header_image_content_bg_color]', array(
	'capability' => 'edit_theme_options',
	'default' => $eventsia_settings['eventsia_header_image_content_bg_color'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_header_image_content_bg_color]', array(
	'label' => __('Header image Content With background color', 'eventsia'),
	'priority' => 110,
	'section' => 'header_image',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'default' => __('Off','eventsia'),
		'bg-content-color' => __('On','eventsia'),
	),
));