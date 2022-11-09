<?php
/**
 * The sidebar containing the main Sidebar area.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
$eventsia_settings = eventsia_get_theme_options();

if( $post ) {

	$eventsia_layout = get_post_meta( get_queried_object_id(), 'eventsia_sidebarlayout', true );

}

if( empty( $eventsia_layout ) || is_archive() || is_search() || is_home() ) {

	$eventsia_layout = 'default';

}

if( 'default' == $eventsia_layout ) { //Settings from customizer

	if((is_active_sidebar('eventsia_main_sidebar')) && ($eventsia_settings['eventsia_sidebar_layout_options'] != 'fullwidth')){ ?>

		<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Secondary', 'eventsia' ); ?>">
<?php }

}else{ // for page/ post
		if((is_active_sidebar('eventsia_main_sidebar')) && ($eventsia_layout != 'full-width')){ ?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Secondary', 'eventsia' ); ?>">

  <?php }
	}?>
  <?php 
	if( 'default' == $eventsia_layout ) { //Settings from customizer

		if((is_active_sidebar('eventsia_main_sidebar')) && ($eventsia_settings['eventsia_sidebar_layout_options'] != 'fullwidth')): ?>

  <?php dynamic_sidebar( 'eventsia_main_sidebar' ); ?>

</aside><!-- end #secondary -->
<?php endif;
	}else{ // for page/post

		if((is_active_sidebar('eventsia_main_sidebar')) && ($eventsia_layout != 'full-width')){

			dynamic_sidebar( 'eventsia_main_sidebar' );
			
			echo '</aside><!-- end #secondary -->';
		}
	}