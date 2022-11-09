<?php
class EM_Ticket_Booking extends EM_Object{
	//DB Fields
	var $ticket_booking_id;
	var $ticket_uuid;
	var $booking_id;
	var $ticket_id;
	var $ticket_booking_price;
	var $ticket_booking_spaces = 1; // always 1 as of v6.1
	var $fields = array(
		'ticket_booking_id' => array('name'=>'id','type'=>'%d'),
		'ticket_uuid' => array('name' => 'uuid', 'type' => '%s'),
		'ticket_id' => array('name'=>'ticket_id','type'=>'%d'),
		'booking_id' => array('name'=>'booking_id','type'=>'%d'),
		'ticket_booking_price' => array('name'=>'price','type'=>'%f'),
		'ticket_booking_spaces' => array('name'=>'spaces','type'=>'%d')
	);
	var $shortnames = array(
		'id' => 'ticket_booking_id',
		'price' => 'ticket_booking_price',
		'spaces' => 'ticket_booking_spaces',
	);
	//Other Vars
	/**
	 * Any ticket meta stored in the em_ticket_bookings_meta table
	 * @var array
	 */
	var $meta = array();
	/**
	 * Contains ticket object
	 * @var EM_Ticket
	 */
	var $ticket;
	/**
	 * Contains the booking object of this
	 * @var EM_Booking
	 */
	var $booking;
	var $required_fields = array( 'ticket_id', 'ticket_booking_spaces');
	
	/**
	 * Creates ticket object and retreives ticket data (default is a blank ticket object). Accepts either array of ticket data (from db) or a ticket id.
	 * @param mixed $ticket_data
	 */
	function __construct( $ticket_data = false ){
		global $wpdb;
		if( $ticket_data !== false ) {
			//Load ticket data
			$ticket = array();
			if (is_array($ticket_data)) {
				$ticket = $ticket_data;
				// if we get supplied this info we should load the references so we don't need to later
				if( !empty($ticket_data['booking']) && !empty($ticket_data['booking']->booking_uuid) ){
					$this->booking = $ticket_data['booking'];
					$this->booking_id = $this->booking->booking_id;
				}
				if( !empty($ticket_data['ticket']) && !empty($ticket_data['ticket']->ticket_id) ){
					$this->ticket = $ticket_data['ticket'];
					$this->ticket_id = $this->ticket;
				}
			} elseif (is_numeric($ticket_data)) {
				//Retreiving from the database
				$sql = "SELECT * FROM " . EM_TICKETS_BOOKINGS_TABLE . " WHERE ticket_booking_id=%s";
				$sql = $wpdb->prepare($sql, $ticket_data);
				$ticket = $wpdb->get_row($sql, ARRAY_A);
			} elseif( preg_match('/^[a-zA-Z0-9]{32}$/', $ticket_data) ){
				$sql = "SELECT * FROM " . EM_TICKETS_BOOKINGS_TABLE . " WHERE ticket_uuid=%s";
				$sql = $wpdb->prepare($sql, $ticket_data);
				$ticket = $wpdb->get_row($sql, ARRAY_A);
			}
			//Save into the object
			$this->to_object($ticket);
			$this->compat_keys();
			
			//booking meta
			if( !empty($ticket['ticket_booking_id']) ) {
				$sql = $wpdb->prepare("SELECT meta_key, meta_value FROM " . EM_TICKETS_BOOKINGS_META_TABLE . " WHERE ticket_booking_id=%d", $ticket['ticket_booking_id']);
				$ticket_meta_results = $wpdb->get_results($sql, ARRAY_A);
				$this->meta = $this->process_meta($ticket_meta_results);
			}
			// sort out uuid if not assigned already
			if (empty($this->ticket_uuid)) {
				if( !empty($this->ticket_booking_id) ){
					$this->ticket_uuid = md5($this->ticket_booking_id); // fallback, create a consistent but unique MD5 hash in case it's not saved for some reason.
				} else {
					$this->ticket_uuid = $this->generate_uuid();
				}
			}
		}else{
			$this->ticket_uuid = $this->generate_uuid();
		}
	}
	
