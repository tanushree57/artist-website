<?php
if(!function_exists('eventsia_get_option_defaults_values')):
	/******************** EVENTSIA DEFAULT OPTION VALUES ******************************************/
	function eventsia_get_option_defaults_values() {
		global $eventsia_default_values;
		$eventsia_default_values = array(
			'eventsia_header_design'	=> '1',
			'eventsia_design_layout' => 'full-width-layout',
			'eventsia_sidebar_layout_options' => 'right',
			'eventsia_search_custom_header' => 0,
			'eventsia_side_menu'	=> 0,
			'eventsia_img-upload-footer-image' => '',
			'eventsia_header_display'=> 'header_text',
			'eventsia_scroll'	=> 0,
			'eventsia_tag_text' => esc_html__('View More','eventsia'),
			'eventsia_excerpt_length'	=> '25',
			'eventsia_reset_all' => 0,
			'eventsia_stick_menu'	=>0,
			'eventsia_blog_post_image' => 'on',
			'eventsia_search_text' => esc_html__('Search &hellip;','eventsia'),
			'eventsia_entry_meta_single' => 'show',
			'eventsia_entry_meta_blog' => 'show-meta',
			'eventsia_blog_content_layout'	=> 'fullcontent_display',
			'eventsia_post_category' => 0,
			'eventsia_post_author' => 0,
			'eventsia_post_date' => 0,
			'eventsia_post_comments' => 0,
			'eventsia_footer_column_section'	=>'4',
			'eventsia_disable_main_menu' => 0,
			'eventsia_display_page_single_featured_image'=>0,
			'eventsia_header_image_title'=>'',
			'eventsia_header_sub_title'=>'',
			'eventsia_header_image_link'=>'',
			'eventsia_header_image_button'=> esc_html__('View Details','eventsia'),
			'eventsia_enable_header_image'=>'frontpage',
			'eventsia_header_image_with_bg_color'=>'default',
			'eventsia_header_image_content_bg_color'=>'default',

			/* About Us */
			'eventsia_disable_about_us'	=> 1,
			'eventsia_about_us_remove_link' =>0,
			'eventsia_about_us'	=> '',
			'eventsia-img-upload-aboutus-bg-image'	=>'',
			'eventsia-about-content'	=>'default-content',

			/* Upcoming Event */
			'eventsia_disable_upcoming'	=> 1,
			'eventsia_no_upcoming_posts'	=> '4',
			'eventsia_upcoming_status'	=> 'publish',
			'eventsia_upcoming_title'	=> '',
			'eventsia_upcoming_subtitle' => '',
			'eventsia_upcoming_bg_image' =>'',
			'eventsia_upcoming_category_list' =>'',
			/* Our Speaker */
			'eventsia_disable_our_speaker'	=> 1,
			'eventsia_total_our_speaker'	=> '4',
			'eventsia_our_speaker_title'	=> '',
			'eventsia-img-upload-speaker-bg-image' =>'',
			'eventsia_our_speaker_show_text'	=> 0,
			/* Our Gallery */
			'eventsia_disable_our_gallery'	=> 1,
			'eventsia_total_our_gallery'	=> '8',
			'eventsia_our_gallery_title'	=> '',
			/*Latest from blog */
			'eventsia_disable_latest_blog'	=> 1,
			'eventsia_disable_latest_blog_date'=>0,
			'eventsia_latest_category_blog_section' =>'category_display',
			'eventsia_total_latest_blog'	=> '6',
			'eventsia_latest_blog_title'	=> '',
			'eventsia_latest_blog_subtitle' =>'',
			'eventsia_latest_blog_category_list' =>'',
			'eventsia_hide_sticky_latest_blog' =>0,
			/* Our Testimonial */
			'eventsia_disable_our_testimonial'	=> 1,
			'eventsia_total_our_testimonial'	=> '3',
			'eventsia_our_testimonial_title'	=> '',
			'eventsia_our_testimonial_bg_image'	=> '',
			/* Client Box */
			'eventsia_disable_sponsors_box'=>1,
			'eventsia_sponsors_box_no'=>'4',
			'eventsia_sponsors_box_image_heading'	=> '',
			'eventsia_sponsors_bg_image'	=> '',
			'eventsia_sponsors_box_image_1'	=> '',
			'eventsia_sponsors_box_image_2'	=> '',
			'eventsia_sponsors_box_image_3'	=> '',
			'eventsia_sponsors_box_image_4'	=> '',
			'eventsia_redirect_link1'	=> '#',
			'eventsia_redirect_link2'	=> '#',
			'eventsia_redirect_link3'	=> '#',
			'eventsia_redirect_link4'	=> '#',

			/* Display Eventsia Frontpage section in Order */
			'eventsia_display_about_us'	=> 'eventsia_display_about_us',
			'eventsia_display_upcoming_box'	=> 'eventsia_display_upcoming_box',
			'eventsia_frontpage_widget_section'	=> 'eventsia_frontpage_widget_section',
			'eventsia_display_our_speaker'	=> 'eventsia_display_our_speaker',
			'eventsia_display_our_gallery'	=> 'eventsia_display_our_gallery',
			'eventsia_display_blog'	=> 'eventsia_display_blog',
			'eventsia_display_our_testimonials'	=> 'eventsia_display_our_testimonials',
			'eventsia_sponsors_box'	=> 'eventsia_sponsors_box',

			/*Social Icons */
			'eventsia_top_social_icons' =>0,
			'eventsia_side_menu_social_icons' =>0,
			'eventsia_buttom_social_icons'	=>0,
			);
		return apply_filters( 'eventsia_get_option_defaults_values', $eventsia_default_values );
	}
endif;