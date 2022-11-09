<?php
/**
 * Upcoming Eventsia
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */

add_action('eventsia_display_upcoming_box','eventsia_upcoming_box');
function eventsia_upcoming_box(){
	$eventsia_settings = eventsia_get_theme_options();
	if($eventsia_settings['eventsia_disable_upcoming'] != 1){
		if ($eventsia_settings['eventsia_upcoming_status'] =='publish'){

					$get_upcoming_posts = new WP_Query(array(
						'posts_per_page' =>  absint($eventsia_settings['eventsia_no_upcoming_posts']),
						'post_type' => array(
							'post'
						) ,
						'category_name' => esc_attr($eventsia_settings['eventsia_upcoming_category_list'])
					));
		} else {
				$get_upcoming_posts = new WP_Query(array(
						'posts_per_page' =>  absint($eventsia_settings['eventsia_no_upcoming_posts']),
						'post_type' => array(
							'post'
						) ,
						'post_status' => esc_attr($eventsia_settings['eventsia_upcoming_status'])
					));

		}
		if ( !empty($eventsia_settings['eventsia_upcoming_title']) || $get_upcoming_posts !='') { 
		echo '<!-- New Event Box ============================================= -->';?>
		<div class="uc-event-box">
			<div class="uc-event-bg" <?php if($eventsia_settings['eventsia_upcoming_bg_image'] !=''){?>style="background-image:url('<?php echo esc_url($eventsia_settings['eventsia_upcoming_bg_image']); ?>');" <?php } ?>>
				<div class="wrap">
					<div class="uc-event-content">
						
							<?php
							
							if ( $eventsia_settings['eventsia_upcoming_status'] =='publish'){ 
								$cat_slug = $eventsia_settings['eventsia_upcoming_category_list'];
								if (!empty($cat_slug)) {
									$cat = get_category_by_slug($cat_slug);
									$catID = $cat->term_id;?>
										<div class="box-header">
											<h2 class="box-title"><?php echo esc_html($cat->name); ?></h2>
											<?php if (category_description($catID) !=''){ ?>
												<span class="box-sub-title"><?php echo esc_html(category_description($catID)); ?></span>
											<?php } ?>
										</div> <!-- end .box-header -->

								<?php } 
							}  else {
								if ( ($eventsia_settings['eventsia_upcoming_title']!='') || ($eventsia_settings['eventsia_upcoming_subtitle']!='') ){ ?>
									<div class="box-header">
											<?php
											if ($eventsia_settings['eventsia_upcoming_title']!=''){ ?>

											<h2 class="box-title"><?php echo esc_html($eventsia_settings['eventsia_upcoming_title']); ?></h2>
										<?php } ?>
											<?php if ($eventsia_settings['eventsia_upcoming_subtitle']!=''){ ?>
												<span class="box-sub-title"><?php echo esc_html ($eventsia_settings['eventsia_upcoming_subtitle']); ?></span>
											<?php } ?>

									<?php } ?>
									</div> <!-- end .box-header -->
							<?php } ?>
						<div class="column clearfix">
							<?php
							while ($get_upcoming_posts->have_posts()):$get_upcoming_posts->the_post(); ?>
								<div class="four-column">
									<?php if (has_post_thumbnail()) { ?>
										<div class="uc-img">
											<?php the_post_thumbnail(); ?>
											<a class="new-uc-img" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
												<div class="event-overlay">
													<span class="uc-img-link"></span>
												</div> <!-- end .event-overlay -->
											</a> <!-- end .new-uc-img -->
										</div> <!-- end .uc-img -->
									<?php } ?>
										<div class="uc-content">
											<h4 class="uc-event-title"><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title();?></a></h4>
											<?php the_excerpt(); ?>
										</div>
								</div><!-- end .four-column -->
							<?php endwhile;
							wp_reset_postdata(); ?>
						</div><!-- .end column-->
					</div> <!-- end .uc-event-content -->
				</div> <!-- end .wrap -->
			</div> <!-- end .uc-event-bg -->
		</div> <!-- end .uc-event-box -->
		<?php }
	}
}
