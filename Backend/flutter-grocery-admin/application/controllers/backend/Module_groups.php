<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Module_groups Controller
 */
class Module_groups extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'MODULE_GROUPS' );
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
		
		// no delete flag
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Module_group->count_all_by( $conds );

		// get groups
		$this->data['groups'] = $this->Module_group->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::modulegroup_index( );
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'group_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );

		// pagination
		$this->data['rows_count'] = $this->Module_group->count_all_by( $conds );

		// search data

		$this->data['groups'] = $this->Module_group->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::modulegroup_search( );
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'group_add' );

		// call the core add logic
		parent::modulegroupadd();
	}

	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save coupon
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $group_id = false ) {
		// start the transaction
		$this->db->trans_start();
		/** 
		 * Insert coupon Records 
		 */
		$data = array();

		// prepare group name
		if ( $this->has_data( 'group_name' )) {
			$data['group_name'] = $this->get_data( 'group_name' );
		}

		// prepare group icon
		if ( $this->has_data( 'group_icon' )) {
			$data['group_icon'] = $this->get_data( 'group_icon' );
		}

		// prepare group_lang_key
		if ( $this->has_data( 'group_lang_key' )) {
			$data['group_lang_key'] = $this->get_data( 'group_lang_key' );
		}

		//save module group
		if ( ! $this->Module_group->save( $data, $group_id )) {
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

			if ( $group_id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_group_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_group_add' ));
			}
		}

		redirect( $this->module_site_url());
	}

	/**
 	* Update the existing one
	*/
	function edit( $group_id ) 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'group_edit' );

		// load user
		$this->data['group'] = $this->Module_group->get_one( $group_id );

		// call the parent edit logic
		parent::modulegroupedit( $group_id );

	}

	
	 /**
  	* Delete the record
  	* 1) delete coupon
  	* 2) check transactions
  	*/
  	function delete( $group_id ) {

	    // start the transaction
	    $this->db->trans_start();

	    // check access
	    $this->check_access( DEL );

	    // enable trigger to delete all products related data
	    $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_module_group( $group_id, $enable_trigger )) {
	    // if there is an error in deleting products,

	     // rollback
	     $this->trans_rollback();

	     // error message
	     $this->set_flash_msg( 'error', get_msg( 'err_model' ));
	     redirect( $this->module_site_url());
	    }
	    /**
	    * Check Transcation Status
	    */
	  	if ( !$this->check_trans()) {

	     $this->set_flash_msg( 'error', get_msg( 'err_model' )); 
	    } else {
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_group_delete' ));
	    }

	    redirect( $this->module_site_url());
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $group_id = 0 ) 
	{
		
		$rule = 'required|callback_is_valid_name['. $group_id  .']';

		$this->form_validation->set_rules( 'group_name', get_msg( 'name' ), $rule);
		
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
	 * @param      integer  $group_id     The  identifier
	 *
	 * @return     boolean  True if valid name, False otherwise.
	 */
	function is_valid_name( $name, $group_id = 0 )
	{		
		 $conds['group_name'] = $name;

			if ( strtolower( $this->Module_group->get_one( $group_id )->group_name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Module_group->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
			return true;
	}

	/**
	 * Check coupon name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	 */
	function ajx_exists( $group_id = false )
	{
		// get coupon name
		$name = $_REQUEST['group_name'];

		if ( $this->is_valid_name( $name, $group_id )) {
		// if the coupon name is valid,
			
			echo "true";
		} else {
		// if invalid coupon name,
			
			echo "false";
		}
	}

}