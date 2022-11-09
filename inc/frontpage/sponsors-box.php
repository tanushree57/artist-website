<?php
/**
 * Sponsors Box
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
add_action( 'eventsia_sponsors_box', 'eventsia_sponsors_box_details' );
/**
 * displaying the featured image
 *
 */

function eventsia_sponsors_box_details() {
	$eventsia_settings = eventsia_get_theme_options();
	if($eventsia_settings['eventsia_disable_sponsors_box'] != 1){
		$eventsia_sponsors_box = '';

		if(($eventsia_settings['eventsia_sponsors_box_image_heading']!='') ||  !empty( $eventsia_settings[ 'eventsia_sponsors_box_image_1' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_2' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_3' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_4' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_5' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_6' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_7' ] ) ||  !empty( $eventsia_settings[ 'sponsors_box_image_8' ] ) ){ ?>

			<!-- Our Sponsors Box ============================================= -->
			<div class="our-sponsors-box">
				<div class="our-sponsors-bg" <?php if ($eventsia_settings['eventsia_sponsors_bg_image']): ?> style="background-image:url('<?php echo esc_url($eventsia_settings['eventsia_sponsors_bg_image']); ?>');"<?php endif; ?>>
					<div class="wrap">
						<?php if($eventsia_settings['eventsia_sponsors_box_image_heading'] != ''){ ?>
							<div class="box-header">
									<h2 class="box-title"><?php echo esc_html($eventsia_settings['eventsia_sponsors_box_image_heading']);?></h2>
							</div> <!-- end .box-header -->
							<div class="os-content-wrap">
								<?php for( $i = 1; $i <= $eventsia_settings['eventsia_sponsors_box_no']; $i++ ){
									if( !empty( $eventsia_settings[ 'eventsia_sponsors_box_image_'. $i ] ) ) { $sponsors_box_image = $eventsia_settings[ 'eventsia_sponsors_box_image_'. $i ]; } else { $sponsors_box_image = ''; }

									if( !empty( $eventsia_settings[ 'eventsia_redirect_link' . $i ] ) ) { $eventsia_redirect_link = $eventsia_settings[ 'eventsia_redirect_link' . $i ]; } else { $eventsia_redirect_link = '#'; }

									if(!empty($sponsors_box_image)){ ?>
										<figure class="os-image">
											<a href="<?php echo esc_url ($eventsia_redirect_link); ?>"><img src="<?php echo esc_url($sponsors_box_image);?>" alt="<?php echo esc_attr ($eventsia_settings['eventsia_sponsors_box_image_heading']);?>"></a>
										</figure><!-- end .os-wrap -->
									<?php }
								} ?>
							</div> <!-- end .os-wrap -->
						<?php } ?>
					</div> <!-- end .wrap -->
				</div> <!-- end .our-sponsors-bg -->
			</div> <!-- end .our-sponsors-box -->
		<?php }
	}
}