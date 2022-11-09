<?php
/**
 * The template for displaying navigation.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
$eventsia_settings = eventsia_get_theme_options();
	if ( function_exists('wp_pagenavi' ) ) :

		wp_pagenavi();

	else:

	// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => '<i class="fas fa-angle-double-left"></i><span class="screen-reader-text">' . esc_html__( 'Previous page', 'eventsia' ).'</span>',
			'next_text'          => '<i class="fas fa-angle-double-right"></i><span class="screen-reader-text">' . esc_html__( 'Next page', 'eventsia' ).'</span>',
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'eventsia' ) . ' </span>',
		) );

	endif;