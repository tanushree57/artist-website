<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
/********************* EVENTSIA CUSTOMIZER SANITIZE FUNCTIONS *******************************/
function eventsia_checkbox_integer( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function eventsia_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

function eventsia_sanitize_category_select($input) {
	
	$input = sanitize_key( $input );
	return ( ( isset( $input ) && true == $input ) ? $input : '' );

}

function eventsia_reset_alls( $input ) {
	if ( $input == 1 ) {
		delete_option( 'eventsia_theme_options');
		$input=0;
		return absint($input);
	} 
	else {
		return '';
	}
}

function eventsia_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function eventsia_category_callback( $control ) {
    if ( $control->manager->get_setting('eventsia_theme_options[eventsia_upcoming_status]')->value() == 'publish' ) {
      return true;
   } else {
      return false;
   }
}

function eventsia_upcoming_title_callback( $control ) {
    if ( $control->manager->get_setting('eventsia_theme_options[eventsia_upcoming_status]')->value() == 'future' ) {
      return true;
   } else {
      return false;
   }
}

function eventsia_latest_blogtitle_callback( $control ) {
    if ( $control->manager->get_setting('eventsia_theme_options[eventsia_latest_category_blog_section]')->value() == 'category_display' ) {
      return true;
   } else {
      return false;
   }
}

function eventsia_latest_title_callback( $control ) {
    if ( $control->manager->get_setting('eventsia_theme_options[eventsia_latest_category_blog_section]')->value() == 'category_display' ) {
      return false;
   } else {
      return true;
   }
}