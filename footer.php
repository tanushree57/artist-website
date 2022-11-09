<?php
/**
 * The template for displaying the footer.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */

$eventsia_settings = eventsia_get_theme_options(); ?>
		<!-- Footer Start ============================================= -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="footer-bg"  <?php if($eventsia_settings['eventsia_img-upload-footer-image'] !=''){?>style="background-image:url('<?php echo esc_url($eventsia_settings['eventsia_img-upload-footer-image']); ?>');" <?php } ?>>
				<?php do_action('eventsia_footer_columns'); ?>

			<!-- Site Information ============================================= -->
			<div class="site-info">
				<div class="wrap">
					<?php
						if($eventsia_settings['eventsia_buttom_social_icons'] == 0):

							do_action('eventsia_social_links');

						endif;
					?>
					<div class="copyright">
					<?php
					 
					 if ( is_active_sidebar( 'eventsia_footer_options' ) ) :

						dynamic_sidebar( 'eventsia_footer_options' );

					else: ?>

						<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name', 'display' ); ?></a> | 
									<?php esc_html_e('Designed by:','eventsia'); ?> <a title="<?php echo esc_attr__( 'Theme Freesia', 'eventsia' ); ?>" target="_blank" href="<?php echo esc_url( 'https://themefreesia.com' ); ?>"><?php esc_html_e('Theme Freesia','eventsia');?></a> |
									<?php  date_i18n(__('Y','eventsia')) ; ?> <a title="<?php echo esc_attr__( 'WordPress', 'eventsia' );?>" target="_blank" href="<?php echo esc_url( 'https://wordpress.org' );?>"><?php esc_html_e('WordPress','eventsia'); ?></a> | <?php echo '&copy; ' . esc_html__('Copyright All right reserved ','eventsia'); ?>
						<?php
							if ( function_exists( 'the_privacy_policy_link' ) ) { 
								the_privacy_policy_link( ' | ', '<span role="separator" aria-hidden="true"></span>' );
							}
							
							endif; ?>
					</div><!-- end .copyright -->
					<div style="clear:both;"></div>
				</div> <!-- end .wrap -->
			</div> <!-- end .site-info -->
			<?php
				$disable_scroll = $eventsia_settings['eventsia_scroll'];
				if($disable_scroll == 0):?>
					<button class="go-to-top" type="button">
						<span class="icon-bg"></span>
							<i class="fas fa-angle-up back-to-top-text"></i>
					    	<i class="fas fa-angle-double-up back-to-top-icon"></i>
					</button>
			<?php endif; ?>
			<div class="page-overlay"></div>
		</footer> <!-- end #colophon -->
	</div><!-- end .site-content-contain -->
</div><!-- end #page -->
<?php wp_footer(); ?>
</body>
</html>