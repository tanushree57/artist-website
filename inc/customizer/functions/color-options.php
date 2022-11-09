<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
/********************* Color Option **********************************************/

	$wp_customize->add_section( 'colors', array(
		'title' 						=> __('Background Color Options','eventsia'),
		'priority'					=> 100,
		'panel'					=>'colors'
	));