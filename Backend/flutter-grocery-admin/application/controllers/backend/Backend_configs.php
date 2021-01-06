<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Backend_configs extends BE_Controller {
		/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'backend_setting_module' );
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
	 * Load About Entry Form
	 */

	function index( $id = "be1" ) {

		if ( $this->is_POST()) {
		// if the method is post

			// server side validation
			if ( $this->is_valid_input()) {

				// save user info
				$this->save( $id );
			}
		}

		//Get Backend_config Object
		$this->data['backend'] = $this->Backend_config->get_one( $id );

		$this->load_template( 'backend_configs/entry_form',$this->data, true );

	}

	/**
	 * Update the existing one
	 */
	function edit( $id = "be1") {


		// load user
		$this->data['backend'] = $this->Backend_config->get_one( $id );

		// call the parent edit logic
		parent::backendedit( $id );
	}

	/**
	 * Saving Logic
	 * 1) save about data
	 * 2) check transaction status
	 *
	 * @param      boolean  $id  The about identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		// prepare data for save
		$data = array();

		// sender_name
		if ( $this->has_data( 'sender_name' )) {
			$data['sender_name'] = $this->get_data( 'sender_name' );
		}

		// sender_email
		if ( $this->has_data( 'sender_email' )) {
			$data['sender_email'] = $this->get_data( 'sender_email' );
		}

		// receive_email
		if ( $this->has_data( 'receive_email' )) {
			$data['receive_email'] = $this->get_data( 'receive_email' );
		}

		// fcm_api_key
		if ( $this->has_data( 'fcm_api_key' )) {
			$data['fcm_api_key'] = $this->get_data( 'fcm_api_key' );
		}

		// topics
		if ( $this->has_data( 'topics' )) {
			$data['topics'] = $this->get_data( 'topics' );
		}

		// smtp_host
		if ( $this->has_data( 'smtp_host' )) {
			$data['smtp_host'] = $this->get_data( 'smtp_host' );
		}

		// smtp_port
		if ( $this->has_data( 'smtp_port' )) {
			$data['smtp_port'] = $this->get_data( 'smtp_port' );
		}

		// smtp_user
		if ( $this->has_data( 'smtp_user' )) {
			$data['smtp_user'] = $this->get_data( 'smtp_user' );
		}

		// smtp_pass
		if ( $this->has_data( 'smtp_pass' ) 
			&& !empty( $this->get_data( 'smtp_pass' ))) {
			$data['smtp_pass'] = md5( $this->get_data( 'smtp_pass' ));
		}

		// if 'smtp_enable' is checked,
		if ( $this->has_data( 'smtp_enable' )) {
			$data['smtp_enable'] = 1;
		} else {
			$data['smtp_enable'] = 0;
		}

		// if 'email_varification_enable' is checked
		if ( $this->has_data( 'email_verification_enabled' )) {
			$data['email_verification_enabled'] = 1;
		} else {
			$data['email_verification_enabled'] = 0;
		}

		// landscape_width
		if ( $this->has_data( 'landscape_width' ) 
			&& !empty( $this->get_data( 'landscape_width' ))) {
			$data['landscape_width'] = $this->get_data( 'landscape_width' );
		}

		// potrait_height
		if ( $this->has_data( 'potrait_height' ) 
			&& !empty( $this->get_data( 'potrait_height' ))) {
			$data['potrait_height'] = $this->get_data( 'potrait_height' );
		}

		// square_height
		if ( $this->has_data( 'square_height' ) 
			&& !empty( $this->get_data( 'square_height' ))) {
			$data['square_height'] = $this->get_data( 'square_height' );
		}

		// landscape_thumb_width
		if ( $this->has_data( 'landscape_thumb_width' ) 
			&& !empty( $this->get_data( 'landscape_thumb_width' ))) {
			$data['landscape_thumb_width'] = $this->get_data( 'landscape_thumb_width' );
		}

		// potrait_thumb_height
		if ( $this->has_data( 'potrait_thumb_height' ) 
			&& !empty( $this->get_data( 'potrait_thumb_height' ))) {
			$data['potrait_thumb_height'] = $this->get_data( 'potrait_thumb_height' );
		}

		// square_thumb_height
		if ( $this->has_data( 'square_thumb_height' ) 
			&& !empty( $this->get_data( 'square_thumb_height' ))) {
			$data['square_thumb_height'] = $this->get_data( 'square_thumb_height' );
		}

		// dyn_link_key
		if ( $this->has_data( 'dyn_link_key' ) 
			&& !empty( $this->get_data( 'dyn_link_key' ))) {
			$data['dyn_link_key'] = $this->get_data( 'dyn_link_key' );
		}

		// dyn_link_url
		if ( $this->has_data( 'dyn_link_url' ) 
			&& !empty( $this->get_data( 'dyn_link_url' ))) {
			$data['dyn_link_url'] = $this->get_data( 'dyn_link_url' );
		}

		// dyn_link_package_name
		if ( $this->has_data( 'dyn_link_package_name' ) 
			&& !empty( $this->get_data( 'dyn_link_package_name' ))) {
			$data['dyn_link_package_name'] = $this->get_data( 'dyn_link_package_name' );
		}

		// dyn_link_domain
		if ( $this->has_data( 'dyn_link_domain' ) 
			&& !empty( $this->get_data( 'dyn_link_domain' ))) {
			$data['dyn_link_domain'] = $this->get_data( 'dyn_link_domain' );
		}

		// dyn_link_deep_url
		if ( $this->has_data( 'dyn_link_deep_url' ) 
			&& !empty( $this->get_data( 'dyn_link_deep_url' ))) {
			$data['dyn_link_deep_url'] = $this->get_data( 'dyn_link_deep_url' );
		}

		// ios_boundle_id
		if ( $this->has_data( 'ios_boundle_id' ) 
			&& !empty( $this->get_data( 'ios_boundle_id' ))) {
			$data['ios_boundle_id'] = $this->get_data( 'ios_boundle_id' );
		}

		// ios_appstore_id 
		if ( $this->has_data( 'ios_appstore_id ' ) 
			&& !empty( $this->get_data( 'ios_appstore_id ' ))) {
			$data['ios_appstore_id '] = $this->get_data( 'ios_appstore_id ' );
		}
	
	
		// save backend config
		if ( ! $this->Backend_config->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}
		/** 
		 * Upload Image Records 
		 */
		if ( !$id ) {
			if ( ! $this->insert_images( $_FILES, 'backend_config', $data['id'])) {
				// if error in saving image

					// commit the transaction
					$this->db->trans_rollback();
					
					return;
				}
			}


		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_backend_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_backend_add' ));
			}
		}

		
		redirect( site_url('/admin/backend_configs') );

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