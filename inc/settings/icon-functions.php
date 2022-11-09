<?php
/**
 *
 */
function eventsia_get_icons( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'icon'    => ''
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	$icon = '<i class="fab fa-' . esc_attr( $args['icon'] ) . '">';	

	$icon .= '</i>';

	return $icon;
}

/**
 * Display icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function eventsia_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = eventsia_social_links_icons();

	// Change icon inside social links menu if there is supported URL.
	if ( 'social-link' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . eventsia_get_icons( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}

add_filter( 'walker_nav_menu_start_el', 'eventsia_nav_menu_social_icons', 10, 4 );

if(!function_exists('eventsia_social_links_icons')) {
	/**
	 * Returns an array of supported social links (URL and icon name).
	 *
	 * @return array $social_links_icons
	 */
	function eventsia_social_links_icons() {
		// Supported social links icons.
		$social_links_icons = array(

			'facebook.com'    	=> 'facebook-f',
			'twitter.com'     	=> 'twitter',
			'pinterest.com'   	=> 'pinterest-p',
			'dribbble.com'    	=> 'dribbble',
			'instagram.com'   	=> 'instagram',
			'linkedin.com'    	=> 'linkedin-in',
			'flickr.com'      	=> 'flickr'
		);

		/**
		 * Filter Eventsia social links icons.
		 *
		 * @since Eventsia 1.0
		 *
		 * @param array $social_links_icons Array of social links icons.
		 */
		return apply_filters( 'eventsia_social_links_icons', $social_links_icons );
	}
}
