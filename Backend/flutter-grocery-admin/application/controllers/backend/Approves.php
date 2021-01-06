<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Approves extends BE_Controller {
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'SHOP' );
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
	function index() {
		
		// no publish filter
		$conds['no_publish_filter'] = 2;
		// get rows count
		$this->data['rows_count'] = $this->Shop->count_all_by( $conds );

		// get approval
		$this->data['approval'] = $this->Shop->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::approvelist();

	}

	/**
 	* Update the existing one
	*/
	function edit( $id ) 
	{
		// load user
		$this->data['shop'] = $this->Shop->get_one( $id );
		$conds['shop_id'] = $id;
		$user_id = $this->User_shop->get_one_by($conds)->user_id;
		$this->data['user'] = $this->User->get_one( $user_id );
		$this->data['id'] = $id;
		$this->data['user_id'] = $user_id;

		// call the parent edit logic
		parent::approveedit( $id, $user_id );

	}

	/**
	 * Saving Logic
	 * 1) save about data
	 * 2) check transaction status
	 *
	 * @param      boolean  $id  The about identifier
	*/
	function save( $id = false, $user_id= false ) {

		// start the transaction
		$this->db->trans_start();
		
		$shop_data = array();
		if ( $this->get_data( 'id' )) {
			$shop_data['id'] = $this->get_data( 'id' );
		}

		// prepare shop status
		if ( $this->has_data( 'status' )) {
			$shop_data['status'] = $this->get_data( 'status' );
		}

		//prepare user_id
		if ( $this->get_data( 'user_id' )) {
			$user_data['user_id'] = $this->get_data( 'user_id' );
		}

		if ( $shop_data['status'] == 1 ) {
			$user_data['is_shop_admin'] = 1;
			$user_data['status'] = 1;
		}


		if ( $shop_data['status'] == 3 ) {
			$user_data['is_shop_admin'] = 0;
			$user_data['status'] = 0;
		}

		// save shop
		if ( ! $this->Shop->save( $shop_data, $id )) {
		
			// rollback the transaction
			//$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model');
			
			return;
		}

		// save user
		if ( ! $this->User->save( $user_data, $user_id )) {
		
			// rollback the transaction
			//$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model');
			
			return;
		}

		//Sending Email To user
		$this->load->library( 'PS_Mail' );
		$to_who = "user";

		if ( $shop_data['status'] == 1 ) {

			$subject = get_msg('shop_approve');

		} elseif ( $shop_data['status'] == 3 ){

			$subject = get_msg('shop_reject');

		}

		$status = $shop_data['status'];

		if ( !send_shop_approval_emails( $shop_id, $to_who, $subject, $status )) {

			$this->set_flash_msg( 'error', get_msg( 'err_email_not_send_to_user' ));
		
		}

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_register_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_register_add' ));
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