	/**
	 * Cleans up serialization of this object and returns only relevant fields. For EM_Bookings that get serialized but aren't saved yet with an ID, they should populate the booking object upon wakeup.
	 * @return string[]
	 */
	function __sleep(){
		return array( 'ticket_booking_id', 'ticket_uuid', 'booking_id','ticket_id','ticket_booking_price','ticket_booking_spaces', 'meta' );
	}
	
	public function get_post(){
		return array('em_ticket_booking_get_post', true, $this);
	}
	
	/**
	 * Saves the ticket into the database, whether a new or existing ticket
	 * @return boolean
	 */
	function save(){
		global $wpdb;
		$table = EM_TICKETS_BOOKINGS_TABLE;
		do_action('em_ticket_booking_save_pre',$this);
		//First the person
		if($this->validate()){			
			//Now we save the ticket
			$this->booking_id = $this->get_booking()->booking_id; //event wouldn't exist before save, so refresh id
			$data = $this->to_array(true); //add the true to remove the nulls
			$result = null;
			if($this->ticket_booking_id != ''){
				if($this->get_spaces() > 0){
					$where = array( 'ticket_booking_id' => $this->ticket_booking_id );  
					$result = $wpdb->update($table, $data, $where, $this->get_types($data));
					$this->feedback_message = __('Changes saved','events-manager');
				}else{
					$this->result = $this->delete(); 
				}
			}else{
				if($this->get_spaces() > 0){
					//TODO better error handling
					// first check that the uuid is unique, if not change it and repeat until unique
					while( $wpdb->get_var( $wpdb->prepare("SELECT ticket_uuid FROM $table WHERE ticket_uuid=%s", $this->ticket_uuid) ) ){
						$this->ticket_uuid = $data['ticket_uuid'] = $this->generate_uuid();
					}
					// now insert with unique uuid
					$result = $wpdb->insert($table, $data, $this->get_types($data));
				    $this->ticket_booking_id = $wpdb->insert_id;  
					$this->feedback_message = __('Ticket booking created','events-manager'); 
				}else{
					//no point saving a booking with no spaces
					$result = false;
				}
			}
			if( $result === false ){
				$this->feedback_message = __('There was a problem saving the ticket booking.', 'events-manager');
				$this->errors[] = __('There was a problem saving the ticket booking.', 'events-manager');
			}
			if( $this->ticket_booking_id ){
				//Step 2 - Save ticket meta
				$wpdb->delete(EM_TICKETS_BOOKINGS_META_TABLE, array('ticket_booking_id' => $this->ticket_booking_id));
				$meta_insert = array();
				foreach( $this->meta as $meta_key => $meta_value ){
					if( is_array($meta_value) ){
						// we go down one level of array
						foreach( $meta_value as $kk => $vv ){
							if( is_array($vv) ) $vv = serialize($vv);
							$meta_insert[] = $wpdb->prepare('(%d, %s, %s)', $this->ticket_booking_id, '_'.$meta_key.'_'.$kk, $vv);
						}
					}else{
						$meta_insert[] = $wpdb->prepare('(%d, %s, %s)', $this->ticket_booking_id, $meta_key, $meta_value);
					}
				}
				if( !empty($meta_insert) ){
					
					$wpdb->query('INSERT INTO '. EM_TICKETS_BOOKINGS_META_TABLE .' (ticket_booking_id, meta_key, meta_value) VALUES '. implode(',', $meta_insert));
				}
			}
			$this->compat_keys();
			return apply_filters('em_ticket_booking_save', ( count($this->errors) == 0 ), $this);
		}else{
			$this->feedback_message = __('There was a problem saving the ticket booking.', 'events-manager');
			$this->errors[] = __('There was a problem saving the ticket booking.', 'events-manager');
			return apply_filters('em_ticket_booking_save', false, $this);
		}
	}	
	

	/**
	 * Validates the ticket during a booking
	 * @return boolean
	 */
	function validate( $override_availability = false ){
		return apply_filters('em_ticket_booking_validate', true, $this, $override_availability );
	}
	
