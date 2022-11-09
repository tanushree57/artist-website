<?php
/**
 * Custom functions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
/********************* Set Default Value if not set ***********************************/
	if ( !get_theme_mod('eventsia_theme_options') ) {

		set_theme_mod( 'eventsia_theme_options', eventsia_get_option_defaults_values() );

	}

/******************************** EXCERPT LENGTH *********************************/
function eventsia_excerpt_length($eventsia_excerpt_length) {
	$eventsia_settings = eventsia_get_theme_options();
	if( is_admin() ){
		return absint($eventsia_excerpt_length);
	}

	$eventsia_excerpt_length = $eventsia_settings['eventsia_excerpt_length'];
	return absint($eventsia_excerpt_length);
}
add_filter('excerpt_length', 'eventsia_excerpt_length');

/********************* CONTINUE READING LINKS FOR EXCERPT *********************************/
function eventsia_continue_reading($more) {
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_tag_text = $eventsia_settings['eventsia_tag_text'];
	$link = sprintf(
			'<a href="%1$s" class="more-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),esc_html($eventsia_tag_text),
			/* translators: %s: Name of current post */
			sprintf( __( '<span class="screen-reader-text"> "%s"</span>', 'eventsia' ), get_the_title( get_the_ID() ) )
		);
	if( is_admin() ){
		return $more;
	}

	return $link;
}
add_filter('excerpt_more', 'eventsia_continue_reading');

/***************** USED CLASS FOR BODY TAGS ******************************/
function eventsia_body_class($eventsia_class) {
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_site_layout = $eventsia_settings['eventsia_design_layout'];
	$enable_header_image = $eventsia_settings['eventsia_enable_header_image'];

	if ($eventsia_site_layout =='boxed-layout') {

		$eventsia_class[] = 'boxed-layout';

	}elseif ($eventsia_site_layout =='small-boxed-layout') {

		$eventsia_class[] = 'boxed-layout-small';

	}else{

		$eventsia_class[] = '';

	}

	if ( is_singular() && false !== strpos( get_queried_object()->post_content, '<!-- wp:' ) ) {

		$eventsia_class[] = 'gutenberg';

	}

	if(is_page_template('page-templates/contact-template.php')) {

		$eventsia_class[] = 'contact-template';

	}

	if(is_page_template('page-templates/eventsia-template.php')) {

		$eventsia_class[] = 'eventsia-template';

	}

	if($eventsia_settings['eventsia_header_design']=='1'){

		$eventsia_class[] = 'design-1';

	} else {

		$eventsia_class[] = 'design-2';

	}

	if (!is_active_sidebar('eventsia_main_sidebar')){

		$eventsia_class[] = 'no-sidebar-layout';

	}

	if ( has_header_image() ) {
		if(is_front_page() && ($enable_header_image=='frontpage') ) {

			$eventsia_class[] = 'header-image';

		} elseif ($enable_header_image=='enitresite'){
			$eventsia_class[] = 'header-image';

		} else {
			$eventsia_class[] = '';
		} 	

	 }

	return $eventsia_class;
}
add_filter('body_class', 'eventsia_body_class');

/********************** SCRIPTS FOR DONATE/ UPGRADE BUTTON ******************************/
function eventsia_customize_scripts() {

	wp_enqueue_style( 'eventsia_customizer_custom', get_template_directory_uri() . '/inc/css/eventsia-customizer.css');

}
add_action( 'customize_controls_print_scripts', 'eventsia_customize_scripts');

/**************************** SOCIAL MENU *********************************************/
function eventsia_social_links_display() {
		if ( has_nav_menu( 'social-link' ) ) : ?>
	<div class="social-links clearfix">
	<?php
		wp_nav_menu( array(
			'container' 	=> '',
			'theme_location' => 'social-link',
			'depth'          => 1,
			'items_wrap'      => '<ul>%3$s</ul>',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>' . eventsia_get_icons(array( 'icon' => 'tf-link' ) ),
		) );
	?>
	</div><!-- end .social-links -->
	<?php endif; ?>
<?php }
add_action ('eventsia_social_links', 'eventsia_social_links_display');

