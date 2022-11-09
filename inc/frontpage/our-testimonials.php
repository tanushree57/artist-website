<?php
/**
 * Our Testimonials
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
add_action('eventsia_display_our_testimonials','eventsia_our_testimonials');
function eventsia_our_testimonials(){
	$eventsia_settings = eventsia_get_theme_options();
	if($eventsia_settings['eventsia_disable_our_testimonial'] != 1){
		$eventsia_our_testimonials_total_page_no = 0;
		$eventsia_our_testimonials_list_page	= array();
		for( $i = 1; $i <= $eventsia_settings['eventsia_total_our_testimonial']; $i++ ){
			if( isset ( $eventsia_settings['eventsia_our_testimonial_features_' . $i] ) && $eventsia_settings['eventsia_our_testimonial_features_' . $i] > 0 ){
				$eventsia_our_testimonials_total_page_no++;

				$eventsia_our_testimonials_list_page	=	array_merge( $eventsia_our_testimonials_list_page, array( $eventsia_settings['eventsia_our_testimonial_features_' . $i] ) );
			}
		}
		
		if (( !empty( $eventsia_our_testimonials_list_page ) || !empty($eventsia_settings['eventsia_our_testimonial_title']) )  && $eventsia_our_testimonials_total_page_no > 0 ) {
			echo '<!-- Testimonial Box ============================================= -->'; ?>
				<div class="testimonial-box">
					<div class="testimonial-bg" <?php if ($eventsia_settings['eventsia_our_testimonial_bg_image']): ?> style="background-image:url('<?php echo esc_url($eventsia_settings['eventsia_our_testimonial_bg_image']); ?>');"<?php endif; ?>>
								<?php	$eventsia_our_testimonials_get_featured_posts 		= new WP_Query(array(
									'posts_per_page'      	=> absint($eventsia_settings['eventsia_total_our_testimonial']),
									'post_type'           	=> array('page'),
									'post__in'            	=> array_values($eventsia_our_testimonials_list_page),
									'orderby'             	=> 'post__in',
								));
								?>
						<div class="wrap">
							<?php if($eventsia_settings['eventsia_our_testimonial_title'] != ''){ ?>
								<div class="box-header">
									<h2 class="box-title"><?php echo esc_html($eventsia_settings['eventsia_our_testimonial_title']);?> </h2>
								</div> <!-- end .box-header -->
							<?php } ?>

							<div class="testimonials">
								<div class="column">
									<?php
									while ($eventsia_our_testimonials_get_featured_posts->have_posts()):$eventsia_our_testimonials_get_featured_posts->the_post(); ?>
										<div class="three-column">
					                	<div class="testimonial-quote">
						                   	<?php the_content(); ?>
						                   	<span class="quote-icon"></span>
					                  </div>
					                  <?php if (has_post_thumbnail()) { ?>
												 <figure class="testimonial-person">
													<a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
												</figure> <!-- end .speaker-person -->
											<?php } ?>
											<div class="tm-person-name">
												<h5 class="tm-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
											</div>
										</div><!-- end .three-column -->
									<?php endwhile;
									wp_reset_postdata(); ?>
								</div><!-- end .column -->
							</div> <!-- end .testimonials -->
						</div> <!-- end .wrap -->
					</div> <!-- end .testimonial_bg -->
				</div> <!-- end .testimonial-box -->
			<?php }
	}
}
