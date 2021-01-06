<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Grocery_branches Controller
 */
class Grocery_branches extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'GROCERY_BRANCHES' );
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

		 $selected_shop_id = $this->session->userdata('selected_shop_id');
		 $shop_id = $selected_shop_id['shop_id'];

		 $conds['shop_id'] = $shop_id;
		// get rows count
		$this->data['rows_count'] = $this->Grocery_branch->count_all_by( $conds );

		// get categories
		$this->data['branches'] = $this->Grocery_branch->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		$this->data['selected_shop_id'] = $shop_id;

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'branch_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;

		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

	 	$conds['shop_id'] = $shop_id;

		// pagination
		$this->data['rows_count'] = $this->Grocery_branch->count_all_by( $conds );

		// search data

		$this->data['branches'] = $this->Grocery_branch->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );

		$this->data['selected_shop_id'] = $shop_id;
		
		// load add list
		parent::search();
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'branch_add' );

		// call the core add logic
		parent::add();
	}

	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save restaurant branch
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
		 * Insert Branch Records 
		 */
		$data = array();
		$selected_shop_id = $this->session->userdata('selected_shop_id');

		// prepare rest name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}

		// prepare description
		if ( $this->has_data( 'description' )) {
			$data['description'] = $this->get_data( 'description' );
		}

		// prepare address
		if ( $this->has_data( 'address' )) {
			$data['address'] = $this->get_data( 'address' );
		}

		// prepare phone
		if ( $this->has_data( 'phone' )) {
			$data['phone'] = $this->get_data( 'phone' );
		}

		// if 'status' is checked,
		if ( $this->has_data( 'status' )) {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
		}
		
		// set timezone
		$data['shop_id'] = $selected_shop_id['shop_id'];
		$data['added_user_id'] = $logged_in_user->user_id;

		if($id == "") {
			//save
			$data['added_date'] = date("Y-m-d H:i:s");
		} else {
			//edit
			unset($data['added_date']);
			$data['updated_date'] = date("Y-m-d H:i:s");
			$data['updated_user_id'] = $logged_in_user->user_id;
		}

		//save category
		if ( ! $this->Grocery_branch->save( $data, $id )) {
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
			if ( ! $this->insert_images( $_FILES, 'restaurant-branch', $data['id'] )) {
				// if error in saving image

					// commit the transaction
					$this->db->trans_rollback();
					
					return;
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
				
				$this->set_flash_msg( 'success', get_msg( 'success_branch_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_branch_add' ));
			}
		}

		redirect( $this->module_site_url());
	}

	/**
 	* Update the existing one
	*/
	function edit( $id ) 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'branch_edit' );

		// load user
		$this->data['branch'] = $this->Grocery_branch->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );

	}

	/**
	 * Delete the record
	 * 1) delete category
	 * 2) delete image from folder and table
	 * 3) check transactions
	 */
	function delete( $restaurant_id ) {

		// start the transaction
		$this->db->trans_start();
		// check access
		$this->check_access( DEL );

		// enable trigger to delete all products related data
	    // $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_Grocery_branch( $restaurant_id, $enable_trigger )) {
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
        	
			$this->set_flash_msg( 'success', get_msg( 'success_branch_delete' ));
		}
		
		redirect( $this->module_site_url());
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) 
	{
		
		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'name', get_msg( 'name' ), $rule);
		
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
		 $conds['name'] = $name;
		if ($id) {
			if ( strtolower( $this->Grocery_branch->get_one( $id )->name ) == rtrim(strtolower( $name ))) {
				
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Grocery_branch->exists( ($conds ))) {
				
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
		} else {
			if ( $this->Grocery_branch->exists( ($conds ))) {
				
				// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
		}
			
			return true;
	}

	/**
	 * Check restaurant name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	 */
	function ajx_exists( $id = false )
	{
		// get restaurant name
		$name = $_REQUEST['name'];

		if ( $this->is_valid_name($name, $id )) {
		// if the restaurant name is valid,
			
			echo "true";
		} else {
		// if invalid restaurant name,
			
			echo "false";
		}
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $restaurant_id  The restaurant identifier
	 */
	function ajx_publish( $restaurant_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$restaurant_data = array( 'status'=> 1 );
			
		// save data
		if ( $this->Grocery_branch->save( $restaurant_data, $restaurant_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $restaurant_id  The category identifier
	 */
	function ajx_unpublish( $restaurant_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$restaurant_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->Grocery_branch->save( $restaurant_data, $restaurant_id )) {
			echo true;
		} else {
			echo false;
		}
	}
}