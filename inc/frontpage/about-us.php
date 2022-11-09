<?php
/**
 * Eventsia
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */

add_action('eventsia_display_about_us','eventsia_about_us');
function eventsia_about_us(){
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_aboutus_bg_image = $eventsia_settings['eventsia-img-upload-aboutus-bg-image'];
	$eventsia_flip_content = $eventsia_settings['eventsia-about-content'];
	
	if($eventsia_settings['eventsia_disable_about_us'] ==0){
		$i =1;
		$eventsia_about_us	= array();
		$eventsia_about_us	=	array_merge( $eventsia_about_us, array( $eventsia_settings['eventsia_about_us'] ) );
		$eventsia_get_about_us_section 		= new WP_Query(array(
								'posts_per_page'      	=> intval($eventsia_settings['eventsia_about_us']),
								'post_type'           	=> array('page'),
								'post__in'            	=> array_values($eventsia_about_us),
								'orderby'             	=> 'post__in',
							)); ?>

		<!-- About Box ============================================= -->
		<div class="about-box <?php if($eventsia_flip_content=='flip-content'){ echo 'flip-content'; } elseif ($eventsia_flip_content=='fullwidth-content') { echo 'full-column'; } ?>">
			<div class="about-box-bg"<?php if(!empty($eventsia_aboutus_bg_image)): ?> style="background-image:url('<?php echo esc_url($eventsia_aboutus_bg_image); ?>');"<?php endif; ?>>
				<div class="wrap">
					<?php
					if($eventsia_get_about_us_section->have_posts()):$eventsia_get_about_us_section->the_post(); ?>
						<div class="about-content">
							<div class="about-content-column">
								<div class="about-content-wrap">
									<article>
										<h2 class="about-title">
											<?php if($eventsia_settings['eventsia_about_us_remove_link']==0){ ?>
												<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
												<?php }else{
													the_title();
											} ?>
										</h2>
										<?php the_content(); ?>
									</article>
								</div><!-- end .about-content-wrap -->
							</div><!-- end .about-content-column -->

							<?php
							if(has_post_thumbnail()): ?>
								<div class="about-content-column">
									<div class="about-image">
										<?php if($eventsia_settings['eventsia_about_us_remove_link']==0){ ?>
										<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
										<?php }else{
											the_post_thumbnail();
										} ?>
									</div><!-- end .about-image -->
								</div><!-- end .about-content-column -->
							<?php endif; ?>
						</div><!-- end .about-content -->
					<?php endif;
					wp_reset_postdata(); ?>
				</div><!-- end .wrap -->
			</div><!-- end .about-box-bg -->
		</div><!-- end .about-box -->
		<?php 
	}
}