/******************* DISPLAY BREADCRUMBS ******************************/
function eventsia_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb home">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}
/*************************** ENQUEING STYLES AND SCRIPTS ****************************************/
function eventsia_scripts() {
	// Include the file.
	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_stick_menu = $eventsia_settings['eventsia_stick_menu'];
	wp_enqueue_script('eventsia-main', get_template_directory_uri().'/js/eventsia-main.js', array('jquery'), false, true);
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	wp_enqueue_style( 'eventsia-style', get_stylesheet_uri() );

	wp_enqueue_style('eventsia-responsive', get_template_directory_uri().'/css/responsive.css');

	wp_enqueue_style('eventsia-font-icons', get_template_directory_uri().'/assets/font-icons/css/all.min.css');
	wp_enqueue_script('eventsia-navigation', get_template_directory_uri().'/js/navigation.js', array('jquery'), false, true);
	wp_enqueue_script('eventsia-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array('jquery'), false, true);

	if( $eventsia_stick_menu != 1 ):

		wp_enqueue_script('jquery-sticky', get_template_directory_uri().'/assets/sticky/jquery.sticky.min.js', array('jquery'), false, true);
		wp_enqueue_script('eventsia-sticky-settings', get_template_directory_uri().'/assets/sticky/sticky-settings.js', array('jquery'), false, true);

	endif;
}

	add_action( 'wp_enqueue_scripts', 'eventsia_scripts');

	function eventsia_inline_fonts() {

	$eventsia_settings = eventsia_get_theme_options();

	/********* Adding Multiple Fonts ********************/
	$eventsia_googlefont = array();
	array_push( $eventsia_googlefont, 'Source+Sans+Pro');
	$eventsia_googlefonts = implode("|", $eventsia_googlefont);

	wp_register_style( 'eventsia-google-fonts', wptt_get_webfont_url('https://fonts.googleapis.com/css?family='.$eventsia_googlefonts .':300,400,600,700'));
	wp_enqueue_style( 'eventsia-google-fonts' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* Custom Css */
	$eventsia_internal_css='';

	if($eventsia_settings['eventsia_header_display']=='header_logo'){
		$eventsia_internal_css .= '
		#site-branding #site-title, #site-branding #site-description{
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
		#site-detail {
			padding: 0;
		}';
	}

	if($eventsia_settings['eventsia_header_image_with_bg_color']=='with-bg-color'){
		$eventsia_internal_css .= '/* Header image With background color */
		.custom-header:before {
			position: absolute;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: #333F46;
			content: "";
			opacity: 0.65;
			z-index: 1;
		}';
	}

	if($eventsia_settings['eventsia_header_image_content_bg_color']=='bg-content-color'){
		$eventsia_internal_css .= '/* Header image Content With background color */
		.custom-header-content {
			background-color: rgba(255, 255, 255, 0.5);
			border: 1px solid rgba(255, 255, 255, 0.5);
			outline: 6px solid rgba(255, 255, 255, 0.5);
			padding: 20px;
		}';
	}

	wp_add_inline_style( 'eventsia-style', wp_strip_all_tags($eventsia_internal_css) );
}
add_action( 'wp_enqueue_scripts', 'eventsia_inline_fonts',70);

/**************** Header banner display/ Widget slider ***********************/
function eventsia_header_image_widget_slider(){
	$eventsia_settings = eventsia_get_theme_options();
	if ( get_header_image() ) : ?>
		<div class="custom-header">
			<div class="custom-header-wrap">
				<img src="<?php header_image(); ?>" class="header-image" width="<?php echo esc_attr(get_custom_header()->width);?>" height="<?php echo esc_attr(get_custom_header()->height);?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display'));?>">
				<?php if($eventsia_settings['eventsia_header_image_title'] !=''){ ?>
					<div class="custom-header-content">
						<?php if (!empty($eventsia_settings['eventsia_header_image_title'] ) ): ?>
							<h2 class="header-image-title"><?php echo esc_html($eventsia_settings['eventsia_header_image_title']);?></h2>

							<?php endif;

							if (!empty($eventsia_settings['eventsia_header_sub_title'] ) ): ?>

							<span class="header-image-sub-title"><?php echo esc_html($eventsia_settings['eventsia_header_sub_title']); ?></span>
							<?php endif;

							if (!empty($eventsia_settings['eventsia_header_image_button'] ) ): ?>
							<a title="<?php echo esc_attr($eventsia_settings['eventsia_header_image_button']);?>" href="<?php echo esc_url($eventsia_settings['eventsia_header_image_link']);?>"  class="btn-default" target="_blank"><span><?php echo esc_html($eventsia_settings['eventsia_header_image_button']);?></span><i class="fas fa-chevron-right" aria-hidden="true"></i></a>
						<?php endif; ?>
					</div> <!-- end .custom-header-content -->
				<?php } ?>
			</div><!-- end .custom-header-wrap -->
		</div> <!-- end .custom-header -->
		<?php endif;
		if(is_active_sidebar( 'eventsia_slider_section' )):?>
			<div class ="slider-widget-section">

				<?php dynamic_sidebar( 'eventsia_slider_section' ); ?>
			</div>
		<?php endif;
}

add_action('eventsia_display_header_image_widget_slider','eventsia_header_image_widget_slider');

/**************** Header right ***********************/
function eventsia_header_right_section(){
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_side_menu = $eventsia_settings['eventsia_side_menu'];
	$search_form = $eventsia_settings['eventsia_search_custom_header']; ?>
	<div class="header-right">
		<?php
			if( (1 != $eventsia_side_menu) || (1 != $search_form) ){

					if(1 != $eventsia_side_menu){
						if( (has_nav_menu('side-nav-menu')) || is_active_sidebar( 'eventsia_side_menu' ) ){
						if ( has_nav_menu( 'social-link' ) && $eventsia_settings['eventsia_side_menu_social_icons'] == 0 ): ?>
							<button type="button" class="show-menu-toggle">
								<span class="screen-reader-text"><?php esc_html_e('Side Menu Button','eventsia'); ?></span>
								<span class="bars"></span>
							</button>
				  		<?php  endif;
				  		}
				  	}

				  	if(1 != $eventsia_side_menu){ ?>
						<div class="side-menu-wrap">
							<div class="side-menu">
						  		<button type="button" class="hide-menu-toggle">			
									<span class="bars"></span>
							  	</button>

								<?php

								if (has_nav_menu('side-nav-menu') || (has_nav_menu( 'social-link' ) && $eventsia_settings['eventsia_side_menu_social_icons'] == 0 ) || is_active_sidebar( 'eventsia_side_menu' ) ):
									
									if (has_nav_menu('side-nav-menu')) { 
										$args = array(
											'theme_location' => 'side-nav-menu',
											'container'      => '',
											'items_wrap'     => '<ul class="side-menu-list">%3$s</ul>',
											); ?>
									<nav class="side-nav-wrap" role="navigation"  aria-label="<?php esc_attr_e( 'Side Menu', 'eventsia' ); ?>">
										<?php wp_nav_menu($args); ?>
									</nav><!-- end .side-nav-wrap -->
									<?php }
									if($eventsia_settings['eventsia_side_menu_social_icons'] == 0):
										do_action('eventsia_social_links');
									endif;

									if( is_active_sidebar( 'eventsia_side_menu' )) {
										echo '<div class="side-widget-tray">';

											dynamic_sidebar( 'eventsia_side_menu' );

										echo '</div> <!-- end .side-widget-tray -->';
									} 
								endif; ?>
							</div><!-- end .side-menu -->
						</div><!-- end .side-menu-wrap -->
					<?php }

				  	if (1 != $search_form) { ?>
					<button type="button" id="search-toggle" class="header-search"><span class="screen-reader-text"><?php echo esc_html($eventsia_settings['eventsia_search_text']); ?></span></button>

						<div id="search-box" class="clearfix">
								<?php get_search_form();?>
						</div>  <!-- end #search-box -->
					<?php }
			} ?>
		</div> <!-- end .header-right -->
<?php }

add_action('eventsia_display_header_right_section','eventsia_header_right_section');

/**************** Categoy Lists ***********************/

if( !function_exists( 'eventsia_categories_lists' ) ):
    function eventsia_categories_lists() {
        $eventsia_cat_args = array(
            'type'       => 'post',
            'taxonomy'   => 'category',
        );
        $eventsia_categories = get_categories( $eventsia_cat_args );
        $eventsia_categories_lists = array();
        $eventsia_categories_lists = array('' => esc_html__('--Select--','eventsia'));
        foreach( $eventsia_categories as $category ) {
            $eventsia_categories_lists[esc_attr( $category->slug )] = esc_html( $category->name );
        }
        return $eventsia_categories_lists;
    }
endif;

/********************* Footer Column Section ***********************************/
function eventsia_footer_column_section() {
	$eventsia_settings = eventsia_get_theme_options();
	$footer_column = $eventsia_settings['eventsia_footer_column_section'];
	if( is_active_sidebar( 'eventsia_footer_1' ) || is_active_sidebar( 'eventsia_footer_2' ) || is_active_sidebar( 'eventsia_footer_3' ) || is_active_sidebar( 'eventsia_footer_4' )) { ?>
		<div class="widget-wrap">
			<div class="wrap">
				<div class="widget-area">
					<?php
					if($footer_column == '1' || $footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
					echo '<div class="column-'.absint($footer_column).'">';
						if ( is_active_sidebar( 'eventsia_footer_1' ) ) :
							dynamic_sidebar( 'eventsia_footer_1' );
						endif;
					echo '</div><!-- end .column'.absint($footer_column). '  -->';
					}
					if($footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
					echo '<div class="column-'.absint($footer_column).'">';
						if ( is_active_sidebar( 'eventsia_footer_2' ) ) :
							dynamic_sidebar( 'eventsia_footer_2' );
						endif;
					echo '</div><!--end .column'.absint($footer_column).'  -->';
					}
					if($footer_column == '3' || $footer_column == '4'){
					echo '<div class="column-'.absint($footer_column).'">';
						if ( is_active_sidebar( 'eventsia_footer_3' ) ) :
							dynamic_sidebar( 'eventsia_footer_3' );
						endif;
					echo '</div><!--end .column'.absint($footer_column).'  -->';
					}
					if($footer_column == '4'){
					echo '<div class="column-'.absint($footer_column).'">';
						if ( is_active_sidebar( 'eventsia_footer_4' ) ) :
							dynamic_sidebar( 'eventsia_footer_4' );
						endif;
					echo '</div><!--end .column'.absint($footer_column).  '-->';
					}
					?>
				</div> <!-- end .widget-area -->
			</div> <!-- end .wrap -->
		</div> <!-- end .widget-wrap -->
	<?php }
} 
add_action( 'eventsia_footer_columns', 'eventsia_footer_column_section' );

/********************* Eventsia Frontpage Template Section ***********************************/
function eventsia_frontpage_template_sidebar_section() {

	if ( is_active_sidebar( 'eventsia_frontpage_template' ) ) : ?>
		<!-- Frontpage Template Box ============================================= -->
				<div class="frontpage-template-widgets">
					<div class="wrap">
						<div class="fp-template-wrap">
							<?php dynamic_sidebar( 'eventsia_frontpage_template' ); ?>
						</div>
						<!-- end .frontpage-template-wrap -->
					</div>
					<!-- end .wrap -->
				</div>
				<!-- end .frontpage-template-widgets -->

	<?php	endif;
	

} 
add_action( 'eventsia_frontpage_widget_section', 'eventsia_frontpage_template_sidebar_section' );