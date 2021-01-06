<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Categories Controller
 */
class Contacts extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'CONTACTS' );
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
	 * List down conatct message
	 */
	function index() {


		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

		$conds['shop_id'] = $shop_id;

		// get rows count
		$this->data['rows_count'] = $this->Contact->count_all_by($conds);

		// get comments
		$this->data['contacts'] = $this->Contact->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::contacts_index();
		
	}

	/**
	 * Delete the record
	 * 1) delete comment
	 * 2) check transactions
	 */
	function delete( $con_id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		/**
		 * Delete comment
		 */
		if ( ! $this->Contact->delete( $con_id )) {
		// if there is an error in deleting news,
		
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
        	
			$this->set_flash_msg( 'success', get_msg( 'success_contact_delete' ));
		}
		
		redirect( $this->module_site_url());
	}


	/**
	* View Comment Detail
	*/
	function detail($con_id)
	{

		$contact = $this->Contact->get_one( $con_id );
		$this->data['contact'] = $contact;

		$this->load_template('contacts/detail', $this->data, true );
	}

}