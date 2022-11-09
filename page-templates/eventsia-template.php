<?php
/**
 * Template Name: Eventsia Template
 *
 * Displays Eventsia template.
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Event 1.0
 */

get_header();
	$eventsia_settings = eventsia_get_theme_options();
	$eventsia_display_about_us = $eventsia_settings['eventsia_display_about_us'];
	$eventsia_display_upcoming_box = $eventsia_settings['eventsia_display_upcoming_box'];
	$eventsia_frontpage_widget_section = $eventsia_settings['eventsia_frontpage_widget_section'];
	$eventsia_display_our_speaker = $eventsia_settings['eventsia_display_our_speaker'];
	$eventsia_display_our_gallery = $eventsia_settings['eventsia_display_our_gallery'];
	$eventsia_display_blog = $eventsia_settings['eventsia_display_blog'];
	$eventsia_display_our_testimonials = $eventsia_settings['eventsia_display_our_testimonials'];
	$eventsia_sponsors_box = $eventsia_settings['eventsia_sponsors_box'];

	do_action ($eventsia_display_about_us);
	do_action ($eventsia_display_upcoming_box);
	do_action ($eventsia_frontpage_widget_section);
	do_action ($eventsia_display_our_speaker);
	do_action ($eventsia_display_our_gallery);
	do_action ($eventsia_display_blog);
	do_action ($eventsia_display_our_testimonials);
	do_action ($eventsia_sponsors_box);

get_footer();