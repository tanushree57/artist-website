<?php
/**
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
/**************** EVENTSIA REGISTER WIDGETS ***************************************/
add_action('widgets_init', 'eventsia_widgets_init');
function eventsia_widgets_init() {

	register_sidebar(array(
			'name' => __('Main Sidebar', 'eventsia'),
			'id' => 'eventsia_main_sidebar',
			'description' => __('Shows widgets at Main Sidebar.', 'eventsia'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('Top Header Info', 'eventsia'),
			'id' => 'eventsia_header_info',
			'description' => __('Shows widgets on all page.', 'eventsia'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Side Menu', 'eventsia'),
			'id' => 'eventsia_side_menu',
			'description' => __('Shows widgets on all page.', 'eventsia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Slider Section', 'eventsia'),
			'id' => 'eventsia_slider_section',
			'description' => __('Use any Slider Plugins and drag that slider widgets to this Slider Section', 'eventsia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Eventsia FrontPage Template', 'eventsia'),
			'id' => 'eventsia_frontpage_template',
			'description' => __('Shows widgets on Eventsia Template.', 'eventsia'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('Contact Page Sidebar', 'eventsia'),
			'id' => 'eventsia_contact_page_sidebar',
			'description' => __('Shows widgets on Contact Page Template.', 'eventsia'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Iframe Code For Google Maps', 'eventsia'),
			'id' => 'eventsia_form_for_contact_page',
			'description' => __('Add Iframe Code using text widgets', 'eventsia'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('WooCommerce Sidebar', 'eventsia'),
			'id' => 'eventsia_woocommerce_sidebar',
			'description' => __('Add WooCommerce Widgets Only', 'eventsia'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));

	$eventsia_settings = eventsia_get_theme_options();
	for($i =1; $i<= $eventsia_settings['eventsia_footer_column_section']; $i++){
	register_sidebar(array(
			'name' => __('Footer Column ', 'eventsia') . $i,
			'id' => 'eventsia_footer_'.$i,
			'description' => __('Shows widgets at Footer Column ', 'eventsia').$i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	}
	register_widget( 'Eventsia_popular_Widgets' );
}