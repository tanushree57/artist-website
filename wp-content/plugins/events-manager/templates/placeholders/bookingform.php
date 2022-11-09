<?php  
/* 
 * This is where the booking form is generated.
 * For non-advanced users, It's SERIOUSLY NOT recommended you edit this form directly if avoidable, as you can change booking form settings in various less obtrusive and upgrade-safe ways:
 * - check your booking form options panel in the Booking Options tab in your settings.
 * - use CSS or jQuery to change the look of your booking forms
 * - edit the files in the forms/bookingform folder individually instead of this file, to make it more upgrade-safe
 * - hook into WP action/filters below to modify/generate information
 * Again, even if you're an advanced user, consider NOT editing this form and using other methods instead.
 */

/* @var $EM_Event EM_Event */   
global $EM_Notices;
// first hook before anything is checked
do_action('em_booking_form_start', $EM_Event);
//count tickets and available tickets
$tickets_count = count($EM_Event->get_bookings()->get_tickets()->tickets);
$available_tickets_count = count($EM_Event->get_bookings()->get_available_tickets());
//decide whether user can book, event is open for bookings etc.
$can_book = is_user_logged_in() || (get_option('dbem_bookings_anonymous') && !is_user_logged_in());
$is_open = $EM_Event->get_bookings()->is_open(); //whether there are any available tickets right now
$show_tickets = true;
//if user is logged out, check for member tickets that might be available, since we should ask them to log in instead of saying 'bookings closed'
if( !$is_open && !is_user_logged_in() && $EM_Event->get_bookings()->is_open(true) ){
    $is_open = true;
    $can_book = false;
	$show_tickets = get_option('dbem_bookings_tickets_show_unavailable') && get_option('dbem_bookings_tickets_show_member_tickets');
}
?>
<div class="<?php em_template_classes('event-booking-form'); ?> input">
	<?php 
		// We are firstly checking if the user has already booked a ticket at this event, if so offer a link to view their bookings.
		$EM_Booking = $EM_Event->get_bookings()->has_booking();
		do_action('em_booking_form_top', $EM_Event);
	?>
	<?php if( is_object($EM_Booking) && !get_option('dbem_bookings_double') ): //Double bookings not allowed ?>
		<?php do_action('em_booking_form_status_already_booked', $EM_Event); ?>
	<?php elseif( !$EM_Event->event_rsvp ): //bookings not enabled ?>
		<?php do_action('em_booking_form_status_disabled', $EM_Event); ?>
	<?php elseif( $EM_Event->get_bookings()->get_available_spaces() <= 0 && !EM_Bookings::$disable_restrictions ): ?>
		<?php do_action('em_booking_form_status_full', $EM_Event); ?>
	<?php elseif( !$is_open ): //event has started ?>
		<?php do_action('em_booking_form_status_closed', $EM_Event); ?>
	<?php else: ?>
		<?php echo $EM_Notices; ?>	
		<?php 
		if( !is_user_logged_in() && get_option('dbem_bookings_login_form') ){
			//User is not logged in, show login form (enabled on settings page)
			em_locate_template('forms/bookingform/login.php',true, array('EM_Event'=>$EM_Event));
		}
		?>
		<?php if( $tickets_count > 0) : ?>
			<?php //Tickets exist, so we show a booking form. ?>
			<form class="em-booking-form" name='booking-form' method='post' action='<?php echo apply_filters('em_booking_form_action_url',''); ?>#em-booking'>
				<?php do_action('em_booking_form_header', $EM_Event); ?>
			 	<input type='hidden' name='action' value='booking_add'/>
			 	<input type='hidden' name='event_id' value='<?php echo $EM_Event->get_bookings()->event_id; ?>'/>
			 	<input type='hidden' name='_wpnonce' value='<?php echo wp_create_nonce('booking_add'); ?>'/>
				<?php if( get_option('dbem_bookings_header_tickets') ): ?>
			 	<h3 class="em-booking-section-title"><?php echo esc_html(get_option('dbem_bookings_header_tickets')); ?></h3>
				<?php endif; ?>
				<?php
					// Tickets Form
					if( $show_tickets && ($can_book || get_option('dbem_bookings_tickets_show_loggedout')) ){ //show if more than 1 ticket, or if in forced ticket list view mode
						do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
						//Show multiple tickets form to user, or single ticket list if settings enable this
						
						if ( $available_tickets_count == 1 && !get_option('dbem_bookings_tickets_single_form')) {
							$EM_Ticket = $EM_Event->get_bookings()->get_available_tickets()->get_first();
							em_locate_template('forms/bookingform/ticket-single.php', true, array('EM_Event' => $EM_Event, 'EM_Ticket' => $EM_Ticket));
						} else {
							//If logged out, can be allowed to see this in settings witout the register form
							em_locate_template('forms/bookingform/tickets-list.php', true, array('EM_Event' => $EM_Event));
						}
						do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
						$show_tickets = false;
					}
				?>
				<?php if( $can_book ): ?>
					<?php do_action('em_booking_form_before_registration_info', $EM_Event); //do not delete ?>
					<?php if( get_option('dbem_bookings_header_reg_info') ): ?>
						<h3 class="em-booking-section-title"><?php echo get_option('dbem_bookings_header_reg_info'); ?></h3>
					<?php endif; ?>
					<div class="em-booking-form-details em-booking-section">
						<?php if( !is_user_logged_in() && get_option('dbem_bookings_login_form') ): ?>
						<div class="em-login-trigger">
							<?php echo sprintf(esc_html__('Do you already have an account with us? %s','events-manager'), '<a href="#">'. esc_html__('Sign In', 'events-manager') .'</a>'); ?>
						</div>
						<?php endif; ?>
						<?php
							do_action('em_booking_form_before_user_details', $EM_Event);
							if( has_action('em_booking_form_custom') ){ 
								//Pro Custom Booking Form. You can create your own custom form by hooking into this action and setting the option above to true
								do_action('em_booking_form_custom', $EM_Event); //do not delete
							}else{
								//If you just want to modify booking form fields, you could do so here
								em_locate_template('forms/bookingform/booking-fields.php',true, array('EM_Event'=>$EM_Event));
							}
							do_action('em_booking_form_after_user_details', $EM_Event);
						?>
					</div>
					<?php do_action('em_booking_form_after_registration_info', $EM_Event); //do not delete ?>
					<?php do_action('em_booking_form_before_confirmation', $EM_Event); //do not delete ?>
					<div class="em-booking-form-payment em-booking-section">
						<?php do_action('em_booking_form_before_pricing', $EM_Event); //do not delete ?>
						<div class="em-booking-price-summary"></div>
						<?php do_action('em_booking_form_after_pricing', $EM_Event); //do not delete ?>
						<?php
						/* This action pre-theme makeover in v6 was used for any form actions such as payment selection, etc. and had to remain here for backwards compatibility. This can stil be used, and will not be removed, although counter-intuitive as it's not right at the footer */
						do_action('em_booking_form_footer', $EM_Event); //do not delete
						?>
						<div class="em-booking-buttons">
							<?php do_action('em_booking_form_footer_before_buttons', $EM_Event); //do not delete ?>
							<?php if( preg_match('/https?:\/\//',get_option('dbem_bookings_submit_button')) ): //Settings have an image url (we assume). Use it here as the button.?>
							<input type="image" src="<?php echo get_option('dbem_bookings_submit_button'); ?>" class="em-booking-submit" id="em-booking-submit" />
							<?php else: //Display normal submit button ?>
							<input type="submit" class="em-booking-submit em-button em-button-1" id="em-booking-submit" value="<?php echo esc_attr(get_option('dbem_bookings_submit_button')); ?>" />
							<?php endif; ?>
							<?php do_action('em_booking_form_footer_after_buttons', $EM_Event); //do not delete ?>
						</div>
					</div>
					<?php do_action('em_booking_form_after_confirmation', $EM_Event); //do not delete ?>
				<?php else: ?>
					<p class="em-booking-form-details"><?php echo get_option('dbem_booking_feedback_log_in'); ?></p>
				<?php endif; ?>
			</form>  
		<?php endif; ?>
	<?php endif; ?>
	<?php do_action('em_booking_form_bottom', $EM_Event); ?>
</div>