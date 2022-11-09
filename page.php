<?php
/**
 * The template for displaying all pages.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */

get_header();
$eventsia_settings = eventsia_get_theme_options();
$eventsia_display_page_single_featured_image = $eventsia_settings['eventsia_display_page_single_featured_image'];?>
<div id="content" class="site-content">
	<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<div class="single-wrap">
					<header class="page-header">
						<?php if ( is_front_page()) : ?>

							<h2 class="page-title"><?php the_title();?></h2>
							<!-- .page-title -->

						<?php else : ?>

							<h1 class="page-title"><?php the_title();?></h1>
							<!-- .page-title -->

						<?php endif; ?>
						<?php eventsia_breadcrumb(); ?><!-- .breadcrumb -->
					</header><!-- .page-header -->
					<?php
					if( have_posts() ) {

						while( have_posts() ) {

							the_post(); ?>

					<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if(has_post_thumbnail() && $eventsia_display_page_single_featured_image == 0 ){ ?>
							<div class="entry-thumb">
								<figure class="entry-thumb-content">
									<?php the_post_thumbnail(); ?>
								</figure>
							</div><!-- end.post-image-content -->
						<?php } ?>
						<div class="entry-content">

							<?php the_content(); ?>

						</div> <!-- entry-content clearfix-->
						<?php
						wp_link_pages( array( 
								'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'eventsia' ),
								'after'             => '</div>',
								'link_before'       => '<span>',
								'link_after'        => '</span>',
								'pagelink'          => '%',
								'echo'              => 1
								) );
						comments_template(); ?>
					</article>
					<?php }
					} else { ?>
					<h1 class="entry-title"> <?php esc_html_e( 'No Posts Found.', 'eventsia' ); ?> </h1>
					<?php
					} ?>
			</div> <!-- end .single-wrap -->
			</main><!-- end #main -->
		</div> <!-- #primary -->
	<?php get_sidebar(); ?>
	</div><!-- end .wrap -->
</div><!-- end #content -->
<?php get_footer();