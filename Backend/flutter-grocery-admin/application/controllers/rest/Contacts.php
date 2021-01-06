<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Ratings
 */
class Contacts extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Contact' );

		// set the validation rules for create and update
		$this->validation_rules();
	}

	/**
	 * Determines if valid input.
	 */
	function validation_rules()
	{
		// validation rules for create
		$this->create_validation_rules = array(
			array(
	        	'field' => 'name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'email',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'message',
	        	'rules' => 'required'
	        )
        );
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		if ( $this->is_add ) {
			$contact_id = $obj->id;
			$subject = get_msg('contact_receive_message');
			send_contact_us_emails( $contact_id, $subject );
			$this->success_response( get_msg( 'success_contact'));
		} else {

			$this->error_response( get_msg( 'err_contact' ));

		}
	}	
}