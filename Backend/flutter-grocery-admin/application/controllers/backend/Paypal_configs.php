<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Paypal_configs Controller
 */
class Paypal_configs extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'PAYPAL CONFIG' );
		///start allow module check by MN
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];
		
		$conds_mod['module_name'] = $this->router->fetch_class();
		$module_id = $this->Module->get_one_by($conds_mod)->module_id;
		
		$logged_in_user = $this->ps_auth->get_user_info();

		$user_id = $logged_in_user->user_id;
		if(empty($this->User->has_permission( $module_id,$user_id )) && $logged_in_user->user_is_sys_admin!=1){
			return redirect( site_url('/admin/'.$shop_id) );
		}
		///end check
	}

	/**
	 * List down the registered users
	 */
	function index( $id = "1" ) {

		if ( $this->is_POST()) {
		// if the method is post

			// server side validation
			if ( $this->is_valid_input()) {
				// save user info
				$this->save( $id );
			}
		}

		//Get PayPal Config Object
		$this->data['paypal'] = $this->Paypal_config->get_one( $id );
		$this->load_template( 'paypal_configs/entry_form',$this->data, true );

	}
	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save category
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		$logged_in_user = $this->ps_auth->get_user_info();
		
		/** 
		 * Insert Category Records 
		 */
		$data = array();

		// prepare price
		if ( $this->has_data( 'price' )) {
			$data['price'] = $this->get_data( 'price' );
		}

		// prepare currency_code
		if ( $this->has_data( 'currency_code' )) {
			$data['currency_code'] = $this->get_data( 'currency_code' );
		}

		// prepare currency_code
		if ( $this->has_data( 'currency_code' )) {
			$data['currency_code'] = $this->get_data( 'currency_code' );
		}

		// prepare api_username
		if ( $this->has_data( 'api_username' )) {
			$data['api_username'] = $this->get_data( 'api_username' );
		}

		// prepare api_password
		if ( $this->has_data( 'api_password' )) {
			$data['api_password'] = $this->get_data( 'api_password' );
		}

		// prepare api_signature
		if ( $this->has_data( 'api_signature' )) {
			$data['api_signature'] = $this->get_data( 'api_signature' );
		}

		// prepare application_id
		if ( $this->has_data( 'application_id' )) {
			$data['application_id'] = $this->get_data( 'application_id' );
		}

		// prepare developer_email_account
		if ( $this->has_data( 'developer_email_account' )) {
			$data['developer_email_account'] = $this->get_data( 'developer_email_account' );
		}

		// prepare sandbox
		if ( $this->has_data( 'sandbox' )) {
			$data['sandbox'] = $this->get_data( 'sandbox' );
		}

		if ($data['sandbox'] == 1) {
			$data['sandbox'] = "true";
		} else {
			$data['sandbox'] = "false";
		}
		//print_r($data['sandbox']);die;

		// prepare api_version
		if ( $this->has_data( 'api_version' )) {
			$data['api_version'] = $this->get_data( 'api_version' );
		}
		
		$data['added_date'] = date("Y-m-d H:i:s");

		
		//save paypal
		if ( ! $this->Paypal_config->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_paypal_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_paypal_add' ));
			}
		}
		redirect( $this->module_site_url() );
		
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		return true;
	}

	
}
