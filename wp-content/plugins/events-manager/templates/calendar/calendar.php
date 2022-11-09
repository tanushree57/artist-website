<?php
/*
 * This file contains the HTML generated for all calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.
 *
 * Note that leaving the class names for the previous/next links will keep all the dynamic functionality working as expected (searches, navigation, datepickers etc.)
 *
 * These variables are available to you:
 */
/* @var array       $args       The $args passed onto the calendar template via EM_Calendar  */
/* @var array       $calendar   The $calendar array of data passed on by EM_Calendar         */

$EM_DateTime = new EM_DateTime($calendar['month_start'], 'UTC');
$id = absint($args['id']);
$events = array(); // used in two templates
?>
<div class="<?php em_template_classes('calendar'); ?> <?php echo esc_attr(implode(' ', $calendar['css']['calendar_classes'])); ?>" data-scope="<?php echo esc_attr($args['scope']['name']); ?>" data-preview-tooltips-trigger="" id="em-calendar-<?php echo $id ?>" data-view-id="<?php echo $id ?>" data-view-type="calendar">
	<?php
	// display section for showing header navigation (datepicker, arrows, search toggle etc.) of the calendar
	$template = em_locate_template('calendar/section-header-navigation.php', false);
	include($template);
	
	// display section for showing weekdays at top of calendar
	$template = em_locate_template('calendar/section-header-weekdays.php', false);
	include($template);
	
	// display main section
	$template = em_locate_template('calendar/section-dates.php', false);
	include($template);

	// display section for showing preview content of an event
	$preview_section_template = em_locate_template('calendar/section-preview-content.php', false);
	include($preview_section_template);
	?>
</div>