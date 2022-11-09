<?php
/**
 * The template for displaying search results.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
get_header(); ?>

<div id="content" class="site-content">
	<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<div class="blog-holder-wrap">
				<?php if( have_posts() ) { ?>

					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'eventsia' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
						<?php eventsia_breadcrumb(); ?><!-- .breadcrumb -->
					</header><!-- .page-header -->
				
						<?php while( have_posts() ) {

							the_post();
							get_template_part( 'content', get_post_format() );

						}
				} else { ?>
					<h2 class="entry-title">

						<?php esc_html_e( 'No Posts Found.', 'eventsia' ); ?>
					</h2>

				<?php }
				get_template_part( 'pagination', 'none' );

					get_search_form(); ?>
				</div><!-- end .blog-holder-wrap -->
			</main><!-- end #main -->
		</div> <!-- #primary -->
	<?php get_sidebar(); ?>
	</div><!-- end .wrap -->
</div><!-- end #content -->
<?php get_footer();
