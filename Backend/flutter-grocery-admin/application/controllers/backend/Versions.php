<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * version Controller
 */
class Versions extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'VERSIONS' );
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
	 * Create new one
	 */
	function add( $id = "1" ) {

		// breadcrumb urls
		
		if ( $this->is_POST()) {
		// if the method is post

			// server side validation
			if ( $this->is_valid_input()) {

				// save user info
				$this->save( "1" );
			}
		}


		$this->data['action_title'] = get_msg( 'tag_add' );
		$this->data['version'] = $this->Version->get_one( "1" );


		$this->load_template( 'versions/entry_form',$this->data, true );

		// call the core add logic
		//parent::versionadd();
	}

	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save Tag
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
		 * Insert Tag Records 
		 */
		$data = array();

		// prepare version no
		if ( $this->has_data( 'version_no' )) {
			$data['version_no'] = $this->get_data( 'version_no' );
		}

		// prepare version title
		if ( $this->has_data( 'version_title' )) {
			$data['version_title'] = $this->get_data( 'version_title' );
		}

		// prepare version message
		if ( $this->has_data( 'version_message' )) {
			$data['version_message'] = $this->get_data( 'version_message' );
		}
		
		// if 'version_force_update' is checked,
	    if ( $this->has_data( 'version_force_update' )) {
	      $data['version_force_update'] = 1;
	    } else {
	      $data['version_force_update'] = 0;
	    }

	    // if 'version_need_clear_data' is checked,
	    if ( $this->has_data( 'version_need_clear_data' )) {
	      $data['version_need_clear_data'] = 1;
	    } else {
	      $data['version_need_clear_data'] = 0;
	    }

	    // prepare deli_boy_version_no 
		if ( $this->has_data( 'deli_boy_version_no' )) {
			$data['deli_boy_version_no'] = $this->get_data( 'deli_boy_version_no' );
		}

	    // prepare deli boy version title
		if ( $this->has_data( 'deli_boy_version_title' )) {
			$data['deli_boy_version_title'] = $this->get_data( 'deli_boy_version_title' );
		}

		// prepare deli boy version message
		if ( $this->has_data( 'deli_boy_version_message' )) {
			$data['deli_boy_version_message'] = $this->get_data( 'deli_boy_version_message' );
		}
		
		// if 'deli_boy_version_force_update' is checked,
	    if ( $this->has_data( 'deli_boy_version_force_update' )) {
	      $data['deli_boy_version_force_update'] = 1;
	    } else {
	      $data['deli_boy_version_force_update'] = 0;
	    }

	    // if 'deli_boy_version_need_clear_data' is checked,
	    if ( $this->has_data( 'deli_boy_version_need_clear_data' )) {
	      $data['deli_boy_version_need_clear_data'] = 1;
	    } else {
	      $data['deli_boy_version_need_clear_data'] = 0;
	    }
		
		//save Tag
		if ( ! $this->Version->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		/** 
		 * Check Transactions 
		 */

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_version_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_version_add' ));
			}
		}

		redirect( site_url('/admin/versions/add') );
	}



	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	// function is_valid_input( $id = 0 ) 
	// {
		
	// 	return true;
	// }

	function is_valid_input( $id = 0 ) {
		
		$this->form_validation->set_rules( 'version_no', get_msg( 'version_no_required' ), 'required');

		$this->form_validation->set_rules( 'version_title', get_msg( 'version_title_required' ), 'required');

		$this->form_validation->set_rules( 'version_message', get_msg( 'version_message_required' ), 'required');

		

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,
			//echo "error"; die;
			return false;
		}

		return true;
	}

	/**
	 * Determines if valid name.
	 *
	 * @param      <type>   $name  The  name
	 * @param      integer  $id     The  identifier
	 *
	 * @return     boolean  True if valid name, False otherwise.
	 */
	// function is_valid_name( $name, $id = 0 )
	// {		
	// 	 $conds['name'] = $name;

	// 		if ( strtolower( $this->Tag->get_one( $id )->name ) == strtolower( $name )) {
	// 		// if the name is existing name for that user id,
	// 			return true;
	// 		} else if ( $this->Tag->exists( ($conds ))) {
	// 		// if the name is existed in the system,
	// 			$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
	// 			return false;
	// 		}
	// 		return true;
	// }

	
}