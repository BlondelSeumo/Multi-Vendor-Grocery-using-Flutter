<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments Controller
 */
class Comments extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'COMMENTS' );
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
		$conds['no_publish_filter'] = 1;
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

		$conds['shop_id'] = $shop_id;

		// get rows count
		$this->data['rows_count'] = $this->Commentheader->count_all_by( $conds );

		// get transactions
		$this->data['comments'] = $this->Commentheader->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}
	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'comm_search' );

		
		
		// condition with search term

		if ($this->input->post('submit') != NULL ) {

			$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )));

			// condition passing date
			$conds['date'] = $this->input->post( 'date' );

			if($this->input->post('searchterm') != "") {
				$conds['searchterm'] = $this->input->post('searchterm');
				$this->data['searchterm'] = $this->input->post('searchterm');
				$this->session->set_userdata(array("searchterm" => $this->input->post('searchterm')));
			} else {
				
				$this->session->set_userdata(array("searchterm" => NULL));
			}


			if($this->input->post('date') != "") {
				$conds['date'] = $this->input->post('date');
				$this->data['date'] = $this->input->post('date');
				$this->session->set_userdata(array("date" => $this->input->post('date')));
			} else {
				
				$this->session->set_userdata(array("date" => NULL));
			}


			// no publish filter
			$conds['no_publish_filter'] = 1;


		} else {

			//read from session value
			if($this->session->userdata('searchterm') != NULL){
				$conds['searchterm'] = $this->session->userdata('searchterm');
				$this->data['searchterm'] = $this->session->userdata('searchterm');
			}

			if($this->session->userdata('date') != NULL){
				$conds['date'] = $this->session->userdata('date');
				$this->data['date'] = $this->session->userdata('date');
			}

			// no publish filter
			$conds['no_publish_filter'] = 1;

		}

		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

		$conds['shop_id'] = $shop_id;

		// pagination
		$this->data['rows_count'] = $this->Commentheader->count_all_by( $conds );
		// search data
		$this->data['comments'] = $this->Commentheader->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 	* Update the existing one
		*/
		function edit( $id ) {
		
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'reply_cmt' );

		// load user
		
		$this->data['comm'] = $this->Commentheader->get_one( $id );

		
		$this->data['header_id'] = $id;
	
		// call the parent edit logic
		parent::edit( $id );

		}

		/**
	 * Saving Logic
	 * 1) reply comment
	 * 2) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) {
		
		//start the transaction
		$this->db->trans_start();
		
		$logged_in_user = $this->ps_auth->get_user_info();

		/** 
		 * Reply comment
		 */
		$data = array();

		// prepare reply comment
		if ( $this->has_data( 'detail_comment' )) {
			$data['detail_comment'] = $this->get_data( 'detail_comment' );
		}

		
		//header id
		if ( $this->has_data( 'header_id' )) {
			$data['header_id'] = $this->get_data( 'header_id' );
		}


		// set timezone
		$data['user_id'] = $logged_in_user->user_id;

		$comment_header_id = $data['header_id'];

		if($id == "") {
			//save
			$data['added_date'] = date("Y-m-d H:i:s");
		} 
		
		//reply comment
		$id = false;
		if (!$this->Commentdetail->save( $data, $id )) {
			$this->db->trans_rollback();
			return;
		}
		
			// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				//$this->set_flash_msg( 'success', get_msg( 'success_cat_edit' ));
			} else {
			// if user id is false, show success_edit message

				//$this->set_flash_msg( 'success', get_msg( 'success_cat_add' ));
			}
		}

	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		// $rule = 'required|callback_is_valid_name['. $id  .']';

		// $this->form_validation->set_rules( 'detail_comment_desc_zg', get_msg( 'detail_comment_desc_zg' ), $rule);
		// $this->form_validation->set_rules( 'detail_comment_desc_un', get_msg( 'detail_comment_desc_un' ), 'required' );

		// if ( $this->form_validation->run() == FALSE ) {
		// // if there is an error in validating,

		// 	return false;
		// }

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
		 // $conds['detail_comment_desc_zg'] = $name;

			// if ( strtolower( $this->Commentdetail->get_one( $id )->detail_comment_desc_zg ) == strtolower( $name )) {
			// // if the name is existing name for that user id,
			// 	return true;
			// } else if ( $this->Commentdetail->exists( ($conds ))) {
			// // if the name is existed in the system,
			// 	$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
			// 	return false;
			// }
			return true;
	}


	
}