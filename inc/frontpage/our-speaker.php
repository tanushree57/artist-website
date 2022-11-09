<?php
/**
 * Our Speakers
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
add_action('eventsia_display_our_speaker','eventsia_our_speaker');
function eventsia_our_speaker(){
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_our_speaker_show_text = $eventsia_settings['eventsia_our_speaker_show_text'];
	if($eventsia_settings['eventsia_disable_our_speaker'] != 1){
		$eventsia_our_speaker_total_page_no = 0;
		$eventsia_our_speaker_list_page	= array();
		for( $i = 1; $i <= $eventsia_settings['eventsia_total_our_speaker']; $i++ ){
			if( isset ( $eventsia_settings['eventsia_our_speaker_features_' . $i] ) && $eventsia_settings['eventsia_our_speaker_features_' . $i] > 0 ){
				$eventsia_our_speaker_total_page_no++;

				$eventsia_our_speaker_list_page	=	array_merge( $eventsia_our_speaker_list_page, array( $eventsia_settings['eventsia_our_speaker_features_' . $i] ) );
			}
		}
		if (( !empty( $eventsia_our_speaker_list_page ) || !empty($eventsia_settings['eventsia_our_speaker_title']) )  && $eventsia_our_speaker_total_page_no > 0 ) {
			echo '<!-- Our Team Box ============================================= -->'; ?>
				<div class="speaker-team-box <?php if ($eventsia_our_speaker_show_text !=0){ echo ('show-text'); } ?>">
					<div class="speaker-team-bg" <?php if ($eventsia_settings['eventsia-img-upload-speaker-bg-image']): ?> style="background-image:url('<?php echo esc_url($eventsia_settings['eventsia-img-upload-speaker-bg-image']); ?>');"<?php endif; ?>>
								<?php	$eventsia_our_speaker_get_featured_posts 		= new WP_Query(array(
									'posts_per_page'      	=> absint($eventsia_settings['eventsia_total_our_speaker']),
									'post_type'           	=> array('page'),
									'post__in'            	=> array_values($eventsia_our_speaker_list_page),
									'orderby'             	=> 'post__in',
								));
								?>
						<div class="wrap">
							<?php if($eventsia_settings['eventsia_our_speaker_title'] != ''){ ?>
								<div class="box-header">
									<h2 class="box-title"><?php echo esc_html($eventsia_settings['eventsia_our_speaker_title']);?> </h2>
								</div> <!-- end .box-header -->
							<?php } ?>
							<div class="column clearfix">
								<?php
								$i=1;
								while ($eventsia_our_speaker_get_featured_posts->have_posts()):$eventsia_our_speaker_get_featured_posts->the_post(); ?>
									<div class="four-column">
										<div class="speaker-team">
											<?php if (has_post_thumbnail()) { ?>
												<figure class="speaker-person">
													<a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
												</figure> <!-- end .speaker-person -->
											<?php } ?>
												<div class="speaker-title-box">
													<div class="speaker-title-inner">
															<h5 class="speaker-name"><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
														<?php
														if($eventsia_settings['eventsia_our_speaker_position_'. $i .''] != ''){ ?>

															<span class="speaker-designation"><?php echo esc_html($eventsia_settings['eventsia_our_speaker_position_'. $i .'']);?></span>
														<?php } ?>
													</div> <!-- end .speaker-title -->
												</div> <!-- end .speaker-title-inner -->
				
										</div> <!-- end .speaker-team-box -->
									</div> <!-- end .four-column -->
								<?php $i++;
							 endwhile;
							 wp_reset_postdata(); ?>
							</div><!-- .end column-->
						</div><!-- end .wrap -->
					</div> <!-- end .speaker-team-bg -->
				</div> <!-- end .speaker-team-box -->
			<?php }
	}
}
