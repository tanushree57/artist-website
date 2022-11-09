<?php
/**
 * Gallery
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
add_action('eventsia_display_our_gallery','eventsia_our_gallery');
function eventsia_our_gallery(){
	$eventsia_settings = eventsia_get_theme_options();
	if($eventsia_settings['eventsia_disable_our_gallery'] != 1){
		$eventsia_our_gallery_total_page_no = 0;
		$eventsia_our_gallery_list_page	= array();
		for( $i = 1; $i <= $eventsia_settings['eventsia_total_our_gallery']; $i++ ){
			if( isset ( $eventsia_settings['eventsia_our_gallery_features_' . $i] ) && $eventsia_settings['eventsia_our_gallery_features_' . $i] > 0 ){
				$eventsia_our_gallery_total_page_no++;

				$eventsia_our_gallery_list_page	=	array_merge( $eventsia_our_gallery_list_page, array( $eventsia_settings['eventsia_our_gallery_features_' . $i] ) );
			}
		}
		if (( !empty( $eventsia_our_gallery_list_page ) || !empty($eventsia_settings['eventsia_our_gallery_title']) )  && $eventsia_our_gallery_total_page_no > 0 ) {
			echo '<!-- Portfolio Box ============================================= -->'; ?>
				<div class="portfolio-box">
					<?php if($eventsia_settings['eventsia_our_gallery_title'] != ''){ ?>
						<div class="wrap">
							<div class="box-header">
								<h2 class="box-title"><?php echo esc_html($eventsia_settings['eventsia_our_gallery_title']);?></h2>
							</div> <!-- end .box-header -->
						</div> <!-- end .wrap -->
					<?php }

					$eventsia_our_gallery_get_featured_posts 		= new WP_Query(array(
						'posts_per_page'      	=> absint($eventsia_settings['eventsia_total_our_gallery']),
						'post_type'           	=> array('page'),
						'post__in'            	=> array_values($eventsia_our_gallery_list_page),
						'orderby'             	=> 'post__in',
					)); ?>

					<div class="column clearfix">
						<?php
						while ($eventsia_our_gallery_get_featured_posts->have_posts()):$eventsia_our_gallery_get_featured_posts->the_post();
						$eventsia_attachment_id = get_post_thumbnail_id();
						$eventsia_image_attributes = wp_get_attachment_image_src($eventsia_attachment_id,'full');
						$i=1; ?>
							<div class="four-column-full-width">
								<?php if (has_post_thumbnail()) { ?>
									<div class="portfolio-img">
										<figure class="portfolio-image-inner">
											<?php the_post_thumbnail(); ?>
										</figure>

										<a class="portfolio-link" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
											<div class="portfolio-overlay">
												<h4 class="portfolio-title"><?php the_title(); ?></h4>
											</div>
										</a>
									</div><!-- end .portfolio-img -->
								<?php } ?>
							</div> <!-- end .four-column-full-width -->
						<?php $i++;
						 endwhile;
						 wp_reset_postdata(); ?>
					</div> <!-- end .column -->
				</div> 	<!-- end .portfolio-box -->
			<?php }
	}
}
