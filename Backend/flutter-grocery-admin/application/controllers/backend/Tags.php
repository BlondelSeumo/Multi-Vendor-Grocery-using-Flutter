<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * tags Controller
 */
class Tags extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'TAGS' );
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
		$this->data['rows_count'] = $this->Tag->count_all_by( $conds );

		// get tags
		$this->data['tags'] = $this->Tag->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::tags_index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {

		// breadcrumb urls
		$data['action_title'] = get_msg( 'tag_search' );

		// condition with search term
		if($this->input->post('submit') != NULL ){

			$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )));

			if($this->input->post('searchterm') != "") {
				$conds['searchterm'] = $this->input->post('searchterm');
				$this->data['searchterm'] = $this->input->post('searchterm');
				$this->session->set_userdata(array("searchterm" => $this->input->post('searchterm')));
			} else {
				
				$this->session->set_userdata(array("searchterm" => NULL));
			}
		} else {
			//read from session value
			if($this->session->userdata('searchterm') != NULL){
				$conds['searchterm'] = $this->session->userdata('searchterm');
				$this->data['searchterm'] = $this->session->userdata('searchterm');
			}
		}

		$this->data['rows_count'] = $this->Tag->count_all_by( $conds );

		$this->data['tags'] = $this->Tag->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ));
		
		parent::tags_search();
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'tag_add' );

		// call the core add logic
		parent::shoptagadd();
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

		// prepare tag name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}
		
		// if 'status' is checked,
	     if ( $this->has_data( 'status' )) {
	      $data['status'] = 1;
	     } else {
	      $data['status'] = 0;
	     }
		
		// set timezone
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

		//save Tag
		if ( ! $this->Tag->save( $data, $id )) {
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
			
			if ( ! $this->insert_images_icon_and_cover( $_FILES, 'tag', $data['id'], "cover" )) {
				// if error in saving image

				// commit the transaction
				$this->db->trans_rollback();
				
				return;
			}


			if ( ! $this->insert_images_icon_and_cover( $_FILES, 'tag-icon', $data['id'], "icon" )) {
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
				
				$this->set_flash_msg( 'success', get_msg( 'success_tag_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_tag_add' ));
			}
		}

		redirect( site_url('/admin/tags'));
	}

	/**
 	* Update the existing one
	*/
	function edit( $id ) 
	{

		// load user
		$this->data['tag'] = $this->Tag->get_one( $id );

		// call the parent edit logic
		parent::tagedit( $id );

	}
/**
	 * Delete the record
	 * 1) delete Tag
	 * 2) delete image from folder and table
	 * 3) check transactions
	 */
	function delete( $id ) {

	    // start the transaction
	    $this->db->trans_start();

	    // check access
	    $this->check_access( DEL );

	    // enable trigger to delete all products related data
	    $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_tag( $id, $enable_trigger )) {
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
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_tag_delete' ));
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

			if ( strtolower( $this->Tag->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Tag->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
			return true;
	}

	/**
	 * Check Tag name via ajax
	 *
	 * @param      boolean  $tag_id  The tag identifier
	 */
	function ajx_exists( $id = false )
	{
		// get Tag name
		$tag_name = $_REQUEST['name'];

		if ( $this->is_valid_name( $tag_name, $id )) {
		// if the Tag name is valid,
			
			echo "true";
		} else {
		// if invalid Tag name,
			
			echo "false";
		}
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $Tag_id  The Tag identifier
	 */
	function ajx_publish( $tag_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$tag_data = array( 'status'=> 1 );
			
		// save data
		if ( $this->Tag->save( $tag_data, $tag_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $Tag_id  The Tag identifier
	 */
	function ajx_unpublish( $tag_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$tag_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->Tag->save( $tag_data, $tag_id )) {
			echo true;
		} else {
			echo false;
		}
	}
}