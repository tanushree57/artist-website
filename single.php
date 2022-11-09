<?php
/**
 * The template for displaying all single posts.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
get_header();

$eventsia_settings = eventsia_get_theme_options();
$eventsia_display_page_single_featured_image = $eventsia_settings['eventsia_display_page_single_featured_image'];
$eventsia_format = get_post_format();
$eventsia_entry_meta_single = $eventsia_settings['eventsia_entry_meta_single'];
$eventsia_tag_list = get_the_tag_list();
$eventsia_post_category = $eventsia_settings['eventsia_post_category'];
$eventsia_post_author = $eventsia_settings['eventsia_post_author'];
$eventsia_post_date = $eventsia_settings['eventsia_post_date'];
$eventsia_post_comments = $eventsia_settings['eventsia_post_comments'];
while( have_posts() ) {
	the_post(); ?>
<div id="content" class="site-content">
	<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<div class="single-wrap">
					<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
						<?php if(has_post_thumbnail() && $eventsia_display_page_single_featured_image == 0 ){ ?>

							<div class="entry-thumb">
								<figure class="entry-thumb-content">
									<?php the_post_thumbnail(); ?>
								</figure>
							</div> <!-- end .entry-thumb -->

						<?php } ?>
						 <header class="entry-header">
							<?php if($eventsia_entry_meta_single != 'hide' ){ ?>

								<div class="entry-meta">
									<?php if($eventsia_post_date !=1){

										printf( '<span class="posted-on"><a href="%1$s" title="%2$s"> %3$s </a></span>',
														esc_url(get_the_permalink()),
														esc_attr( get_the_time(get_option( 'date_format' )) ),
														esc_html( get_the_time(get_option( 'date_format' )) )
													);
									}

									if($eventsia_post_author !=1){

										echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'">' .esc_html(get_the_author()).'</a></span>';

									} ?>
								</div> <!-- end .entry-meta -->
							<?php } ?>
							<h2 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php the_title();?> </a> </h2> <!-- end.entry-title -->
							<?php eventsia_breadcrumb(); ?><!-- .breadcrumb -->
						</header> <!-- end .entry-header -->
						<div class="entry-content">

							<?php the_content(); ?>

						</div><!-- end .entry-content -->
						<div class="entry-footer">
							<?php if($eventsia_entry_meta_single != 'hide' ){ ?>

								<div class="entry-meta">
									<?php if ( current_theme_supports( 'post-formats', $eventsia_format ) ) { 

										printf( '<span class="entry-format"><a href="%1$s">%2$s</a></span>', esc_url( get_post_format_link( $eventsia_format ) ), esc_attr(get_post_format_string( $eventsia_format )) );

									}

									if($eventsia_post_category !=1){ ?>

										<span class="cat-links">
											<i class="fas fa-folder-open" aria-hidden="true"></i>
											<?php the_category(); ?>
										</span> <!-- end .cat-links -->

									<?php }

									if(!empty($eventsia_tag_list)){ ?>

										<span class="tag-links">
											<i class="fas fa-tag" aria-hidden="true"></i>
											<?php echo get_the_tag_list(); ?>

										</span> <!-- end .tag-links -->

									<?php }

									if ( comments_open() && $eventsia_post_comments !=1) { ?>

										<span class="comments">

											<?php comments_popup_link( __( '<i class="fas fa-comments" aria-hidden="true"></i> No Comments', 'eventsia' ), __( '<i class="fas fa-comments" aria-hidden="true"></i> 1 Comment', 'eventsia' ), __( '<i class="fas fa-comments" aria-hidden="true"></i> % Comments', 'eventsia' ), '', __( 'Comments Off', 'eventsia' ) ); ?>

										</span>

									<?php } ?>
								</div> <!-- end .entry-meta -->
							<?php } ?>
						</div> <!-- end .entry-footer -->
						
						<?php wp_link_pages( array( 
							'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'eventsia' ),
							'after'             => '</div>',
							'link_before'       => '<span>',
							'link_after'        => '</span>',
							'pagelink'          => '%',
							'echo'              => 1
						) );

						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}

					 ?>
					</article><!-- end .post -->
					<?php
					if ( is_singular( 'attachment' ) ) {

						// Parent post navigation.
						the_post_navigation( array(
									'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'eventsia' ),
								) );

					} elseif ( is_singular( 'post' ) ) {

					the_post_navigation( array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'eventsia' ) . '</span> ' .
								'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'eventsia' ) . '</span> ' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'eventsia' ) . '</span> ' .
								'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'eventsia' ) . '</span> ' .
								'<span class="post-title">%title</span>',
						) );
						} ?>
				</div> <!-- end .single-wrap -->
			</main><!-- end #main -->
		</div> <!-- end #primary -->
		<?php get_sidebar(); ?>
	</div><!-- end .wrap -->
</div><!-- end #content -->

<?php }
get_footer();