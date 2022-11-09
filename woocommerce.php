<?php
/**
 * This template to displays woocommerce page
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */

get_header();

$eventsia_settings = eventsia_get_theme_options();

if( $post ) {
	$eventsia_layout = get_post_meta( get_queried_object_id(), 'eventsia_sidebarlayout', true );
}
if( empty( $eventsia_layout ) || is_archive() || is_search() || is_home() ) {
	$eventsia_layout = 'default';
} ?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php eventsia_breadcrumb();
			woocommerce_content(); ?>
		</main><!-- end #main -->
	</div> <!-- #primary -->
<?php 

if( 'default' == $eventsia_layout ) { //Settings from customizer
	if((is_active_sidebar('eventsia_woocommerce_sidebar')) && ($eventsia_settings['eventsia_sidebar_layout_options'] != 'fullwidth')){ ?>
<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Secondary', 'eventsia' ); ?>">
	<?php }
} 
	if( 'default' == $eventsia_layout ) { //Settings from customizer
		if((is_active_sidebar('eventsia_woocommerce_sidebar')) && ($eventsia_settings['eventsia_sidebar_layout_options'] != 'fullwidth')): ?>
		<?php dynamic_sidebar( 'eventsia_woocommerce_sidebar' ); ?>
</aside><!-- end #secondary -->
<?php endif;
	} ?>
</div><!-- end .wrap -->

<?php
get_footer();