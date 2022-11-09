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

/*********************** Eventsia Latest from Blog ***********************************/
add_action( 'eventsia_display_blog', 'eventsia_display_latest_blog' );
/**
 * Displaying the Latet from Blog/ Category
 *
 */

function eventsia_display_latest_blog() {
	$eventsia_settings = eventsia_get_theme_options();
	if($eventsia_settings['eventsia_disable_latest_blog'] != 1){
		if($eventsia_settings['eventsia_hide_sticky_latest_blog']==0){
			if($eventsia_settings['eventsia_latest_category_blog_section']=='latest_blog'){
					$get_latest_blog_posts = new WP_Query(array(
						'posts_per_page' =>  absint($eventsia_settings['eventsia_total_latest_blog']),
						'post_type' => array(
							'post'
						) ,
					));
				}else{
					$get_latest_blog_posts = new WP_Query(array(
						'posts_per_page' =>  absint($eventsia_settings['eventsia_total_latest_blog']),
						'post_type' => array(
							'post'
						) ,
						'category_name' => $eventsia_settings['eventsia_latest_blog_category_list'],
					));
				}
		}else{
			if($eventsia_settings['eventsia_latest_category_blog_section']=='latest_blog'){
					$get_latest_blog_posts = new WP_Query(array(
						'posts_per_page' =>  absint($eventsia_settings['eventsia_total_latest_blog']),
						'post_type' => array(
							'post'
						) ,
						 'post__not_in' => get_option( 'sticky_posts'),
					));
				}else{
					$get_latest_blog_posts = new WP_Query(array(
						'posts_per_page' =>  absint($eventsia_settings['eventsia_total_latest_blog']),
						'post_type' => array(
							'post'
						) ,
						 'post__not_in' => get_option( 'sticky_posts'),
						'category_name' => esc_attr($eventsia_settings['eventsia_latest_blog_category_list']),
					));
				}
		}

		if ( !empty($eventsia_settings['eventsia_latest_blog_title']) || $get_latest_blog_posts !='') {
			echo '<!-- Latest Blog ============================================= -->';?>
			<div class="latest-blog-box">
				<div class="wrap">
					
					<?php
					$cat_slug = $eventsia_settings['eventsia_latest_blog_category_list'];
					$cat = get_category_by_slug($cat_slug);
					$catID = $cat->term_id;
					if ($eventsia_settings['eventsia_latest_category_blog_section'] =='category_display'){ ?>
					<div class="box-header">
						<h2 class="box-title"><?php echo esc_html($cat->name); ?></h2>
						<?php if (category_description($catID) !=''){ ?>
							<span class="box-sub-title"><?php echo esc_html(category_description($catID)); ?></span>
						<?php } ?>
					</div> <!-- end .box-header -->
					<?php } else { 
					if ( ($eventsia_settings['eventsia_latest_blog_title']!='') || ($eventsia_settings['eventsia_latest_blog_subtitle']!='') ){ ?>
						<div class="box-header">
							<?php if ($eventsia_settings['eventsia_latest_blog_title']!=''){  ?>
								<h2 class="box-title"><?php echo esc_html ($eventsia_settings['eventsia_latest_blog_title']); ?></h2>
							<?php }
							if ($eventsia_settings['eventsia_latest_blog_subtitle']!=''){ ?>
							<span class="box-sub-title"><?php echo esc_html ($eventsia_settings['eventsia_latest_blog_subtitle']); ?></span>
							<?php } ?>
						</div> <!-- end .box-header -->
					<?php }

					} ?>
					<div class="column">

						<?php
						while ($get_latest_blog_posts->have_posts()):$get_latest_blog_posts->the_post(); ?>
								<div class="three-column">
									<article <?php post_class();?>>
									<?php if (has_post_thumbnail()) { ?>
										<div class="latest-blog-image">
											<figure class="post-featured-image">
												<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
											</figure>
											<!-- end.post-featured-image -->
										</div>
										<!-- end.post-image-content -->
									<?php } ?>
										<div class="latest-blog-text">
											<header class="entry-header">
												<h2 class="entry-title">
													<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink();?>"> <?php the_title();?></a>
												</h2>
												<!-- end.entry-title -->
												<?php if($eventsia_settings['eventsia_disable_latest_blog_date']==0){?>
												<div class="entry-meta">

													<span class="posted-on"><a title="<?php echo esc_attr( get_the_time() ); ?>" href="<?php the_permalink(); ?>"><?php esc_html(the_time( get_option( 'date_format' ) )); ?></a></span>

												</div>
												<!-- end .entry-meta -->
												<?php } ?>
											</header>
											<!-- end .entry-header -->
											<div class="entry-content">
												<?php the_excerpt();?>
											</div>
											<!-- end .entry-content -->
										</div>
										<!-- end .latest-blog-text -->
									</article><!-- end .post -->
								</div><!-- end .three-column -->
							<?php
						endwhile;
						wp_reset_postdata(); ?>
					</div> <!-- end .latest-blog-wrapper -->
				</div> <!-- end .wrap -->
			</div> <!-- end .column -->
		<?php }
	}
}