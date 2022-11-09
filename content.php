<?php
/**
 * The template for displaying content.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
$eventsia_settings = eventsia_get_theme_options(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
	<?php
		$eventsia_entry_meta_blog = $eventsia_settings['eventsia_entry_meta_blog'];
		$eventsia_blog_content_layout = $eventsia_settings['eventsia_blog_content_layout'];
		$eventsia_blog_post_image = $eventsia_settings['eventsia_blog_post_image'];
		$eventsia_tag_list = get_the_tag_list();
		$eventsia_format = get_post_format();
		$eventsia_post_category = $eventsia_settings['eventsia_post_category'];
		$eventsia_post_author = $eventsia_settings['eventsia_post_author'];
		$eventsia_post_date = $eventsia_settings['eventsia_post_date'];
		$eventsia_post_comments = $eventsia_settings['eventsia_post_comments'];
		 ?>
		<?php if( has_post_thumbnail() && $eventsia_blog_post_image == 'on') { ?>
			<div class="post-media">
				<figure class="post-featured-image">
						<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
				</figure><!-- end.post-featured-image -->	
			</div><!-- end.post-media -->
		<?php } ?>
		<div class="post-content">
			<header class="entry-header">
				<?php if($eventsia_entry_meta_blog != 'hide-meta' ){ ?>
					<div class="entry-meta">
						<?php
						if($eventsia_post_date !=1){
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
			</header><!-- end .entry-header -->
			<div class="entry-content">
				<?php $eventsia_tag_text = $eventsia_settings['eventsia_tag_text'];
				if($eventsia_blog_content_layout == 'excerptblog_display'):
						the_excerpt(); ?>
					<?php else:
						the_content( sprintf(esc_html($eventsia_tag_text).'%s', '<span class="screen-reader-text">  '.get_the_title().'</span>' ));
					endif; ?>
			</div> <!-- end .entry-content -->
			<div class="entry-footer">
				<?php if($eventsia_entry_meta_blog != 'hide-meta' ){ ?>
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
								<?php comments_popup_link( __( '<i class="fas fa-comments" aria-hidden="true"></i> No Comments', 'eventsia' ), __( '<i class="fas fa-comments" aria-hidden="true"></i> 1 Comment', 'eventsia' ), __( '<i class="fas fa-comments" aria-hidden="true"></i> % Comments', 'eventsia' ), '', __( 'Comments Off', 'eventsia' ) ); ?> </span>
						<?php } ?>
					</div> <!-- end .entry-meta -->
				<?php } ?>
			</div> <!-- end .entry-footer -->
		</div> <!-- end .post-content -->
			
		<?php wp_link_pages( array( 
				'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'eventsia' ),
				'after'             => '</div>',
				'link_before'       => '<span>',
				'link_after'        => '</span>',
				'pagelink'          => '%',
				'echo'              => 1
			) ); ?>
	</article><!-- end .post -->