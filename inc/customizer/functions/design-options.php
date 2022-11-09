<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
$eventsia_settings = eventsia_get_theme_options();

$wp_customize->add_section('eventsia_layout_options', array(
	'title' => __('Layout Options', 'eventsia'),
	'priority' => 102,
	'panel' => 'eventsia_options_panel'
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_header_design]', array(
	'default' => $eventsia_settings['eventsia_header_design'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_header_design]', array(
	'priority' =>30,
	'label' => __('Header Design Layout', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'1' => __('Design 1','eventsia'),
		'2' => __('Design 2','eventsia'),
	),
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_entry_meta_single]', array(
	'default' => $eventsia_settings['eventsia_entry_meta_single'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_entry_meta_single]', array(
	'priority'=>40,
	'label' => __('Disable Entry Meta from Single Page', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type' => 'select',
	'choices' => array(
		'show' => __('Display Entry Format','eventsia'),
		'hide' => __('Hide Entry Format','eventsia'),
	),
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_entry_meta_blog]', array(
	'default' => $eventsia_settings['eventsia_entry_meta_blog'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_entry_meta_blog]', array(
	'priority'=>50,
	'label' => __('Disable Entry Meta from Blog', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type'	=> 'select',
	'choices' => array(
		'show-meta' => __('Display Entry Meta','eventsia'),
		'hide-meta' => __('Hide Entry Meta','eventsia'),
	),
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_post_category]', array(
	'default' => $eventsia_settings['eventsia_post_category'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_post_category]', array(
	'priority'=>60,
	'label' => __('Disable Category', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_post_author]', array(
	'default' => $eventsia_settings['eventsia_post_author'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_post_author]', array(
	'priority'=>70,
	'label' => __('Disable Author', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_post_date]', array(
	'default' => $eventsia_settings['eventsia_post_date'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_post_date]', array(
	'priority'=>80,
	'label' => __('Disable Date', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_post_comments]', array(
	'default' => $eventsia_settings['eventsia_post_comments'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_post_comments]', array(
	'priority'=>90,
	'label' => __('Disable Comments', 'eventsia'),
	'section' => 'eventsia_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_blog_content_layout]', array(
   'default'        => $eventsia_settings['eventsia_blog_content_layout'],
   'sanitize_callback' => 'eventsia_sanitize_select',
   'type'                  => 'option',
   'capability'            => 'manage_options'
));
$wp_customize->add_control('eventsia_theme_options[eventsia_blog_content_layout]', array(
   'priority'  =>100,
   'label'      => __('Blog Content Display', 'eventsia'),
   'section'    => 'eventsia_layout_options',
   'type'       => 'select',
   'checked'   => 'checked',
   'choices'    => array(
       'fullcontent_display' => __('Blog Full Content Display','eventsia'),
       'excerptblog_display' => __(' Excerpt  Display','eventsia'),
   ),
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_design_layout]', array(
	'default'        => $eventsia_settings['eventsia_design_layout'],
	'sanitize_callback' => 'eventsia_sanitize_select',
	'type'                  => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_design_layout]', array(
	'priority'  =>110,
	'label'      => __('Design Layout', 'eventsia'),
	'section'    => 'eventsia_layout_options',
	'type'       => 'select',
	'checked'   => 'checked',
	'choices'    => array(
		'full-width-layout' => __('Full Width Layout','eventsia'),
		'boxed-layout' => __('Boxed Layout','eventsia'),
		'small-boxed-layout' => __('Small Boxed Layout','eventsia'),
	),
));