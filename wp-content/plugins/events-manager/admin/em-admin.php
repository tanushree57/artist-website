<?php
//Admin functions
function em_admin_menu(){
	global $menu, $submenu, $pagenow;
	//Count pending bookings	
   	if( get_option('dbem_rsvp_enabled') ){
		$bookings_num = '';
		$bookings_pending_count = apply_filters('em_bookings_pending_count',0);
		if( get_option('dbem_bookings_approval') == 1){ 
			$bookings_pending_count += EM_Bookings::count(array('status'=>'0', 'blog'=>get_current_blog_id()));
		}
		if($bookings_pending_count > 0){
			$bookings_num = '<span class="update-plugins count-'.$bookings_pending_count.'"><span class="plugin-count">'.$bookings_pending_count.'</span></span>';
		}
   	}else{
   		$bookings_num = '';
		$bookings_pending_count = 0;
   	}
	//Count pending events
	$events_num = '';
	$events_pending_count = EM_Events::count(array('status'=>0, 'scope'=>'all', 'blog'=>get_current_blog_id()));
	//TODO Add flexible permissions
	if($events_pending_count > 0){
		$events_num = '<span class="update-plugins count-'.$events_pending_count.'"><span class="plugin-count">'.$events_pending_count.'</span></span>';
	}
	//Count pending recurring events
	$events_recurring_num = '';
	$events_recurring_pending_count = EM_Events::count(array('status'=>0, 'recurring'=>1, 'scope'=>'all', 'blog'=>get_current_blog_id()));
	//TODO Add flexible permissions
	if($events_recurring_pending_count > 0){
		$events_recurring_num = '<span class="update-plugins count-'.$events_recurring_pending_count.'"><span class="plugin-count">'.$events_recurring_pending_count.'</span></span>';
	}
	$both_pending_count = apply_filters('em_items_pending_count', $events_pending_count + $bookings_pending_count + $events_recurring_pending_count);
	$both_num = ($both_pending_count > 0) ? '<span class="update-plugins count-'.$both_pending_count.'"><span class="plugin-count">'.$both_pending_count.'</span></span>':'';
  	// Add a submenu to the custom top-level menu:
   	$plugin_pages = array();
   	if( get_option('dbem_rsvp_enabled') ){
		$plugin_pages['bookings'] = add_submenu_page('edit.php?post_type='.EM_POST_TYPE_EVENT, __('Bookings', 'events-manager'), __('Bookings', 'events-manager').$bookings_num, 'manage_bookings', 'events-manager-bookings', "em_bookings_page");
   	}
	$plugin_pages['options'] = add_submenu_page('edit.php?post_type='.EM_POST_TYPE_EVENT, __('Events Manager Settings','events-manager'),__('Settings','events-manager'), 'manage_options', "events-manager-options", 'em_admin_options_page');
	$plugin_pages['help'] = add_submenu_page('edit.php?post_type='.EM_POST_TYPE_EVENT, __('Getting Help for Events Manager','events-manager'),__('Help','events-manager'), 'manage_options', "events-manager-help", 'em_admin_help_page');
	//If multisite global with locations set to be saved in main blogs we can force locations to be created on the main blog only
	if( EM_MS_GLOBAL && !is_main_site() && get_site_option('dbem_ms_mainblog_locations') ){
		include( dirname(__FILE__)."/em-ms-locations.php" );
		$plugin_pages['locations'] = add_submenu_page('edit.php?post_type='.EM_POST_TYPE_EVENT, __('Locations','events-manager'),__('Locations','events-manager'), 'read_others_locations', "locations", 'em_admin_ms_locations');
	}
	$plugin_pages = apply_filters('em_create_events_submenu',$plugin_pages);
	//We have to modify the menus manually
	if( !empty($both_num) ){ //Main Event Menu
		//go through the menu array and modify the events menu if found
		foreach ( (array)$menu as $key => $parent_menu ) {
			if ( $parent_menu[2] == 'edit.php?post_type='.EM_POST_TYPE_EVENT ){
				$menu[$key][0] = $menu[$key][0]. $both_num;
				break;
			}
		}
	}
	if( !empty($events_num) && !empty($submenu['edit.php?post_type='.EM_POST_TYPE_EVENT]) ){ //Submenu Event Item
		//go through the menu array and modify the events menu if found
		foreach ( (array)$submenu['edit.php?post_type='.EM_POST_TYPE_EVENT] as $key => $submenu_item ) {
			if ( $submenu_item[2] == 'edit.php?post_type='.EM_POST_TYPE_EVENT ){
				$submenu['edit.php?post_type='.EM_POST_TYPE_EVENT][$key][0] = $submenu['edit.php?post_type='.EM_POST_TYPE_EVENT][$key][0]. $events_num;
				break;
			}
		}
	}
	if( !empty($events_recurring_num) && !empty($submenu['edit.php?post_type='.EM_POST_TYPE_EVENT]) ){ //Submenu Recurring Event Item
		//go through the menu array and modify the events menu if found
		foreach ( (array)$submenu['edit.php?post_type='.EM_POST_TYPE_EVENT] as $key => $submenu_item ) {
			if ( $submenu_item[2] == 'edit.php?post_type=event-recurring' ){
				$submenu['edit.php?post_type='.EM_POST_TYPE_EVENT][$key][0] = $submenu['edit.php?post_type='.EM_POST_TYPE_EVENT][$key][0]. $events_recurring_num;
				break;
			}
		}
	}
	/* Hack! Add location/recurrence isn't possible atm so this is a workaround */
	global $_wp_submenu_nopriv;
	if( $pagenow == 'post-new.php' && !empty($_REQUEST['post_type']) ){
		if( $_REQUEST['post_type'] == EM_POST_TYPE_LOCATION && !empty($_wp_submenu_nopriv['edit.php']['post-new.php']) && current_user_can('edit_locations') ){
			unset($_wp_submenu_nopriv['edit.php']['post-new.php']);
		}
		if( $_REQUEST['post_type'] == 'event-recurring' && !empty($_wp_submenu_nopriv['edit.php']['post-new.php']) && current_user_can('edit_recurring_events') ){
			unset($_wp_submenu_nopriv['edit.php']['post-new.php']);
		}
	}
}
add_action('admin_menu','em_admin_menu');

