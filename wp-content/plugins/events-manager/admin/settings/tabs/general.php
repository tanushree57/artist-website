<?php if( !function_exists('current_user_can') || !current_user_can('manage_options') ) return; ?>
<!-- GENERAL OPTIONS -->
<div class="em-menu-general em-menu-group">
	<div  class="postbox " id="em-opt-general"  >
	<div class="handlediv" title="<?php __('Click to toggle', 'events-manager'); ?>"><br /></div> <h3><span><?php _e ( 'General Options', 'events-manager'); ?> </span></h3>
	<div class="inside">
        <table class="form-table">
            <?php em_options_radio_binary ( __( 'Disable thumbnails?', 'events-manager'), 'dbem_thumbnails_enabled', __( 'Select yes to disable Events Manager from enabling thumbnails (some themes may already have this enabled, which we cannot be turned off here).','events-manager') );  ?>					
			<tr class="em-header">
				<td colspan="2">
					<h4><?php echo sprintf(__('%s Settings','events-manager'),__('Event','events-manager')); ?></h4>
				</td>
			</tr>
			<?php
			em_options_radio_binary ( __( 'Enable Timezone Support?', 'events-manager'), 'dbem_timezone_enabled', sprintf(__( 'Each event can have its own timezone if enabled. If set to no, then all newly created events will have the blog timezone, which currently is set to %s','events-manager'), '<code>'.EM_DateTimeZone::create()->getName().'</code>'), '', '.event-timezone-option' );
			?>
			<tr class="event-timezone-option">
				<th>
					<label for="event-timezone"><?php esc_html_e('Default Timezone', 'events-manager'); ?></label>
				</th>
				<td>
					<select id="event-timezone" name="dbem_timezone_default">
						<?php echo wp_timezone_choice( get_option('dbem_timezone_default') ); ?>
					</select><br />
					<i><?php esc_html_e('When creating a new event, this timezone will be applied by default.','events-manager'); ?></i>
				</td>
			</tr>
			<?php
			em_options_radio_binary ( __( 'Enable recurrence?', 'events-manager'), 'dbem_recurrence_enabled', __( 'Select yes to enable the recurrence features feature','events-manager') ); 
			em_options_radio_binary ( __( 'Enable bookings?', 'events-manager'), 'dbem_rsvp_enabled', __( 'Select yes to allow bookings and tickets for events.','events-manager') );     
			em_options_radio_binary ( __( 'Enable tags?', 'events-manager'), 'dbem_tags_enabled', __( 'Select yes to enable the tag features','events-manager') );
			if( !(EM_MS_GLOBAL && !is_main_site()) ){
				em_options_radio_binary ( __( 'Enable categories?', 'events-manager'), 'dbem_categories_enabled', __( 'Select yes to enable the category features','events-manager') );     
				if( get_option('dbem_categories_enabled') ){
					/*default category*/
					$category_options = array();
					$category_options[0] = __('no default category','events-manager');
					$EM_Categories = EM_Categories::get();
					foreach($EM_Categories as $EM_Category){
				 		$category_options[$EM_Category->id] = $EM_Category->name;
				 	}
				 	echo "<tr><th>".__( 'Default Category', 'events-manager')."</th><td>";
					wp_dropdown_categories(array( 'hide_empty' => 0, 'name' => 'dbem_default_category', 'hierarchical' => true, 'taxonomy' => EM_TAXONOMY_CATEGORY, 'selected' => get_option('dbem_default_category'), 'show_option_none' => __('None','events-manager'), 'class'=>''));
					echo "</br><em>" .__( 'This option allows you to select the default category when adding an event.','events-manager').' '.__('If an event does not have a category assigned when editing, this one will be assigned automatically.','events-manager')."</em>";
					echo "</td></tr>";
				}
			}
			em_options_radio_binary ( sprintf(__( 'Enable %s attributes?', 'events-manager'),__('event','events-manager')), 'dbem_attributes_enabled', __( 'Select yes to enable the attributes feature','events-manager') );
			em_options_radio_binary ( sprintf(__( 'Enable %s custom fields?', 'events-manager'),__('event','events-manager')), 'dbem_cp_events_custom_fields', __( 'Custom fields are the same as attributes, except you cannot restrict specific values, users can add any kind of custom field name/value pair. Only available in the WordPress admin area.','events-manager') );
			if( get_option('dbem_attributes_enabled') ){
				em_options_textarea ( sprintf(__( '%s Attributes', 'events-manager'),__('Event','events-manager')), 'dbem_placeholders_custom', sprintf(__( "You can also add event attributes here, one per line in this format <code>#_ATT{key}</code>. They will not appear on event pages unless you insert them into another template below, but you may want to store extra information about an event for other uses. <a href='%s'>More information on placeholders.</a>", 'events-manager'), EM_ADMIN_URL .'&amp;page=events-manager-help') );
			}
			?>
			<tr class="em-header">
				<td colspan="2">
					<h4><?php echo sprintf(__('%s Settings','events-manager'),__('Location','events-manager')); ?></h4>
				</td>
			</tr>
			<?php
			em_options_radio_binary ( __( 'Enable locations?', 'events-manager'), 'dbem_locations_enabled', __( 'If you disable locations, bear in mind that you should remove your location page, shortcodes and related placeholders from your <a href="#formats" class="nav-tab-link" rel="#em-menu-formats">formats</a>.','events-manager'), '', '.em-location-type-option' );
			?>
	        <tbody class="em-location-type-option">
		        <?php
		        em_options_radio_binary ( __( 'Require locations for events?', 'events-manager'), 'dbem_require_location', __( 'Setting this to no will allow you to submit events without locations. You can use the <code>{no_location}...{/no_location}</code> or <code>{has_location}..{/has_location}</code> conditional placeholder to selectively display location information.','events-manager') );
		        ?>
		        <tr valign="top" id='dbem_location_types_row'>
			        <th scope="row"><?php esc_html_e('Location Types', 'events-manager'); ?></th>
			        <td>
				        <?php
				        $location_types = get_option('dbem_location_types', array());
				        ?>
				        <label>
				            <input type="checkbox" name="dbem_location_types[location]" value="1" <?php if( !empty($location_types['location']) ) echo 'checked'; ?> data-trigger=".em-location-type-option-physical" class="em-trigger">
					        <?php esc_html_e('Physicial Locations', 'events-manager'); ?>
				        </label>
				        <?php foreach (EM_Event_Locations\Event_Locations::get_types() as $event_location_type => $EM_Event_Location_Class): /* @var EM_Event_Locations\Event_Location $EM_Event_Location_Class */ ?>
					        <br>
					        <label>
						        <input type="checkbox" name="dbem_location_types[<?php echo esc_attr($event_location_type); ?>]" value="1" <?php if( !empty($location_types[$event_location_type]) ) echo 'checked'; ?> data-trigger=".em-location-type-option-<?php echo esc_attr($event_location_type); ?>" class="em-trigger">
						        <?php echo $EM_Event_Location_Class::get_label('plural'); ?>
					        </label>
				        <?php endforeach; ?>
				        <p><em><?php echo sprintf( esc_html__('You can allow different location types which can be assigned to an event. For more information see our %s.', 'events-manager'), '<a href="http://wp-events-plugin.com/documentation/location-types/" target="_blank">'.esc_html__('documentation', 'events-manager').'</a>'); ?></em></p>
			        </td>
		        </tr>
	        </tbody>
        </table>
		<table class="form-table em-location-type-option">
	        <tbody class="em-location-type-option-physical">
		        <tr class="em-subheader">
			        <td colspan="2">
				        <h5><?php esc_html_e('Physicial Locations', 'events-manager'); ?></h5>
			        </td>
		        </tr>
		        <?php
				if( get_option('dbem_locations_enabled') ){
					em_options_radio_binary ( __( 'Use dropdown for locations?', 'events-manager'), 'dbem_use_select_for_locations', __( 'Select yes to select location from a drop-down menu; location selection will be faster, but you will lose the ability to insert locations with events','events-manager') );
					em_options_radio_binary ( sprintf(__( 'Enable %s attributes?', 'events-manager'),__('location','events-manager')), 'dbem_location_attributes_enabled', __( 'Select yes to enable the attributes feature','events-manager') );
					em_options_radio_binary ( sprintf(__( 'Enable %s custom fields?', 'events-manager'),__('location','events-manager')), 'dbem_cp_locations_custom_fields', __( 'Custom fields are the same as attributes, except you cannot restrict specific values, users can add any kind of custom field name/value pair. Only available in the WordPress admin area.','events-manager') );
					if( get_option('dbem_location_attributes_enabled') ){
						em_options_textarea ( sprintf(__( '%s Attributes', 'events-manager'),__('Location','events-manager')), 'dbem_location_placeholders_custom', sprintf(__( "You can also add location attributes here, one per line in this format <code>#_LATT{key}</code>. They will not appear on location pages unless you insert them into another template below, but you may want to store extra information about an event for other uses. <a href='%s'>More information on placeholders.</a>", 'events-manager'), EM_ADMIN_URL .'&amp;page=events-manager-help') );
					}
					/*default location*/
					if( defined('EM_OPTIMIZE_SETTINGS_PAGE_LOCATIONS') && EM_OPTIMIZE_SETTINGS_PAGE_LOCATIONS ){
						em_options_input_text( __( 'Default Location', 'events-manager'), 'dbem_default_location', __('Please enter your Location ID, or leave blank for no location.','events-manager').' '.__( 'This option allows you to select the default location when adding an event.','events-manager')." ".__('(not applicable with event ownership on presently, coming soon!)','events-manager') );
					}else{
						$location_options = array();
						$location_options[0] = __('no default location','events-manager');
						$EM_Locations = EM_Locations::get();
						foreach($EM_Locations as $EM_Location){
							$location_options[$EM_Location->location_id] = $EM_Location->location_name;
						}
						em_options_select ( __( 'Default Location', 'events-manager'), 'dbem_default_location', $location_options, __('Please enter your Location ID.','events-manager').' '.__( 'This option allows you to select the default location when adding an event.','events-manager')." ".__('(not applicable with event ownership on presently, coming soon!)','events-manager') );
					}
					
					/*default location country*/
					em_options_select ( __( 'Default Location Country', 'events-manager'), 'dbem_location_default_country', em_get_countries(__('no default country', 'events-manager')), __('If you select a default country, that will be pre-selected when creating a new location.','events-manager') );
				}
				?>
	        </tbody>
		</table>
		<table class="form-table">
			<tr class="em-header">
				<td colspan="2">
					<h4><?php echo sprintf(__('%s Settings','events-manager'),__('Other','events-manager')); ?></h4>
				</td>
			</tr>
			<?php
			em_options_radio_binary ( __('Show some love?','events-manager'), 'dbem_credits', __( 'Hundreds of free hours have gone into making this free plugin, show your support and add a small link to the plugin website at the bottom of your event pages.','events-manager') );
			echo $save_button;
			?>
		</table>
		    
	</div> <!-- . inside -->
	</div> <!-- .postbox -->
	
	<?php if ( !is_multisite() ){ em_admin_option_box_image_sizes(); } ?>
	
	<?php if ( !is_multisite() || (em_wp_is_super_admin() && !get_site_option('dbem_ms_global_caps')) ){ em_admin_option_box_caps(); } ?>

	<div  class="postbox" id="em-opt-google-maps" >
		<div class="handlediv" title="<?php __('Click to toggle', 'events-manager'); ?>"><br /></div><h3><span><?php _e ( 'Google Maps and Location Services', 'events-manager'); ?></span></h3>
		<div class="inside">
			<div class="em-boxheader">
				<p><?php esc_html_e('Google Maps API provides you with ways to display maps of your locations and help site visitors find events near their desired locations.','events-manager'); ?></p>
				<p style="font-weight: bold; color:#ca4a1f;">
					<?php
					$msg = esc_html__('Google may charge you for usage, depending on how much traffic your site receives. For more information about how and where Events Manager uses the Google Maps API, and how to manage costs, please see our %s page.', 'events-manager');
					echo sprintf($msg, '<a href="https://wp-events-plugin.com/documentation/google-maps/api-usage/?utm_source=plugin&utm_medium=settings&utm_campaign=gmaps-general">'.esc_html__('documentation', 'events-manager').'</a>');
					?>
				</p>
			</div>
			<table class="form-table">
				<?php
					em_options_radio_binary( esc_html__( 'Enable Google Maps integration?', 'events-manager'), 'dbem_gmap_is_active', esc_html__( 'Check this option to enable Google Map integration.', 'events-manager'), '', '.em-google-maps-enabled' );
				?>
				<tbody class="form-table em-google-maps-enabled">
					<?php
					em_options_input_text(__('Google Maps API Browser Key','events-manager'), 'dbem_google_maps_browser_key', sprintf(__('Google Maps require an API key, please see our %s page for instructions on obtaining one.', 'events-manager'), '<a href="https://wp-events-plugin.com/documentation/google-maps/api-key/?utm_source=plugin&utm_medium=settings&utm_campaign=gmaps-api-key">'.esc_html__('documentation','events-manager').'</a>'));
					$google_map_options = apply_filters('em_settings_google_maps_options', array(
						'dynamic' => _x('Dynamic', 'Google Map Type', 'events-manager'),
						'embed' => _x('Embedded', 'Google Map Type', 'events-manager')
					));
					$google_map_options_pro = !defined('EMP_VERSION') || EMP_VERSION < 2.64 ? '<strong>'.sprintf(__('Upgrade to %s for more options!', 'events-manager'), '<a target="_blank" href="https://wp-events-plugin.com/google-maps/static-maps/?utm_source=plugin&utm_medium=settings&utm_campaign=gmaps-types">Events Manager Pro</a>').'</strong>' : '';
					$google_map_options_desc = sprintf(__('Google offers different map displays, each with varying prices and free usage allowance. See our %s page for more information on these display options.', 'events-manager'), '<a href="https://wp-events-plugin.com/google-maps/map-types/?utm_source=plugin&utm_medium=settings&utm_campaign=gmaps-types">'.__('documentation', 'events-manager').'</a>') .' '. $google_map_options_pro;
					em_options_select(__('Google Map Type', 'events-manager'), 'dbem_gmap_type', $google_map_options, $google_map_options_desc);
					$embed_options = array('place' => __('Location name and address', 'events-manager'), 'address' => __('Address only', 'events-manager'), 'coordinates' => __('Location coordinates', 'events-manager'));
					em_options_select(__('Embed Display Type', 'events-manager'), 'dbem_gmap_embed_type', $embed_options, __('When displaying embedded maps for a location, choose what information Google will use to generate a map from, each producing varying results.', 'events-manager'));
					em_options_textarea(__('Google Maps Style', 'events-manager'), 'dbem_google_maps_styles', sprintf(__('You can add styles to your maps to give them a unique look. Build one using the %s or choose from the many free templates on %s paste the generated JSON code here.', 'events-manager'), '<a href="https://mapstyle.withgoogle.com/" target="_blank">'.esc_html__('Google Maps Styling Wizard', 'events-manager').'</a>', '<a href="https://snazzymaps.com/explore" target="_blank">Snazzy Maps</a>'));
					?>
				</tbody>
				<tbody class="form-table em-google-maps-enabled em-google-maps-static">
					<?php do_action('em_settings_google_maps_general'); ?>
				</tbody>
				<?php
					echo $save_button;
				?>
			</table>
		</div> <!-- . inside -->
	</div> <!-- .postbox -->
	
	<div  class="postbox" id="em-opt-event-submissions" >
	<div class="handlediv" title="<?php __('Click to toggle', 'events-manager'); ?>"><br /></div><h3><span><?php _e ( 'Event Submission Forms', 'events-manager'); ?></span></h3>
	<div class="inside">
            <table class="form-table">
            <tr><td colspan="2" class="em-boxheader">
            	<?php echo sprintf(__('You can allow users to publicly submit events on your blog by using the %s shortcode, and enabling anonymous submissions below.','events-manager'), '<code>[event_form]</code>'); ?>
			</td></tr>
			<?php
				em_options_radio_binary ( __( 'Use Visual Editor?', 'events-manager'), 'dbem_events_form_editor', __( 'Users can now use the WordPress editor for easy HTML entry in the submission form.', 'events-manager') );
				em_options_radio_binary ( __( 'Show form again?', 'events-manager'), 'dbem_events_form_reshow', __( 'When a user submits their event, you can display a new event form again.', 'events-manager') );
				em_options_textarea ( __( 'Success Message', 'events-manager'), 'dbem_events_form_result_success', __( 'Customize the message your user sees when they submitted their event.', 'events-manager').$events_placeholder_tip );
				em_options_textarea ( __( 'Successfully Updated Message', 'events-manager'), 'dbem_events_form_result_success_updated', __( 'Customize the message your user sees when they resubmit/update their event.', 'events-manager').$events_placeholder_tip );
			?>
            <tr class="em-header"><td colspan="2">
            	<h4><?php echo sprintf(__('Anonymous event submissions','events-manager'), '<code>[event_form]</code>'); ?></h4>
			</td></tr>
            <?php
				em_options_radio_binary ( __( 'Allow anonymous event submissions?', 'events-manager'), 'dbem_events_anonymous_submissions', __( 'Would you like to allow users to submit bookings anonymously? If so, you can use the new [event_form] shortcode or <code>em_event_form()</code> template tag with this enabled.', 'events-manager') );
				if( defined('EM_OPTIMIZE_SETTINGS_PAGE_USERS') && EM_OPTIMIZE_SETTINGS_PAGE_USERS ){
	            	em_options_input_text( __('Guest Default User', 'events-manager'), 'dbem_events_anonymous_user', __('Please add a User ID.','events-manager').' '.__( 'Events require a user to own them. In order to allow events to be submitted anonymously you need to assign that event a specific user. We recommend you create a "Anonymous" subscriber with a very good password and use that. Guests will have the same event permissions as this user when submitting.', 'events-manager') );
	            }else{
	            	em_options_select ( __('Guest Default User', 'events-manager'), 'dbem_events_anonymous_user', em_get_wp_users (), __( 'Events require a user to own them. In order to allow events to be submitted anonymously you need to assign that event a specific user. We recommend you create a "Anonymous" subscriber with a very good password and use that. Guests will have the same event permissions as this user when submitting.', 'events-manager') );
				}
            	em_options_textarea ( __( 'Success Message', 'events-manager'), 'dbem_events_anonymous_result_success', __( 'Anonymous submitters cannot see or modify their event once submitted. You can customize the success message they see here.', 'events-manager').$events_placeholder_tip );
			?>
	        <?php echo $save_button; ?>
		</table>
	</div> <!-- . inside --> 
	</div> <!-- .postbox -->
	<?php do_action('em_options_page_event_submission_after'); ?>

	<?php do_action('em_options_page_footer'); ?>
	
	<?php /* 
	<div  class="postbox" id="em-opt-geo" >
	<div class="handlediv" title="<?php __('Click to toggle', 'events-manager'); ?>"><br /></div><h3><span><?php _e ( 'Geo APIs', 'events-manager'); ?> <em>(Beta)</em></span></h3>
	<div class="inside">
		<p><?php esc_html_e('Geocoding is the process of converting addresses into geographic coordinates, which can be used to find events and locations near a specific coordinate.','events-manager'); ?></p>
		<table class="form-table">
			<?php
				em_options_radio_binary ( __( 'Enable Geocoding Features?', 'events-manager'), 'dbem_geo', '', '', '.em-settings-geocoding');
			?>
		</table>
		<div class="em-settings-geocoding">
		<h4>GeoNames API (geonames.org)</h4>
		<p>We make use of the <a href="http://www.geonames.org">GeoNames</a> web service to suggest locations/addresses to users when searching, and converting these into coordinates.</p>
		<p>To be able to use these services, you must <a href="http://www.geonames.org/login">register an account</a>, activate the free webservice and enter your username below. You are allowed up to 30,000 requests per day, if you require more you can purchase credits from your account.</p>
        <table class="form-table">
			<?php em_options_input_text ( __( 'GeoNames Username', 'events-manager'), 'dbem_geonames_username', __('If left blank, this service will not be used.','events-manager')); ?>
		</table>
		</div>
		<table class="form-table"><?php echo $save_button; ?></table>
	</div> <!-- . inside --> 
	</div> <!-- .postbox -->
	*/ ?>
	
	<div  class="postbox" id="em-opt-performance-optimization" >
	<div class="handlediv" title="<?php __('Click to toggle', 'events-manager'); ?>"><br /></div><h3><span><?php _e ( 'Performance Optimization', 'events-manager'); ?> (<?php _e('Advanced','events-manager'); ?>)</span></h3>
	<div class="inside">
		<?php 
			$performance_opt_page_instructions = __('In the boxes below, you are expected to write the page IDs. For multiple pages, use comma-separated values e.g. 1,2,3. Entering 0 means EVERY page, -1 means the home page.','events-manager');
		?>
		<div class="em-boxheader">
			<p><?php _e('This section allows you to configure parts of this plugin that will improve performance on your site and increase page speeds by reducing extra files from being unnecessarily included on pages as well as reducing server loads where possible. This only applies to pages outside the admin area.','events-manager'); ?></p>
			<p><strong><?php _e('Warning!','events-manager'); ?></strong> <?php echo sprintf(__('This is for advanced users, you should know what you\'re doing here or things will not work properly. For more information on how these options work see our <a href="%s" target="_blank">optimization recommendations</a>','events-manager'), 'http://wp-events-plugin.com/documentation/optimization-recommendations/'); ?></p>
		</div>
            <table class="form-table">
            <tr class="em-header"><td colspan="2">
            	<h4><?php _e('JavaScript Files','events-manager'); ?></h4>
			</td></tr>
			<?php
				em_options_radio_binary ( __( 'Limit JS file loading?', 'events-manager'), 'dbem_js_limit', __( 'Prevent unnecessary loading of JavaScript files on pages where they are not needed.', 'events-manager') );
			?>
			<tbody id="dbem-js-limit-options">
				<tr class="em-subheader"><td colspan="2">
	            	<?php 
	            	_e('Aside from pages we automatically generate and include certain jQuery files, if you are using Widgets, Shortcode or PHP to display specific items you may need to tell us where you are using them for them to work properly. Below are options for you to include specific jQuery dependencies only on certain pages.','events-manager');
	            	echo $performance_opt_page_instructions;
	            	?>
				</td></tr>
				<?php
				em_options_input_text( __( 'General JS', 'events-manager'), 'dbem_js_limit_general', __( 'Loads our own JS file if no other dependencies are already loaded, which is still needed for many items generated by EM using JavaScript such as Calendars, Maps and Booking Forms/Buttons', 'events-manager'), 0 );
				em_options_input_text( __( 'Search Forms', 'events-manager'), 'dbem_js_limit_search', __( 'Include pages where you use shortcodes or widgets to display event search forms.', 'events-manager') );
				em_options_input_text( __( 'Event Edit and Submission Forms', 'events-manager'), 'dbem_js_limit_events_form', __( 'Include pages where you use shortcode or PHP to display event submission forms.', 'events-manager') );
				em_options_input_text( __( 'Booking Management Pages', 'events-manager'), 'dbem_js_limit_edit_bookings', __( 'Include pages where you use shortcode or PHP to display event submission forms.', 'events-manager') );
				?>
			</tbody>
            <tr class="em-header"><td colspan="2">
                <h4><?php _e('CSS File','events-manager'); ?></h4>
			</td></tr>
            <?php
				em_options_radio_binary ( __( 'Limit loading of our CSS files?', 'events-manager'), 'dbem_css_limit', __( 'Enabling this will prevent us from loading our CSS file on every page, and will only load on specific pages generated by Events Manager.', 'events-manager') );
				?>
				<tbody id="dbem-css-limit-options">
				<tr class="em-subheader"><td colspan="2">
	            	<?php echo $performance_opt_page_instructions; ?>
				</td></tr>
				<?php
				em_options_input_text( __( 'Include on', 'events-manager'), 'dbem_css_limit_include', __( 'Our CSS file will only be INCLUDED on all of these pages.', 'events-manager'), 0 );
				em_options_input_text( __( 'Exclude on', 'events-manager'), 'dbem_css_limit_exclude', __( 'Our CSS file will be EXCLUDED on all of these pages. Takes precedence over inclusion rules.', 'events-manager'), 0 );
            	?>
            	</tbody>
            	<?php
			?>
			<tr  class="em-header"><td  colspan="2">  
			    <h4><?php  _e('Thumbnails','events-manager');  ?></h4>  
			</td></tr>  
			<?php
            em_options_radio_binary  (  __(  'Disable  WordPress Thumbnails?',  'events-manager'),  'dbem_disable_thumbnails',  __(  'If set to yes, full sized images will be used and HTML width and height attributes will be used to determine the size.',  'events-manager').' '.sprintf(__('Setting this to yes will also make your images crop efficiently with the %s feature in the %s plugin.','events-manager'), '<a href="http://jetpack.me/support/photon/">Photon</a>','<a href="https://wordpress.org/plugins/jetpack/">JetPack</a>') );  
            ?>  
	        <?php echo $save_button; ?>
		</table>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('input:radio[name="dbem_js_limit"]').on('change', function(){
					if( $('input:radio[name="dbem_js_limit"]:checked').val() == 1 ){
						$('tbody#dbem-js-limit-options').show();
					}else{
						$('tbody#dbem-js-limit-options').hide();					
					}
				}).trigger('change');
				
				$('input:radio[name="dbem_css_limit"]').on('change', function(){
					if( $('input:radio[name="dbem_css_limit"]:checked').val() == 1 ){
						$('tbody#dbem-css-limit-options').show();
					}else{
						$('tbody#dbem-css-limit-options').hide();					
					}
				}).trigger('change');
			});
		</script>
	</div> <!-- . inside --> 
	</div> <!-- .postbox --> 
	
	<div  class="postbox" id="em-opt-style-options" >
	<div class="handlediv" title="<?php __('Click to toggle', 'events-manager'); ?>"><br /></div><h3><span><?php _e ( 'Styling Options', 'events-manager'); ?> (<?php _e('Advanced','events-manager'); ?>)</span></h3>
	<div class="inside">
		<p style="font-weight:bold; font-size:110%;">
			<?php echo sprintf( esc_html__('We strongly recommend you check out our %s before disabling any styling here, in most cases you can make profound changes with a few line of CSS or PHP', 'events-manager'), '<a href="#" target="_blank">'. esc_html__('documentation', 'events-manager').'</a>' ); ?>
		</p>
		<p class="em-boxheader">
			<?php esc_html_e("Events Manager 6 onwards has optional styling that maximizes consistency accross different themes. If you'd like your theme to take over in some or all aspects of our plugin, you can disable our styling here.",'events-manager'); ?>
		</p>
		<table class="form-table">
			<tbody>
				<?php
				em_options_radio_binary ( __( 'Enable All Styling?', 'events-manager'), 'dbem_css', esc_html__("You can disable ALL styling altogether by setting this to 'no'. By doing so, nothing will be styled, AT ALL, by Events Manager in the front-end. Basically, it's up to you and your theme!", 'events-manager'), null, '.all-css');
				?>
			</tbody>
			<tbody class="all-css">
				<?php
				em_options_radio_binary ( __( 'Enable Theme Styling?', 'events-manager'), 'dbem_css_theme', esc_html__("We impose some theme styling rules which help normalize the look of Events Manager accross themes and overrides general theming. This is limited to our components but will prevent your theme from taking over things like fonts, font-sizes, form structures etc. You can also disable strict styling for individual components below.", 'events-manager'), null, '.theme-css');
				?>
			</tbody>
			<tbody class="theme-css">
				<tr><td colspan="2">
					<h4><?php _e('Individual Components','events-manager'); ?></h4>
					<p>
					<?php echo sprintf(esc_html__('Our theme has multiple CSS variables that can be overriden easily. The options below could be overriden just as easily via one line of CSS in your %s settings area, for example %s'), '<em>'.__('Customizer').' > '. __('Additional CSS').'</em>', '<code>body .em.pixelbones{ --font-family:arial, --font-size:14px; --font-weight: normal; --line-height:16px; }</code>'); ?>
					</p>
				</td></tr>
				<?php
				$settings = array(0 => esc_html__('Default plugin setting', 'events-manager'), 1 => esc_html__('Inherit your theme settings', 'events-manager'));
				$desc = esc_html__('Our default setting is %s');
				em_options_select ( __( 'Default font family', 'events-manager'), 'dbem_css_theme_font_family', $settings, sprintf($desc, '<code>"Raleway", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;</code>') );
				em_options_select ( __( 'Base font size', 'events-manager'), 'dbem_css_theme_font_size', $settings, sprintf($desc, '<code>16px</code>') );
				em_options_select ( __( 'Base line height', 'events-manager'), 'dbem_css_theme_line_height', $settings, sprintf($desc, '<code>20px</code>') );
				em_options_select ( __( 'Base font weight', 'events-manager'), 'dbem_css_theme_font_weight', $settings, sprintf($desc, '<code>400</code>') );
				?>
			</tbody>
	        <tbody class="all-css">
				<tr class="em-header all-css"><td colspan="2">
					<h4><?php _e('Individual Components','events-manager'); ?></h4>
					<p><?php esc_html_e("Here you can disable individual item styling eompletely or just allow basic styling. Basic styling will try to impose general structuring (such as calendar structures) but won't use our Strict styling rules.", 'events-manager'); ?></p>
				</td></tr>
				<?php
					$select = array(
						1 => __('Enabled','events-manager'), 0 => __('Disabled', 'events-manager'), 2 => __('Basic Only', 'events-manager')
					);
					em_options_select ( __( 'Events Calendar', 'events-manager'), 'dbem_css_calendar', $select );
					em_options_select ( __( 'Events list page', 'events-manager'), 'dbem_css_evlist', $select );
					em_options_select ( __( 'Locations list page', 'events-manager'), 'dbem_css_loclist', $select );
					em_options_select ( __( 'Categories list page', 'events-manager'), 'dbem_css_catlist', $select );
					em_options_select ( __( 'Tags list page', 'events-manager'), 'dbem_css_taglist', $select );
					?><tr><td colspan="2"><hr></td></tr><?php
					em_options_select ( __( 'Event pages', 'events-manager'), 'dbem_css_event', $select );
					em_options_select ( __( 'Location pages', 'events-manager'), 'dbem_css_location', $select );
					em_options_select ( __( 'Category pages', 'events-manager'), 'dbem_css_category', $select );
					em_options_select ( __( 'Tag pages', 'events-manager'), 'dbem_css_tag', $select );
					?><tr><td colspan="2"><hr></td></tr><?php
					em_options_select ( __( 'Search forms', 'events-manager'), 'dbem_css_search', $select);
					em_options_select ( __( 'Event booking forms', 'events-manager'), 'dbem_css_rsvp', $select );
					?><tr><td colspan="2"><hr></td></tr><?php
					em_options_select ( __( 'My bookings page', 'events-manager'), 'dbem_css_myrsvp', $select);
					em_options_select ( __( 'Event/Location admin pages', 'events-manager'), 'dbem_css_editors', $select);
					em_options_select ( __( 'Booking admin pages', 'events-manager'), 'dbem_css_rsvpadmin', $select );
					echo $save_button;
				?>
			</tbody>
		</table>
	</div> <!-- . inside --> 
	</div> <!-- .postbox -->

	<?php em_admin_option_box_data_privacy(); ?>
	<?php if ( !is_multisite() ) { em_admin_option_box_uninstall(); } ?>
	
</div> <!-- .em-menu-general -->