	/**
	 * Get the total number of spaces booked for this ticket within this booking. As of 6.1 it's always one space.
	 * @return int
	 */
	function get_spaces(){
		return 1;
	}
	
	/**
	 * Gets the total price for these tickets. If $format is set to true, the value returned is a price string with currency formatting.
	 * @param boolean $format
	 * @return double|string
	 */
	function get_price( $format = false ){
		if( $this->ticket_booking_price == 0 ){
			$this->calculate_price( true );
			// depracated - preferable to use the _calculate_price filter
			$this->ticket_booking_price = apply_filters('em_ticket_booking_get_price', $this->ticket_booking_price, $this);
		}
		$price = $this->ticket_booking_price;
		//do some legacy checking here for bookings made prior to 5.4, due to how taxes are calculated
		if( $this->ticket_booking_id > 0 ){
		    $EM_Booking = $this->get_booking();
		    if( !empty($EM_Booking->legacy_tax_rate) ){
		        //check multisite nuances
		        if( EM_MS_GLOBAL && $EM_Booking->get_event()->blog_id != get_current_blog_id() ){
		            //MultiSite AND Global tables enabled - get settings for blog that published the event  
		            $tax_auto_add = get_blog_option($EM_Booking->get_event()->blog_id, 'dbem_legacy_bookings_tax_auto_add');
		        }else{
		            //get booking from current site, whether or not we're in MultiSite
		            $tax_auto_add = get_option('dbem_legacy_bookings_tax_auto_add');
		        }
		        if( $tax_auto_add && $EM_Booking->get_tax_rate() > 0 ){
				    //this booking never had a tax rate fixed to it (i.e. prior to v5.4), and according to legacy settings, taxes were applied to this price
				    //we now calculate price of ticket bookings without taxes, so remove the tax
				    $price = $this->ticket_booking_price / (1 + $EM_Booking->get_tax_rate()/100 );
		        }
		    }
		}
		//return price formatted or not
		if($format){
			return $this->format_price($price);
		}
		return $price;
	}
	
	function get_price_with_taxes( $format = false ){
		$price = $this->get_price() * (1 + $this->get_booking()->get_event()->get_tax_rate()/100);
	    if( $format ) return $this->format_price($price);
	    return $price; 
	}
	
	function calculate_price( $force_refresh = false ){
		if( $this->ticket_booking_price === null || $force_refresh ){
			//get the ticket, calculate price on spaces
			$this->ticket_booking_price = $this->get_ticket()->get_price_without_tax();
			$this->ticket_booking_price = apply_filters('em_ticket_booking_calculate_price', $this->ticket_booking_price, $this, $force_refresh);
		}
		return $this->ticket_booking_price;
	}
	
	/**
	 * Smart booking locator, saves a database read if possible.
	 * @return EM_Booking 
	 */
	function get_booking(){
		global $EM_Booking;
		if( is_object($this->booking) && $this->booking instanceof EM_Booking && ($this->booking->booking_id == $this->booking_id || (empty($this->ticket_booking_id) && empty($this->booking_id))) ){
			return $this->booking;
		}elseif( is_object($EM_Booking) && $EM_Booking->booking_id == $this->booking_id ){
			$this->booking = $EM_Booking;
		}else{
			if(is_numeric($this->booking_id)){
				$this->booking = em_get_booking($this->booking_id);
			}else{
				$this->booking = em_get_booking();
			}
		}
		return apply_filters('em_ticket_booking_get_booking', $this->booking, $this);;
	}
	
	/**
	 * Gets the ticket object this booking belongs to, saves a reference in ticket property
	 * @return EM_Ticket
	 */
	function get_ticket(){
		global $EM_Ticket;
		if( is_object($this->ticket) && get_class($this->ticket)=='EM_Ticket' && $this->ticket->ticket_id == $this->ticket_id ){
			return $this->ticket;
		}elseif( is_object($EM_Ticket) && $EM_Ticket->ticket_id == $this->ticket_id ){
			$this->ticket = $EM_Ticket;
		}else{
			$this->ticket = new EM_Ticket($this->ticket_id);
		}
		return apply_filters('em_ticket_booking_get_ticket', $this->ticket, $this);
	}
	
