<?php
/**
 * Displays the searchform
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */
?>
<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">

	<label class="screen-reader-text"><?php esc_html_e('Search','eventsia'); ?></label>
	<?php
		$eventsia_settings = eventsia_get_theme_options();
		$eventsia_search_form = $eventsia_settings['eventsia_search_text'];?>
		<input type="search" name="s" class="search-field" placeholder="<?php echo esc_attr($eventsia_search_form); ?>" autocomplete="off" />
		<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>

</form> <!-- end .search-form -->