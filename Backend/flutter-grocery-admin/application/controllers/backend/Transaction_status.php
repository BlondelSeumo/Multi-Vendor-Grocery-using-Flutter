<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Transaction_status Controller
 */
class Transaction_status extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'TRANSACTION_STATUS' );
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
		
		// get rows count
		$this->data['rows_count'] = $this->Transactionstatus->count_all_by( $conds );
		
		// get deliveries
		$this->data['transactionstatus'] = $this->Transactionstatus->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::transaction_list();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'trans_status_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
	
		// pagination
		$this->data['rows_count'] = $this->Transactionstatus->count_all_by( $conds );

		// search data
		$this->data['transactionstatus'] = $this->Transactionstatus->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::transaction_search();
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'trans_status_add' );

		// call the core add logic
		parent::transaction_add();
	}

	/**
	 * Update the existing one
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'trans_status_edit' );

		// load user
		$this->data['trans_status'] = $this->Transactionstatus->get_one( $id );

		// call the parent edit logic
		parent::transaction_edit( $id );
	}

	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save language
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert Language Records 
		 */
		$data = array();

		// prepare id
		if ( $this->has_data( 'id' )) {
			$data['id'] = $this->get_data( 'id' );
		}

		// prepare title
		if ( $this->has_data( 'title' )) {
			$data['title'] = $this->get_data( 'title' );
		}

		// prepare ordeing
		if ( $this->has_data( 'ordering' )) {
			$data['ordering'] = $this->get_data( 'ordering' );
		}

		// color value
		if ( $this->has_data( 'color_value' )) {
			$data['color_value'] = $this->get_data( 'color_value' );
		}

		// if 'start_stage' is checked,	
		if ($this->input->post('status') == 'start_stage') {
			$data['start_stage'] = 1;
			$data['final_stage'] = 0;
		}

		// if 'final_stage' is checked,	
		if ($this->input->post('status') == 'final_stage') {
			$data['final_stage'] = 1;
			$data['start_stage'] = 0;
		}

		// save language
		if ( ! $this->Transactionstatus->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		if ($data['start_stage'] == 1) {
			if($id){
				$conds['id'] = $id;
				$this->Transactionstatus->update_start_stage($conds);
			} else {
				$conds['id'] = $data['id'];
				$this->Transactionstatus->update_start_stage($conds);
			}
		}

		if ($data['final_stage'] == 1) {
			if($id){
				$conds['id'] = $id;
				$this->Transactionstatus->update_final_stage($conds);
			} else {
				$conds['id'] = $data['id'];
				$this->Transactionstatus->update_final_stage($conds);
			}
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
				
				$this->set_flash_msg( 'success', get_msg( 'success_trans_status_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_trans_status_add' ));
			}
		}
		

		redirect( $this->module_site_url());
	}

	/**
	 * Delete
	 *
	 * @param      integer  $category_id  The category identifier
	 */
	function delete( $id = 0 )
	{
		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		$enable_trigger = false; 

		$start_stage = $this->Transactionstatus->get_one($id)->start_stage;
		$final_stage = $this->Transactionstatus->get_one($id)->final_stage;

		if($start_stage == 0 && $final_stage == 0){
			
			if ( !$this->ps_delete->delete_transaction_status( $id, $enable_trigger )) {

				// set error message
				$this->set_flash_msg( 'error', get_msg( 'err_model' ));

				// rollback
				$this->trans_rollback();

				// redirect to list view
				redirect( $this->module_site_url());
			}
			

		}

		/**
		 * Check Transcation Status
		 */
		if ( !$this->check_trans()) {

			$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
		} else {
			if($start_stage == 1){
				$this->set_flash_msg( 'error', get_msg( 'start_stage_delete' ));
			}elseif ($final_stage == 1) {
				$this->set_flash_msg( 'error', get_msg( 'final_stage_delete' ));
			}else{
			$this->set_flash_msg( 'success', get_msg( 'success_trans_status_delete' ));

			}
				        	
		}

		redirect( $this->module_site_url());

	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'title', get_msg( 'name' ), $rule);

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

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
	function is_valid_name( $name, $id = 0 )
	{		
	
		$conds['title'] = $name;
	 	if( $id != "") {
	 		// echo "bbbb";die;
			if ( strtolower( $this->Transactionstatus->get_one( $id )->title ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} 
		} else {
			// echo "aaaa";die;
			if ( $this->Transactionstatus->exists( ($conds ))) {

			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
		}
	
		
		return true;
	}

	/**
	 * Check language name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	 */
	function ajx_exists( $id = false )
	{
		// get language name

		$name = $_REQUEST['title'];

		if ( $this->is_valid_name( $name, $id )) {

		// if the language name is valid,
			
			echo "true";
		} else {
		// if invalid language name,
			
			echo "false";
		}
	}

}
?>