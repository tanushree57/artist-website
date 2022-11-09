<?php
/**
 * Display all eventsia functions and definitions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */

include get_theme_file_path( 'inc/upgrade-plus/autoload/src/Loader.php' );

$loader = new \WPTRT\Autoload\Loader();

$loader->add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'inc/upgrade-plus/customize-section-button/src' ) );

$loader->register();

/************************************************************************************************/
if ( ! function_exists( 'eventsia_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eventsia_setup() {
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width=1300;
	}

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('post-thumbnails');

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Main Menu', 'eventsia' ),
		'side-nav-menu' => esc_html__( 'Side Menu', 'eventsia' ),
		'social-link'  => esc_html__( 'Add Social Icons Only', 'eventsia' ),
	) );

	/* 
	* Enable support for custom logo. 
	*
	*/ 
	add_theme_support( 'custom-logo', array(
		'flex-width' => true, 
		'flex-height' => true,
	) );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'gutenberg', array(
			'colors' => array(
				'#f80068',
			),
		) );
	add_theme_support( 'align-wide' );
	
	//Indicate widget sidebars can use selective refresh in the Customizer. 
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	add_image_size( 'eventsia-popular-post', 75, 75, true );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'eventsia_custom_background_args', array( 'default-color' => 'ffffff') ) );

	add_editor_style( array( 'css/editor-style.css') );

/**
 * Load WooCommerce compatibility files.
 */
	
require get_template_directory() . '/woocommerce/functions.php';


}
endif; // eventsia_setup
add_action( 'after_setup_theme', 'eventsia_setup' );

/***************************************************************************************/
function eventsia_content_width() {
	if ( is_page_template( 'page-templates/gallery-template.php' ) || is_attachment() ) {

		global $content_width;
		$content_width = 1920;

	}
}
add_action( 'template_redirect', 'eventsia_content_width' );

/***************************************************************************************/
if(!function_exists('eventsia_get_theme_options')):
	function eventsia_get_theme_options() {
	    return wp_parse_args(  get_option( 'eventsia_theme_options', array() ), eventsia_get_option_defaults_values() );
	}
endif;

/***************************************************************************************/
require get_template_directory() . '/inc/customizer/eventsia-default-values.php';
require get_template_directory() . '/inc/settings/eventsia-functions.php';
require get_template_directory() . '/inc/settings/eventsia-common-functions.php';
require get_template_directory() . '/inc/settings/icon-functions.php';
/************************ Eventsia Sidebar/ Widgets  *****************************/
require get_template_directory() . '/inc/widgets/widgets-functions/register-widgets.php';
require get_template_directory() . '/inc/widgets/widgets-functions/popular-posts.php';

/************************ Eventsia frontpage features  *****************************/
require get_template_directory() . '/inc/frontpage/about-us.php';
require get_template_directory() . '/inc/frontpage/upcoming-event.php';
require get_template_directory() . '/inc/frontpage/our-speaker.php';
require get_template_directory() . '/inc/frontpage/our-gallery.php';
require get_template_directory() . '/inc/frontpage/latest-from-blog.php';
require get_template_directory() . '/inc/frontpage/our-testimonials.php';
require get_template_directory() . '/inc/frontpage/sponsors-box.php';

if (!is_child_theme()){
	require get_template_directory() . '/inc/welcome-notice.php';
}

/************************ Eventsia Customizer  *****************************/

require get_template_directory() . '/inc/customizer/functions/sanitize-functions.php';
require get_template_directory() . '/inc/customizer/functions/register-panel.php';

