<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coupons Controller
 */
class Coupons extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'COUPONS' );
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
		$this->data['rows_count'] = $this->Coupon->count_all_by( $conds );

		// get coupons
		$this->data['coupons'] = $this->Coupon->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'coupon_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;

		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

		$conds['shop_id'] = $shop_id;


		// pagination
		$this->data['rows_count'] = $this->Coupon->count_all_by( $conds );

		// search data

		$this->data['coupons'] = $this->Coupon->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Create new one
	 */
	function add() {
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'coupon_add' );

		// call the core add logic
		parent::add();
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
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		$logged_in_user = $this->ps_auth->get_user_info();
		
		/** 
		 * Insert coupon Records 
		 */
		$data = array();
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		
		// prepare coupon name
		if ( $this->has_data( 'coupon_name' )) {
			$data['coupon_name'] = $this->get_data( 'coupon_name' );
		}

		// prepare coupon order
		if ( $this->has_data( 'coupon_code' )) {
			$data['coupon_code'] = $this->get_data( 'coupon_code' );
		}


		// prepare coupon amount
		if ( $this->has_data( 'coupon_amount' )) {
			$data['coupon_amount'] = $this->get_data( 'coupon_amount' );
		}

		// if 'status' is checked,
		if ( $this->has_data( 'is_published' )) {
			$data['is_published'] = 1;
		} else {
			$data['is_published'] = 0;
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

		//save coupon
		if ( ! $this->Coupon->save( $data, $id )) {
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
				
				$this->set_flash_msg( 'success', get_msg( 'success_coupon_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_coupon_add' ));
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
		$this->data['action_title'] = get_msg( 'coupon_edit' );

		// load user
		$this->data['coupon'] = $this->Coupon->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );

	}

	
	 /**
  	* Delete the record
  	* 1) delete coupon
  	* 2) check transactions
  	*/
  	function delete( $id ) {

	    // start the transaction
	    $this->db->trans_start();

	    // check access
	    $this->check_access( DEL );

	    // enable trigger to delete all products related data
	    $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_coupon( $id, $enable_trigger )) {
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
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_coupon_delete' ));
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

		$this->form_validation->set_rules( 'coupon_name', get_msg( 'name' ), $rule);
		
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
	function is_valid_name( $name, $id = 0, $shop_id = 0 )
	{		
		 $conds['coupon_name'] = $name;
		 $selected_shop_id = $this->session->userdata('selected_shop_id');
		 $shop_id = $selected_shop_id['shop_id'];
		 $conds['shop_id'] = $shop_id;
		 
			if ( strtolower( $this->Coupon->get_one( $id )->coupon_name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Coupon->exists( ($conds ))) {
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
	function ajx_exists( $id = false )
	{
		// get coupon name
		$name = $_REQUEST['coupon_name'];
		//get shop_id
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

		if ( $this->is_valid_name( $name, $id, $shop_id )) {
		// if the coupon name is valid,
			
			echo "true";
		} else {
		// if invalid coupon name,
			
			echo "false";
		}
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $coupon_id  The coupon identifier
	 */
	function ajx_publish( $coupon_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$coupon_data = array( 'is_published'=> 1 );
			
		// save data
		if ( $this->Coupon->save( $coupon_data, $coupon_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $coupon_id  The coupon identifier
	 */
	
	function ajx_unpublish( $coupon_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$coupon_data = array( 'is_published'=> 0 );
			
		// save data
		if ( $this->Coupon->save( $coupon_data, $coupon_id )) {
			echo true;
		} else {
			echo false;
		}
	}
}