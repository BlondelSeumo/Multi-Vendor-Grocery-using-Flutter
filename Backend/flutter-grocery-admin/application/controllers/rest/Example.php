<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for News
 */
class Example extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Category' );
	}

	/**
	 * Test Function to send email
	 */
	function send_post()
	{
		// to email
		$to = $this->post( 'to' );

		// subject
		$subject = "Test Email By TeamPS";

		// message
		$msg = "<h1>Teams PS is the best!</h1><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<p>";

		// send email from admin
		if ( ! $this->ps_mail->send_from_admin( $to, $subject, $msg ) ) {

			$this->error_response( get_msg( 'err_email' ));
		}

		// send from other email
		// $from = "pphteamps@gmail.com";
		// $from_name = "PP Han";
		//$this->ps_mail->send( $to, $subject, $msg );
		
		$this->success_response( get_msg( 'success' ));
	}
}