	/**
	 * I wonder what this does....
	 * @return boolean
	 */
	function delete(){
		global $wpdb;
		if( $this->ticket_booking_id ) {
			$sql = $wpdb->prepare("DELETE FROM " . EM_TICKETS_BOOKINGS_TABLE . " WHERE ticket_booking_id=%d LIMIT 1", $this->ticket_booking_id);
			$result = $wpdb->query( $sql );
			$sql = $wpdb->prepare("DELETE FROM " . EM_TICKETS_BOOKINGS_META_TABLE . " WHERE ticket_booking_id=%d LIMIT 1", $this->ticket_booking_id);
			$result_meta = $wpdb->query( $sql );
		}else{
			//cannot delete ticket
			$result = false;
		}
		return apply_filters('em_ticket_booking_delete', ($result !== false && $result_meta !== false ), $this);
	}
	
	/**
	 * Outputs ticket information, mainly reserved for add-ons that may extend ticket functionality, such as Pro.
	 * @param $format
	 * @param $target
	 * @return mixed|void
	 */
	public function output($format, $target="html") {
		$output_string = $format;
		for ($i = 0 ; $i < EM_CONDITIONAL_RECURSIONS; $i++){
			preg_match_all('/\{([a-zA-Z0-9_\-,]+)\}(.+?)\{\/\1\}/s', $format, $conditionals);
			if( count($conditionals[0]) > 0 ){
				//Check if the language we want exists, if not we take the first language there
				foreach($conditionals[1] as $key => $condition){
					$show_condition = false;
					$show_condition = apply_filters('em_ticket_booking_output_show_condition', $show_condition, $condition, $conditionals[0][$key], $this);
					if($show_condition){
						//calculate lengths to delete placeholders
						$placeholder_length = strlen($condition)+2;
						$replacement = substr($conditionals[0][$key], $placeholder_length, strlen($conditionals[0][$key])-($placeholder_length *2 +1));
					}else{
						$replacement = '';
					}
					$output_string = str_replace($conditionals[0][$key], apply_filters('em_ticket_booking_output_condition', $replacement, $condition, $conditionals[0][$key], $this), $format);
				}
			}
		}
		preg_match_all("/(#@?_?[A-Za-z0-9_]+)({([^}]+)})?/", $output_string, $placeholders);
		$replaces = array();
		foreach($placeholders[1] as $key => $result) {
			$full_result = $placeholders[0][$key];
			$placeholder_atts = array($result);
			if( !empty($placeholders[3][$key]) ) $placeholder_atts[] = $placeholders[3][$key];
			/* For now there's nothing to switch, pro and others override this
			$replace = '';
			switch( $result ){
				default:
					$replace = $full_result;
					break;
			}
			*/
			$replace = $full_result;
			$replaces[$full_result] = apply_filters('em_ticket_booking_output_placeholder', $replace, $this, $full_result, $target, $placeholder_atts);
		}
		krsort($replaces);
		foreach($replaces as $full_result => $replacement){
			$output_string = str_replace($full_result, $replacement , $output_string );
		}
		return apply_filters('em_ticket_booking_output', $output_string, $this, $format, $target);
	}
	
	
	/**
	 * Can the user manage this ticket?
	 */
	function can_manage( $owner_capability = false, $admin_capability = false, $user_to_check = false ){
		return ( $this->get_booking()->can_manage() );
	}
	
	public function __debugInfo(){
		$object = clone($this);
		$object->booking = !empty($this->booking->booking_id) ? 'Booking ID #'.$this->booking->booking_id : 'New Booking - No ID';
		$object->ticket = 'Ticket #'.$this->ticket_id . ' - ' . $this->get_ticket()->ticket_name;
		$object->fields = 'Removed for export, uncomment from __debugInfo()';
		$object->required_fields = 'Removed for export, uncomment from __debugInfo()';
		$object->shortnames = 'Removed for export, uncomment from __debugInfo()';
		$object->mime_types = 'Removed for export, uncomment from __debugInfo()';
		if( empty($object->errors) ) $object->errors = false;
		return (Array) $object;
	}
}
?>