function eventsia_customize_register( $wp_customize ) {
		if(!class_exists('Eventsia_Plus_Features')  && !class_exists('Mocktail_Customize_upgrade') && !class_exists('Cappuccino_Customize_upgrade') )  {
		class Eventsia_Customize_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
				<a title="<?php esc_attr_e( 'Review Us', 'eventsia' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/eventsia/' ); ?>" target="_blank" id="about_eventsia">
				<?php esc_html_e( 'Review Us', 'eventsia' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://themefreesia.com/theme-instruction/eventsia/' ); ?>" title="<?php esc_attr_e( 'Theme Instructions', 'eventsia' ); ?>" target="_blank" id="about_eventsia">
				<?php esc_html_e( 'Theme Instructions', 'eventsia' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://tickets.themefreesia.com/' ); ?>" title="<?php esc_attr_e( 'Support Tickets', 'eventsia' ); ?>" target="_blank" id="about_eventsia">
				<?php esc_html_e( 'Tickets', 'eventsia' ); ?>
				</a><br/>
			<?php
			}
		}
		$wp_customize->add_section('eventsia_upgrade_links', array(
			'title'					=> __('Important Links', 'eventsia'),
			'priority'				=> 1000,
		));
		$wp_customize->add_setting( 'eventsia_upgrade_links', array(
			'default'				=> false,
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Eventsia_Customize_upgrade(
			$wp_customize,
			'eventsia_upgrade_links',
				array(
					'section'				=> 'eventsia_upgrade_links',
					'settings'				=> 'eventsia_upgrade_links',
				)
			)
		);
	}	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'eventsia_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'eventsia_customize_partial_blogdescription',
		) );
	}

	require get_template_directory() . '/inc/customizer/functions/design-options.php';
	require get_template_directory() . '/inc/customizer/functions/theme-options.php';
	require get_template_directory() . '/inc/customizer/functions/color-options.php' ;
	require get_template_directory() . '/inc/customizer/functions/frontpage-features.php';
}

if(!class_exists('Eventsia_Plus_Features')){

	/**
	 * TGM plugin Activation
	 */
	require_once( trailingslashit( get_template_directory() ) . '/inc/tgm/tgm.php' );

}

/** 
* Render the site title for the selective refresh partial. 
* @see eventsia_customize_register() 
* @return void 
*/ 
function eventsia_customize_partial_blogname() {
	bloginfo( 'name' ); 
} 

/** 
* Render the site tagline for the selective refresh partial. 
* @see eventsia_customize_register() 
* @return void 
*/ 
function eventsia_customize_partial_blogdescription() {
	bloginfo( 'description' ); 
}
add_action( 'customize_register', 'eventsia_customize_register' );

/******************* Eventsia Site Branding Header Display *************************/
function eventsia_header_display(){
	$eventsia_settings = eventsia_get_theme_options();
	$header_display = $eventsia_settings['eventsia_header_display'];
	$eventsia_header_display = $eventsia_settings['eventsia_header_display'];
	if ($eventsia_header_display == 'header_logo' || $eventsia_header_display == 'header_text' || $eventsia_header_display == 'show_both') {

		if ($header_display == 'header_logo' || $header_display == 'header_text' || $header_display == 'show_both')	{
			echo '<div id="site-branding" class="site-branding">';
			if($header_display != 'header_text'){
				eventsia_the_custom_logo();
			}
			echo '<div id="site-detail">';
				if (is_home() || is_front_page()){ ?>
				<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
				<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				<?php if(is_home() || is_front_page()){ ?>
				</h1>  <!-- end .site-title -->
				<?php } else { ?> </h2> <!-- end .site-title --> <?php }

				$site_description = get_bloginfo( 'description', 'display' );
				if ($site_description){?>
					<div id="site-description"> <?php bloginfo('description');?> </div> <!-- end #site-description -->
			
		<?php }
		echo '</div></div>'; // end #site-branding
		}
	}
}

add_action('eventsia_site_branding','eventsia_header_display');

if ( ! function_exists( 'eventsia_the_custom_logo' ) ) : 
 	/** 
 	 * Displays the optional custom logo. 
 	 * Does nothing if the custom logo is not available. 
 	 */ 
 	function eventsia_the_custom_logo() { 
		if ( function_exists( 'the_custom_logo' ) ) {

			the_custom_logo();

		}
 	} 
endif;