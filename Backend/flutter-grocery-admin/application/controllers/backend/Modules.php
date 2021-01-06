<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modules Controller
 */
class Modules extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'MODULES' );
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
		$this->data['rows_count'] = $this->Module->count_all_by( $conds );

		// get modules
		$this->data['modules'] = $this->Module->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::module_index( );
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'module_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );

		// pagination
		$this->data['rows_count'] = $this->Module->count_all_by( $conds );

		// search data

		$this->data['modules'] = $this->Module->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::module_search( );
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'module_add' );

		// call the core add logic
		parent::moduleadd();
	}

	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save module
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $module_id = false ) {
		// start the transaction
		$this->db->trans_start();
		/** 
		 * Insert module Records 
		 */
		$data = array();

		// prepare module name
		if ( $this->has_data( 'module_name' )) {
			$data['module_name'] = $this->get_data( 'module_name' );
		}

		// prepare module desc
		if ( $this->has_data( 'module_desc' )) {
			$data['module_desc'] = $this->get_data( 'module_desc' );
		}

		// prepare module_lang_key
		if ( $this->has_data( 'module_lang_key' )) {
			$data['module_lang_key'] = $this->get_data( 'module_lang_key' );
		}

		// prepare ordering
		if ( $this->has_data( 'ordering' )) {
			$data['ordering'] = $this->get_data( 'ordering' );
		}

		// prepare group_id
		if ( $this->has_data( 'group_id' )) {
			$data['group_id'] = $this->get_data( 'group_id' );
		}

		// if 'is_show_on_menu' is checked,
		if ( $this->has_data( 'is_show_on_menu' )) {
			$data['is_show_on_menu'] = 1;
		} else {
			$data['is_show_on_menu'] = 0;
		}

		//save module
		if ( ! $this->Module->save( $data, $module_id )) {
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

			if ( $module_id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_module_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_module_add' ));
			}
		}

		redirect( $this->module_site_url());
	}

	/**
 	* Update the existing one
	*/
	function edit( $module_id ) 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'module_edit' );

		// load user
		$this->data['mod'] = $this->Module->get_one( $module_id );

		// call the parent edit logic
		parent::moduleedit( $module_id );

	}

	
	 /**
  	* Delete the record
  	* 1) delete module
  	* 2) check transactions
  	*/
  	function delete( $module_id ) {

	    // start the transaction
	    $this->db->trans_start();

	    // check access
	    $this->check_access( DEL );

	    // enable trigger to delete all products related data
	    $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_module( $module_id, $enable_trigger )) {
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
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_module_delete' ));
	    }

	    redirect( $this->module_site_url());
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $module_id = 0 ) 
	{
		
		$rule = 'required|callback_is_valid_name['. $module_id  .']';

		$this->form_validation->set_rules( 'module_name', get_msg( 'name' ), $rule);
		
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
	function is_valid_name( $name, $module_id = 0 )
	{		
		 $conds['module_name'] = $name;
			if ( strtolower( $this->Module->get_one( $module_id )->module_name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Module->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
			return true;
	}

	/**
	 * Check module name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	 */
	function ajx_exists( $module_id = false )
	{
		// get module name
		$name = $_REQUEST['module_name'];

		if ( $this->is_valid_name( $name, $module_id )) {
		// if the module name is valid,
			
			echo "true";
		} else {
		// if invalid module name,
			
			echo "false";
		}
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $category_id  The category identifier
	 */
	function ajx_publish( $module_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$module_data = array( 'is_show_on_menu'=> 1 );
			
		// save data
		if ( $this->Module->save( $module_data, $module_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $category_id  The category identifier
	 */
	function ajx_unpublish( $module_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$module_data = array( 'is_show_on_menu'=> 0 );
			
		// save data
		if ( $this->Module->save( $module_data, $module_id )) {
			echo true;
		} else {
			echo false;
		}
	}

}