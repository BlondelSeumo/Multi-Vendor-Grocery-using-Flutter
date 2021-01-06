<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Languages Controller
 */
class Languages extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'language_module' );
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
		$this->session->unset_userdata('language_id');
		// no publish filter
		$conds['no_publish_filter'] = 1;
		// get rows count
		$this->data['rows_count'] = $this->Language->count_all_by( $conds );
		
		// get languages
		$this->data['languages'] = $this->Language->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::language_index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'lang_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Language->count_all_by( $conds );

		// search data
		$this->data['languages'] = $this->Language->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::language_search();
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'lang_add' );

		// call the core add logic
		parent::languageadd();
	}

	/**
	 * Update the existing one
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'lang_edit' );

		// load user
		$this->data['lang'] = $this->Language->get_one( $id );

		// call the parent edit logic
		parent::language_edit( $id );
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

		// prepare symbol
		if ( $this->has_data( 'symbol' )) {
			$data['symbol'] = $this->get_data( 'symbol' );
		}

		// prepare name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}

		// save language
		if ( ! $this->Language->save( $data, $id )) {
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
				
				$this->set_flash_msg( 'success', get_msg( 'success_lang_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_lang_add' ));
			}
		}

		redirect( $this->module_site_url());
	}

	// /**
	//  * Delete the record
	//  * 1) delete category
	//  * 2) delete image from folder and table
	//  * 3) check transactions
	//  */
	// function delete( $id ) {

	// 	// start the transaction
	// 	$this->db->trans_start();

	// 	// check access
	// 	$this->check_access( DEL );

	// 	// delete languages and images
	// 	if ( !$this->ps_delete->delete_language( $id )) {

	// 		// set error message
	// 		$this->set_flash_msg( 'error', get_msg( 'err_model' ));

	// 		// rollback
	// 		$this->trans_rollback();

	// 		// redirect to list view
	// 		redirect( $this->module_site_url());
	// 	}
			
	// 	/**
	// 	 * Check Transcation Status
	// 	 */
	// 	if ( !$this->check_trans()) {

	// 		$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
	// 	} else {
        	
	// 		$this->set_flash_msg( 'success', get_msg( 'success_lang_delete' ));
	// 	}
		
	// 	redirect( $this->module_site_url());
	// }

	/**
	 * Delete all the news under category
	 *
	 * @param      integer  $category_id  The category identifier
	 */
	function delete_all( $id = 0 )
	{
		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		$enable_trigger = true; 

		// delete languages and images
		if ( !$this->ps_delete->delete_language( $id, $enable_trigger )) {

			// set error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));

			// rollback
			$this->trans_rollback();

			// redirect to list view
			redirect( $this->module_site_url());
		}
			
		/**
		 * Check Transcation Status
		 */
		if ( !$this->check_trans()) {

			$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
		} else {
        	
			$this->set_flash_msg( 'success', get_msg( 'success_lang_delete' ));
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
	function is_valid_name( $name, $symbol, $id = 0 )
	{		
		if (isset($name)) {
			$conds['name'] = $name;
			
		 	if( $id != "") {
		 		// echo "bbbb";die;
				if ( strtolower( $this->Language->get_one( $id )->name ) == strtolower( $name )) {
				// if the name is existing name for that user id,
					return true;
				} else {
					$data = $this->Language->lang_exists($conds)->result();
					if(!empty($data)){
						// if the name is existed in the system,
						$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
						return false;
					}
				}
			} else {
				// echo "aaaa";die;
				$data = $this->Language->lang_exists($conds)->result();
				if(!empty($data)){
					// if the name is existed in the system,
					$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
					return false;
				}
			}
		}
		
		if (isset($symbol)) {
			$conds['symbol'] = $symbol;
		 	if( $id != "") {
		 		// echo "bbbb";die;
				if ( strtolower( $this->Language->get_one( $id )->symbol ) == strtolower( $symbol )) {
				// if the name is existing name for that user id,
					return true;
				} 
			} else {
				// echo "aaaa";die;
				$data = $this->Language->symbol_exists($conds)->result();
				if(!empty($data)){
					// if the name is existed in the system,
					$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
					return false;
				} 
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

		$name = $_REQUEST['name'];
		$symbol = $_REQUEST['symbol'];

		if ( $this->is_valid_name( $name, $symbol, $id )) {

		// if the language name is valid,
			
			echo "true";
		} else {
		// if invalid language name,
			
			echo "false";
		}
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $id  The language identifier
	 */
	function ajx_publish( $id = 0 )
	{

		// check access
		$this->check_access( PUBLISH );
		$lang_ids = $this->Language->get_all_not_in_lang( $id )->result();
		if ($lang_ids != "") {
			foreach ($lang_ids as $lang) {
				$lang_id = $lang->id;
				// prepare data
				$lang_data = array( 'status'=> 0 );
				$this->Language->save( $lang_data, $lang_id );
			}
		}

		// prepare data
		$data = array( 'status'=> 1 );
			
		// save data
		if ( $this->Language->save( $data, $id )) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $id  The language identifier
	 */
	function ajx_unpublish( $id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		$lang_ids = $this->Language->get_all_not_in_lang( $id )->result();
		
		foreach ($lang_ids as $lang) {
			$lang_id = $lang->id;
			// prepare data
			$lang_data = array( 'status'=> 1 );
			$this->Language->save( $lang_data, $lang_id );
		}
		
		// prepare data
		$lang_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->Language->save( $lang_data, $id )) {
			echo 'true';
		} else {
			echo 'false';
		}
	}

}
?>