function em_admin_dashicon(){
	?>
	<style type="text/css">
		@font-face {
		  font-family: 'em_dashicons';
		  src: url('<?php echo EM_DIR_URI; ?>includes/fonts/em-dashicons.eot'); // this is for IE
		}
		@font-face {
		  font-family: 'em_dashicons';
		  src: url(data:application/font-woff;charset=utf-8;base64,d09GRk9UVE8AAAVIAAoAAAAABQAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAABDRkYgAAAA9AAAAb8AAAG/+vk+uU9TLzIAAAK0AAAAYAAAAGAIIvy2Y21hcAAAAxQAAABMAAAATBpVzFdnYXNwAAADYAAAAAgAAAAIAAAAEGhlYWQAAANoAAAANgAAADYBZ6hBaGhlYQAAA6AAAAAkAAAAJAPIAeZobXR4AAADxAAAABQAAAAUAwAAM21heHAAAAPYAAAABgAAAAYABVAAbmFtZQAAA+AAAAFFAAABRVcZpu5wb3N0AAAFKAAAACAAAAAgAAMAAAEABAQAAQEBCGljb21vb24AAQIAAQA6+BwC+BsD+BgEHgoAGVP/i4seCgAZU/+LiwwHi2v4lPh0BR0AAAB2Dx0AAAB7ER0AAAAJHQAAAbYSAAYBAQgPERMWG2ljb21vb25pY29tb29udTB1MXUyMHVFNjAwAAACAYkAAwAFAgABAAQABwAKAA0BLfyUDvyUDvyUDvuUDvcu+FoVfIuAgIt9CItYBYt8loCai5mLlpaLmgiLvgWLmYCWfYsI93qLFX2Lf4CLfQiLWAWLfJeAmYuZi5eWi5oIi74Fi5l/ln2LCPth+0cVi1hYi4u+vosFpYsVvouLWFiLi74F2IsVvouLWFiLi74F14sVv4uLWFeLi74Fiz4VvouLWFiLi74FPosVv4uLWFeLi74FPosVv4uLWFeLi74FP4sVvouLWFiLi74F1z8Vv4uLV1eLi78F2IsVv4uLV1eLi78F9y33ihWGc3d5cotui3Wii6gIi5cFdI91jXiLd4t1iXWHCIt+BYtvdHRui3KLd52Go2yCdoSLi4uLi2eLfIv7lfduWYuLi4v3bb2L95WLmYuwi4uLi3aSbJQIDviUFPiUFYsMCgAAAwIAAZAABQAAAUwBZgAAAEcBTAFmAAAA9QAZAIQAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAAAAAAAAAAAABAAADmAAHg/+D/4AHgACAAAAABAAAAAAAAAAAAAAAgAAAAAAACAAAAAwAAABQAAwABAAAAFAAEADgAAAAKAAgAAgACAAEAIOYA//3//wAAAAAAIOYA//3//wAB/+MaBAADAAEAAAAAAAAAAAAAAAEAAf//AA8AAQAAAAEAAIXyBpNfDzz1AAsCAAAAAADQMTPCAAAAANAxM8IAAP/6AeYBxgAAAAgAAgAAAAAAAAABAAAB4P/gAAACAAAAAAAB5gABAAAAAAAAAAAAAAAAAAAABQAAAAAAAAAAAAAAAAEAAAACAAAzAABQAAAFAAAAAAAOAK4AAQAAAAAAAQAOAAAAAQAAAAAAAgAOAEcAAQAAAAAAAwAOACQAAQAAAAAABAAOAFUAAQAAAAAABQAWAA4AAQAAAAAABgAHADIAAQAAAAAACgA0AGMAAwABBAkAAQAOAAAAAwABBAkAAgAOAEcAAwABBAkAAwAOACQAAwABBAkABAAOAFUAAwABBAkABQAWAA4AAwABBAkABgAOADkAAwABBAkACgA0AGMAaQBjAG8AbQBvAG8AbgBWAGUAcgBzAGkAbwBuACAAMQAuADAAaQBjAG8AbQBvAG8Abmljb21vb24AaQBjAG8AbQBvAG8AbgBSAGUAZwB1AGwAYQByAGkAYwBvAG0AbwBvAG4ARgBvAG4AdAAgAGcAZQBuAGUAcgBhAHQAZQBkACAAYgB5ACAASQBjAG8ATQBvAG8AbgAuAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=) format('woff'), 
		    url(data:application/x-font-ttf;charset=utf-8;base64,AAEAAAALAIAAAwAwT1MvMggi/LYAAAC8AAAAYGNtYXAaVcxXAAABHAAAAExnYXNwAAAAEAAAAWgAAAAIZ2x5ZsaoTWEAAAFwAAACFGhlYWQBZ6hBAAADhAAAADZoaGVhA8gB5gAAA7wAAAAkaG10eAMAADMAAAPgAAAAFGxvY2EAKAEeAAAD9AAAAAxtYXhwABMAowAABAAAAAAgbmFtZVcZpu4AAAQgAAABRXBvc3QAAwAAAAAFaAAAACAAAwIAAZAABQAAAUwBZgAAAEcBTAFmAAAA9QAZAIQAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAAAAAAAAAAAABAAADmAAHg/+D/4AHgACAAAAABAAAAAAAAAAAAAAAgAAAAAAACAAAAAwAAABQAAwABAAAAFAAEADgAAAAKAAgAAgACAAEAIOYA//3//wAAAAAAIOYA//3//wAB/+MaBAADAAEAAAAAAAAAAAAAAAEAAf//AA8AAQAAAAAAAAAAAAIAADc5AQAAAAABAAAAAAAAAAAAAgAANzkBAAAAAAEAAAAAAAAAAAACAAA3OQEAAAAADQAz//oB5gHGABoANQA6AD8ARABJAE4AUwBYAF0AYgBnAKAAABMiBgcOAQcXBhYXHgEzMjY3PgE3JzYmJy4BIzMiBgcOARcHHgEXHgEzMjY3PgEnNy4BJy4BIwcXIzczOwEXIzc7AQcjJzsBFyM3BzMHIycjMxcjNyMzByMnIzMXIzcXMwcjJzsBFyM3Nw4BBw4BIyImJy4BJzcuASciJiMiBiMOAQ8BFgYHDgEjIiYnLgEnDgEzIhYHHgEzIjYnNiYzIiYnmgUKAgUDAQEBBQMECAcECgMEAwEBAQUCBQgG5wYJBAMFAQEBAwUCCwQGCQQDBQEBAQMFAgsEzgE0ATIbMgE0AUw0ATIBTTMBNQEBNAEyAUwzATUBTjUBMwFLMgE0AUs1ATMBTjMBNQGYAQoGBxAKChQFCAcBAQoPCQcRBgkOCQgRBwEBCgUIEgwIEgUICAMWHgEBAQEB2QEB2gEBAQEBHBgBxgQDBAkFMwYJBAMEBAMECQYzBQkEAwQEAwQJBTMGCQQDBAQDBAkGMwUJBAMEszMzMzMzMzMzTTMzMzMzMzMzTDQ0NDT2CQ8GBQcIBwcTCwwCAgEBAQECAg0KEwcHCAcFBg8JBwkoC8FycsELKAkHAAEAAAABAACs5UCKXw889QALAgAAAAAA0DEzwgAAAADQMTPCAAD/+gHmAcYAAAAIAAIAAAAAAAAAAQAAAeD/4AAAAgAAAAAAAeYAAQAAAAAAAAAAAAAAAAAAAAUAAAAAAAAAAAAAAAABAAAAAgAAMwAAAAAACgAUAB4BCgABAAAABQChAA0AAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEADgAAAAEAAAAAAAIADgBHAAEAAAAAAAMADgAkAAEAAAAAAAQADgBVAAEAAAAAAAUAFgAOAAEAAAAAAAYABwAyAAEAAAAAAAoANABjAAMAAQQJAAEADgAAAAMAAQQJAAIADgBHAAMAAQQJAAMADgAkAAMAAQQJAAQADgBVAAMAAQQJAAUAFgAOAAMAAQQJAAYADgA5AAMAAQQJAAoANABjAGkAYwBvAG0AbwBvAG4AVgBlAHIAcwBpAG8AbgAgADEALgAwAGkAYwBvAG0AbwBvAG5pY29tb29uAGkAYwBvAG0AbwBvAG4AUgBlAGcAdQBsAGEAcgBpAGMAbwBtAG8AbwBuAEYAbwBuAHQAIABnAGUAbgBlAHIAYQB0AGUAZAAgAGIAeQAgAEkAYwBvAE0AbwBvAG4ALgAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA) format('truetype');
		  font-weight: normal;
		  font-style: normal;
		}
		.menu-icon-event .dashicons-calendar:before, #toplevel_page_events-manager-options .dashicons-calendar:before {
		  font-family: 'em_dashicons';
		  content: '\e600';
		}
	</style>
	<?php
}
add_action('admin_head','em_admin_dashicon');

function em_ms_admin_menu(){
	add_menu_page( __('Events Manager','events-manager'), __('Events Manager','events-manager'), 'activate_plugins', 'events-manager-options', 'em_ms_admin_options_page', 'dashicons-calendar' );
	add_submenu_page('events-manager-options', __('Update Blogs','events-manager'),__('Update Blogs','events-manager'), 'activate_plugins', "events-manager-update", 'em_ms_upgrade');
}
add_action('network_admin_menu','em_ms_admin_menu');

function em_admin_init(){
	//in MS global mode and locations are stored in the main blog, then a user must have at least a subscriber role
	if( EM_MS_GLOBAL && is_user_logged_in() && !is_main_site() && get_site_option('dbem_ms_mainblog_locations') ){
		EM_Object::ms_global_switch();
		$user = new WP_User(get_current_user_id());
		if( count($user->roles) == 0 ){
			$user->set_role('subscriber');
		}
		EM_Object::ms_global_switch_back();
	}
}
add_action('admin_init','em_admin_init');

/**
 * Generate warnings and notices in the admin area
 */
function em_admin_warnings() {
	global $EM_Notices;
	//If we're editing the events page show hello to new user
	$events_page_id = get_option ( 'dbem_events_page' );
	$dismiss_link_joiner = ( count($_GET) > 0 ) ? '&amp;':'?';
	
	if( current_user_can('activate_plugins') ){
		//New User Intro
		if (isset ( $_GET ['disable_hello_to_user'] ) && $_GET ['disable_hello_to_user'] == 'true'){
			// Disable Hello to new user if requested
			update_option('dbem_hello_to_user',0);
		}elseif ( get_option ( 'dbem_hello_to_user' ) ) {
			//FIXME update welcome msg with good links
			$advice = sprintf( __("<p>Events Manager is ready to go! It is highly recommended you read the <a href='%s'>Getting Started</a> guide on our site, as well as checking out the <a href='%s'>Settings Page</a>. <a href='%s' title='Don't show this advice again'>Dismiss</a></p>", 'events-manager'), 'http://wp-events-plugin.com/documentation/getting-started-guide/?utm_source=em&utm_medium=plugin&utm_content=installationlink&utm_campaign=plugin_links', EM_ADMIN_URL .'&amp;page=events-manager-options', esc_url($_SERVER['REQUEST_URI'].$dismiss_link_joiner.'disable_hello_to_user=true'));
			?>
			<div id="message" class="updated">
				<?php echo $advice; ?>
			</div>
			<?php
		}
	
		//If events page couldn't be created or is missing
		if( !empty($_GET['em_dismiss_events_page']) ){
			update_option('dbem_dismiss_events_page',1);
		}else{
			if ( !get_page($events_page_id) && !get_option('dbem_dismiss_events_page') ){
				?>
				<div id="em_page_error" class="updated">
					<p><?php echo sprintf ( __( 'Uh Oh! For some reason WordPress could not create an events page for you (or you just deleted it). Not to worry though, all you have to do is create an empty page, name it whatever you want, and select it as your events page in your <a href="%s">settings page</a>. Sorry for the extra step! If you know what you are doing, you may have done this on purpose, if so <a href="%s">ignore this message</a>', 'events-manager'), EM_ADMIN_URL .'&amp;page=events-manager-options', esc_url($_SERVER['REQUEST_URI'].$dismiss_link_joiner.'em_dismiss_events_page=1') ); ?></p>
				</div>
				<?php
			}
		}
	
		if( is_multisite() && !empty($_REQUEST['page']) && $_REQUEST['page']=='events-manager-options' && em_wp_is_super_admin() && get_option('dbem_ms_update_nag') ){
			if( !empty($_GET['disable_dbem_ms_update_nag']) ){
				delete_site_option('dbem_ms_update_nag');
			}else{
				?>
				<div id="em_page_error" class="updated">
					<p><?php echo sprintf(__('MultiSite options have moved <a href="%s">here</a>. <a href="%s">Dismiss message</a>','events-manager'),admin_url().'network/admin.php?page=events-manager-options', esc_url($_SERVER['REQUEST_URI'].'&amp;disable_dbem_ms_update_nag=1')); ?></p>
				</div>
				<?php
			}
		}
		if( !empty($_REQUEST['page']) && 'events-manager-options' == $_REQUEST['page'] && get_option('dbem_pro_dev_updates') == 1 ){
			?>
			<div id="message" class="updated">
				<p><?php echo sprintf(__('Dev Mode active: Just a friendly reminder that you are updating to development versions. Only admins see this message, and it will go away when you disable this <a href="#pro-api">here</a> in your settings.','events-manager'),'<code>define(\'EMP_DEV_UPDATES\',true);</code>'); ?></p>
			</div>
			<?php
		}
		if( class_exists('SitePress') && !class_exists('EM_WPML') && !get_site_option('disable_em_wpml_warning') ){
			if( !empty($_REQUEST['disable_em_wpml_warning']) ){
				update_site_option('disable_em_wpml_warning',1);
			}else{
				?>
				<div id="message" class="updated">
					<p><?php echo sprintf(__('It looks like you have WPML enabled on your site. We advise you also install our extra <a href="%s">Events Manager WPML Connector</a> plugin which helps the two work better together. <a href="%s">Dismiss message</a>','events-manager'),'http://wordpress.org/extend/plugins/events-manager-wpml/', esc_url(add_query_arg(array('disable_em_wpml_warning'=>1)))); ?></p>
				</div>
				<?php
			}
		}
		if( array_key_exists('dbem_disable_timthumb', wp_load_alloptions()) ){
			if( !empty($_REQUEST['dbem_disable_timthumb']) ){
				delete_option('dbem_disable_timthumb',1);
			}else{
				?>
				<div id="message" class="updated">
					<p>We have stopped using TimThumb for thumbnails in Events Manager, <a href="http://wp-events-plugin.com/blog/2014/12/05/bye-timthumb/">please see this post</a> for more information on how this may affect you and what options are available to you. <a href="<?php echo esc_url(add_query_arg(array('dbem_disable_timthumb'=>1))); ?>">Dismiss</a></p>
				</div>
				<?php
			}		    
		}
	}
	//Warn about EM page edit
	if ( preg_match( '/(post|page).php/', $_SERVER ['SCRIPT_NAME']) && isset ( $_GET ['action'] ) && $_GET ['action'] == 'edit' && isset ( $_GET ['post'] ) && $_GET ['post'] == "$events_page_id") {
		$message = sprintf ( __ ( "This page corresponds to the <strong>Events Manager</strong> %s page. Its content will be overridden by Events Manager, although if you include the word CONTENTS (exactly in capitals) and surround it with other text, only CONTENTS will be overwritten. If you want to change the way your events look, go to the <a href='%s'>settings</a> page. ", 'events-manager'), __('Events','events-manager'), EM_ADMIN_URL .'&amp;page=events-manager-options' );
		$notice = "<div class='error'><p>$message</p></div>";
		echo $notice;
	}
	echo $EM_Notices;		
}
add_action ( 'admin_notices', 'em_admin_warnings', 100 );

/**
 * Settings link in the plugins page menu
 * @param array $links
 * @param string $file
 * @return array
 */
function em_plugin_action_links($actions, $file, $plugin_data) {
	$new_actions = array();
	$new_actions[] = sprintf( '<a href="'.EM_ADMIN_URL.'&amp;page=events-manager-options">%s</a>', __('Settings', 'events-manager') );
	$new_actions = array_merge($new_actions, $actions);
	if( is_multisite() ){
		$uninstall_url = admin_url().'network/admin.php?page=events-manager-options&amp;action=uninstall&amp;_wpnonce='.wp_create_nonce('em_uninstall_'.get_current_user_id().'_wpnonce');
	}else{
		$uninstall_url = EM_ADMIN_URL.'&amp;page=events-manager-options&amp;action=uninstall&amp;_wpnonce='.wp_create_nonce('em_uninstall_'.get_current_user_id().'_wpnonce');
	}
	$new_actions[] = '<span class="delete"><a href="'.$uninstall_url.'" class="delete">'.__('Uninstall','events-manager').'</a></span>';
	return $new_actions;
}
add_filter( 'plugin_action_links_events-manager/events-manager.php', 'em_plugin_action_links', 10, 3 );

//Updates and Dev versions
function em_updates_check( $transient ) {
    // Check if the transient contains the 'checked' information
    if( empty( $transient->checked ) )
        return $transient;
        
    //only bother if we're checking for dev versions
    if( get_option('em_check_dev_version') || get_option('dbem_pro_dev_updates') ){     
	    //check WP repo for trunk version, other EM-related plugins on .org can hook here to make the best of our admin setting option
	    $plugins = apply_filters('em_org_dev_versions', array(
	    	'events-manager'=> array(
	    		'slug' => EM_SLUG,
			    'version' => EM_VERSION
		    )
		));
	    foreach( $plugins as $org_slug => $plugin_info ) {
		    $request = wp_remote_get('https://plugins.svn.wordpress.org/'.$org_slug.'/trunk/'.$org_slug.'.php');
		    $wp_slug = $plugin_info['slug'];
		    if( empty($transient->checked[$wp_slug]) ){
			    $transient->checked[$wp_slug] = !empty($plugin_info['version']) ? $plugin_info['version'] : 0;
		    }
		    if (!is_wp_error($request)) {
			    preg_match('/Version: ([0-9a-z\.]+)/', $request['body'], $matches);
			
			    if (!empty($matches[1])) {
				    //we have a version number!
				    $response = new stdClass();
				    $response->slug = $wp_slug;
				    $response->new_version = $matches[1];
				    $response->url = 'http://wordpress.org/extend/plugins/'.$org_slug.'/';
				    $response->package = 'http://downloads.wordpress.org/plugin/'.$org_slug.'.zip';
				    $icon_test = wp_remote_get('https://ps.w.org/'.$org_slug.'/assets/icon-128x128.png');
				    if( !is_wp_error($icon_test) && $icon_test['response']['code'] == 200 ){
					    $response->icons = array(
					        '1x' => 'https://ps.w.org/'.$org_slug.'/assets/icon-128x128.png',
					        '2x' => 'https://ps.w.org/'.$org_slug.'/assets/icon-256x256.png'
					    );
					}
				    if ( version_compare($transient->checked[$wp_slug], $matches[1]) < 0) {
					    $transient->response[$wp_slug] = $response;
				    }else{
					    $transient->no_update[$wp_slug] = $response;
				    }
			    }
		    }
	    }
		delete_option('em_check_dev_version');
    }
    
    return $transient;
}
add_filter('pre_set_site_transient_update_plugins', 'em_updates_check', 100); // Hook into the plugin update check and mod for dev version

function em_user_action_links( $actions, $user ){
	if ( !is_network_admin() && current_user_can( 'manage_others_bookings' ) ){
		if( get_option('dbem_edit_bookings_page') && (!is_admin() || !empty($_REQUEST['is_public'])) ){
			$my_bookings_page = get_permalink(get_option('dbem_edit_bookings_page'));
			$bookings_link = em_add_get_params($my_bookings_page, array('person_id'=>$user->ID), false);
		}else{
			$bookings_link = EM_ADMIN_URL. "&page=events-manager-bookings&person_id=".$user->ID;
		}
		$actions['bookings'] = "<a href='$bookings_link'>" . __( 'Bookings','events-manager') . "</a>";
	}
	return $actions;
}
add_filter('user_row_actions','em_user_action_links',10,2);

// admin modal notices
class EM_Admin_Modals {
	
	public static $output_js = false;
	
	public static function init() {
		add_filter('admin_enqueue_scripts', 'EM_Admin_Modals::admin_enqueue_scripts', 100);
		add_filter('wp_ajax_em-admin-popup-modal', 'EM_Admin_Modals::ajax');
	}
	
	public static function admin_enqueue_scripts(){
		if( !current_user_can('update_plugins') ) return;
		// show promotion
		$data = is_multisite() ? get_site_option('dbem_data') : get_option('dbem_data');
		if( !empty($data['admin-modals']) ){
			$show_plugin_pages = !empty($_REQUEST['post_type']) && in_array($_REQUEST['post_type'], array(EM_POST_TYPE_EVENT, EM_POST_TYPE_LOCATION, 'event-recurring'));
			$show_network_admin = is_network_admin() && !empty($_REQUEST['page']) && preg_match('/^events\-manager\-/', $_REQUEST['page']);
			$pro_license_active = defined('EMP_VERSION');
			if( $pro_license_active ){
				$key = get_option('dbem_pro_api_key');
				$pro_license_active = !(empty($key['until']) || $key['until'] < 1668240000);
			}
			if( time() < 1668067200 && !empty($data['admin-modals']['promo-popup']) && !$pro_license_active) {
				if( $data['admin-modals']['promo-popup'] == 1 || ($data['admin-modals']['promo-popup'] == 2 && ($show_plugin_pages || $show_network_admin) ) ) {
					// enqueue script and load popup action
					if( !wp_script_is('events-manager-admin') ) EM_Scripts_and_Styles::admin_enqueue(true);
					add_filter('admin_footer', 'EM_Admin_Modals::promo_popup');
				}
			}
			// show review nudge
			if( !empty($data['admin-modals']['review-nudge']) && $data['admin-modals']['review-nudge'] < time() ) {
				if( $show_plugin_pages || $show_network_admin ) {
					// enqueue script and load popup action
					if( !wp_script_is('events-manager-admin') ) EM_Scripts_and_Styles::admin_enqueue(true);
					add_filter('admin_footer', 'EM_Admin_Modals::review_popup');
				}
			}
		}
	}
	
	public static function review_popup(){
		// check admin data and see if show data is still enabled
		?>
		<div class="em pixelbones em-modal <?php em_template_classes('search', 'search-advanced'); ?> em-admin-modal" id="em-review-nudge" data-nonce="<?php echo wp_create_nonce('em-review-nudge'); ?>">
			<div class="em-modal-popup">
				<header>
					<div class="em-modal-title"><?php esc_html_e('Enjoying Events Manager? Help Us Improve!', 'events-manager'); ?></div>
				</header>
				<div class="em-modal-content has-image">
					<div>
						<p><?php esc_html_e('Pardon the interruption... we hope you\'re enjoying Events Manager, and if so, we\'d really appreciate a positive review on the wordpress.org repository!', 'events-manager'); ?></p>
						<p><?php esc_html_e('Events Manager has been maintained, developed and supported for free since it was released in 2008, positive reviews are one that help us keep going.', 'events-manager'); ?></p>
						<p><?php esc_html_e('If you could spare a few minutes, we would appreciate it if you could please leave us a review.', 'events-manager'); ?></p>
					</div>
					<div class="image">
						<img src="<?php echo EM_DIR_URI . '/includes/images/star-halo.svg'; ?>" style="width:75%; opacity:0.7;">
						<img src="<?php echo EM_DIR_URI . '/includes/images/events-manager.svg'; ?>">
					</div>
				</div><!-- content -->
				<footer class="em-submit-section input">
					<div>
						<button class="button button-secondary dismiss-modal"><?php esc_html_e('Dismiss Message', 'events-manager'); ?></button>
					</div>
					<div>
						<a href="https://wordpress.org/support/plugin/events-manager/reviews/?filter=5#new-topic-0" class="button button-primary input" target="_blank" style="margin:10px auto; --accent-color:#429543; --accent-color-hover:#429543;">
							Leave a Review
							<img src="<?php echo EM_DIR_URI . '/includes/images/five-stars.svg'; ?>" style="max-height:10px; width:50px; margin-left:5px;">
						</a>
					</div>
				</footer>
			</div><!-- modal -->
		</div>
		<?php
		static::output_js();
	}
	
	public static function promo_popup(){
		// check admin data and see if show data is still enabled
		?>
		<div class="em pixelbones em-modal <?php em_template_classes('search', 'search-advanced'); ?> em-admin-modal" id="em-promo-popup" data-nonce="<?php echo wp_create_nonce('em-promo-popup'); ?>">
			<div class="em-modal-popup">
				<header>
					<a class="em-close-modal dismiss-modal" href="#"></a><!-- close modal -->
					<div class="em-modal-title">Events Manager - Prices going up this week!</div>
				</header>
				<div class="em-modal-content has-image" style="--font-size:16px;">
					<div>
						<p>Pardon the interruption.... we'd like to make sure you're aware of an important announcement about our prices of the <a href="https://eventsmanagerpro.com/?utm_source=events-manager&utm_medium=plugin-popup&utm_campaign=plugins" target="_blank">Events Manager Pro</a> add-on.</p>
						<p>On <strong><em>November 10th 2022</em></strong>, we'll be increasing our prices <em>for the first time ever</em> since we first released Pro in 2010.</p>
						<p><strong>Any licenses purchased before the price change will lock in the current price for renewing your license, which is why we're letting you know now.</strong></p>
						<p>We hope you're enjoying the plugin and if you're at all considering going Pro, you still have time to make the best of this limited opportunity!</p>
						<p><a href="https://wp-events-plugin.com/upcoming-price-increase-2022/?utm_source=events-manager&utm_medium=plugin-popup&utm_campaign=plugins" target="_blank">View the full announement here.</a></p>
					</div>
					<div class="image">
						<img src="<?php echo EM_DIR_URI . '/includes/images/events-manager.svg'; ?>">
						<a href="https://eventsmanagerpro.com/gopro/?utm_source=events-manager&utm_medium=plugin-popup&utm_campaign=plugins" class="button button-primary input" target="_blank" style="margin:10px auto; --accent-color:#429543; --accent-color-hover:#429543;">Go Pro!</a>
					</div>
				</div><!-- content -->
				<footer class="em-submit-section input">
					<div>
					</div>
					<div>
						<button class="button button-secondary dismiss-modal">Dismiss Notice</button>
					</div>
				</footer>
			</div><!-- modal -->
		</div>
		<?php
		static::output_js();
	}
	
	public static function output_js(){
		if( !static::$output_js ){
			?>
			<script>
				jQuery(document).ready(function($){
					$('.em-admin-modal').each( function(){
						let modal = $(this);
						let ignore_event = false;
						openModal( modal );
						modal.on('em_modal_close', function(){
							// send AJAX to close
							if( ignore_event ) return false;
							$.post( EM.ajaxurl, { action : 'em-admin-popup-modal', 'dismiss':'close', 'modal':modal.attr('id'), 'nonce': modal.attr('data-nonce') });
						});
						modal.find('button.dismiss-modal').on('click', function(){
							// send AJAX to close
							ignore_event = true;
							closeModal(modal);
							$.post( EM.ajaxurl, { action : 'em-admin-popup-modal', 'dismiss':'button', 'modal':modal.attr('id'), 'nonce':modal.attr('data-nonce') });
						});
					});
				});
			</script>
			<?php
			static::$output_js = true;
		}
	}
	
	public static function ajax(){
		if( !empty($_REQUEST['modal']) && wp_verify_nonce($_REQUEST['nonce'], $_REQUEST['modal']) ){
			$action = sanitize_key( preg_replace('/^em\-/', '', $_REQUEST['modal']) );
			$data = is_multisite() ? get_site_option('dbem_data') : get_option('dbem_data');
			if( $_REQUEST['dismiss'] == 'button' || $data['admin-modals'][$action] === 2 ) {
				// disable the modal so it's not shown again
				unset($data['admin-modals'][$action]);
				is_multisite() ? update_site_option('dbem_data', $data) : update_option('dbem_data', $data);
			}else{
				// limit popup to EM pages only
				$data['admin-modals'][$action] = 2;
				is_multisite() ? update_site_option('dbem_data', $data) : update_option('dbem_data', $data);
			}
		}
	}
}
EM_Admin_Modals::init();
?>