<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Brands Controller
 */
class Attributedetails extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ATTRIBUTEDETAILS' );
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
	function index($header_id = 0,$product_id=0) {
		// print_r($header_id);
		// print_r($product_id);die;
		// no publish filter
		$conds['no_publish_filter'] = 1;

		$conds['header_id'] = $header_id;

		// breadcrumb urls
		$edit_product = get_msg('prd_edit');

		$list_attribute_header = get_msg('list_attribute_header');

		$product_list = get_msg('list_product_nav');


		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products"), 

			array( 'url' => '/index/'. $product_id, 'label' => $list_attribute_header, 'mod_name' => "attributes", 'special_mod_name' => 'Products', 'special_mod_url' => $product_list), 
			

			array( 'label' => get_msg( 'list_attribute_detail' ))
		);

		$this->$data['header_id'] = $header_id;
		$this->$data['product_id'] = $product_id;
		// get rows count
		$this->data['rows_count'] = $this->Attributedetail->count_all_by( $conds );

		// get brands
		$this->data['attdetails'] = $this->Attributedetail->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 6 ) );

		// load index logic
		parent::att_detail_index($header_id,$product_id);
	}

	/**
	 * Searches for the first match.
	 */
	function search( $header_id = 0,$product_id=0 ) {
		
		// breadcrumb urls
		$edit_product = get_msg('prd_edit');

		$list_attribute_header = get_msg('list_attribute_header');

		$product_list = get_msg('list_product_nav');


		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products"), 

			array( 'url' => '/index/'. $product_id, 'label' => $list_attribute_header, 'mod_name' => "attributes", 'special_mod_name' => 'Products', 'special_mod_url' => $product_list), 
			
			array( 'url' => '/index/'. $header_id .'/' . $product_id, 'label' => get_msg( 'list_attribute_detail' ), 'mod_name' => "attributedetails"),

			array( 'label' => get_msg( 'att_detail_search' )),
		);
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;
		$conds['product_id'] = $product_id;
		$conds['header_id'] = $header_id;

		$this->$data['product_id'] = $product_id;
		$this->$data['header_id'] = $header_id;
		// pagination
		$this->data['rows_count'] = $this->Attributedetail->count_all_by( $conds );

		// search data
		$this->data['attdetails'] = $this->Attributedetail->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::att_detail_search( $header_id,$product_id );
	}

	/**
	 * Create new one
	 */
	function add($header_id = 0,$product_id=0) {
		
		// breadcrumb urls
		$edit_product = get_msg('prd_edit');

		$attribute_header_list = get_msg('list_attribute_header');


		$product_list = get_msg('list_product_nav');

		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products"), 
			array(  'url' => '/index/'. $product_id, 'label' => $attribute_header_list, 'mod_name' => "attributes", 'special_mod_name' => "Products", 'special_mod_url' => $product_list),
			array( 'url' => '/index/' . $header_id , 'label' =>get_msg('list_attribute_detail'), 'mod_name' => "attributedetails"),
			array( 'label' => get_msg( 'add_att_detail' ))
		);

		$this->data['header_id'] = $header_id;
		$this->data['product_id'] = $product_id;

		$this->data['product_id'] = $this->Attribute->get_one_by(array("id" =>  $header_id ))->product_id;

		//special case
		parent::detail_add($header_id,$product_id);

	}
	
	/**
	 * Update the existing one
	 */
	/**
 	* Update the existing one
	*/
	function edit( $detail_id = 0, $header_id = 0, $product_id = 0 ) {

		// breadcrumb urls
		$edit_product = get_msg('prd_edit');
		$list_attribute_header = get_msg('list_attribute_header');
		$attribute_header_list = get_msg('att_hed_list');
		$product_list = get_msg('list_product_nav');

		$this->data['action_title'] = array(
			
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products"), 
			array( 'url' => '/index/'. $product_id, 'label' => $list_attribute_header, 'mod_name' => "attributes", 'special_mod_name' => "Products", 'special_mod_url' => $product_list),
			array( 'url' => '/index/' . $header_id , 'label' =>get_msg('list_attribute_detail'), 'mod_name' => "attributedetails"),
			array( 'label' => get_msg( 'attdetail_edit' ))
			
		);

		$this->data['header_id'] = $header_id;
		// load user
		$this->data['attdetail'] = $this->Attributedetail->get_one( $detail_id );

		$this->data['product_id'] = $this->data['attdetail']->product_id;
		// call the parent edit logic
		parent::detail_edit( $detail_id, $header_id, $product_id );
	}
		/**
	 * Delete the record
	 * 1) delete products
	 * 2) check transactions
	 */
	function delete( $attdetail_id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// enable trigger to delete all products related data
		$enable_trigger = true;

		$attribute_header_id = $this->Attributedetail->get_one( $attdetail_id )->header_id;
		$product_id = $this->Attributedetail->get_one( $attdetail_id )->product_id;


		if ( ! $this->ps_delete->delete_attdetail( $attdetail_id, $enable_trigger )) {
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
        	
			$this->set_flash_msg( 'success', get_msg( 'success_attdetail_delete' ));
		}
		
		redirect( site_url() . '/admin/attributedetails/index/'. $attribute_header_id .'/'. $product_id);
	}

	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save attribute
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
		function save( $id  = false, $header_id = 0 ,$product_id = 0) {
		
			$logged_in_user = $this->ps_auth->get_user_info();
			/** 
			 * Insert attribute Records 
			*/	

			// start the transaction
			$this->db->trans_start();

			//header_id
			$data['header_id'] = $header_id;
			$selected_shop_id = $this->session->userdata('selected_shop_id');
			
			//product_id
			if ( $this->has_data( 'product_id' )) {
				$data['product_id'] = $this->get_data( 'product_id' );
			}

			// prepare attribute name 
			if ( $this->has_data( 'name' )) {
				$data['name'] = $this->get_data( 'name' );
			}

			// prepare attribute price 
			if ( $this->has_data( 'additional_price' )) {
				$data['additional_price'] = $this->get_data( 'additional_price' );
			}

			// set timezone
			$data['added_user_id'] = $logged_in_user->user_id;

			$data['shop_id'] = $selected_shop_id['shop_id'];

			if($id == "") {
			//save
				$data['added_date'] = date("Y-m-d H:i:s");
			} else {
			//edit
				unset($data['added_date']);
				$data['updated_date'] = date("Y-m-d H:i:s");
				$data['updated_user_id'] = $logged_in_user->user_id;
			}

			// save Attribute
			if ( ! $this->Attributedetail->save( $data, $id )) {
			// if there is an error in inserting user data,	
				
				// rollback the transaction
				$this->db->trans_rollback();

				// set error message
				$this->data['error'] = get_msg( 'err_model' );
				
				return;
			}


			// commit the transaction
			if ( ! $this->check_trans()) {
	        	
				// set flash error message
				$this->set_flash_msg( 'error', get_msg( 'err_model' ));
			} else {

				if ( $id ) {
				// if user id is not false, show success_add message
					
					$this->set_flash_msg( 'success', get_msg( 'success_attdetail_edit' ));
				} else {
				// if user id is false, show success_edit message
					
					$this->set_flash_msg( 'success', get_msg( 'success_attdetail_add' ));
				}
			}


			redirect(site_url() . "/admin/attributedetails/index/" . $header_id . "/" . $product_id);
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'name', get_msg( 'name' ), $rule);
		$this->form_validation->set_rules( 'header_id', get_msg( 'header_id' ), 'required');

		// if ( $this->form_validation->run() == FALSE ) {
		// // if there is an error in validating,

		// 	return false;
		// }

		return true;
	}

	/**
	 * Check discount name via ajax
	 *
	 * @param      boolean  $product_id  The cat identifier
	 */
	function ajx_exists( $id = false )
	{
		
		$name = $_REQUEST['name'];
		$header_id = $_REQUEST['header_id'];

		if ( $this->is_valid_name( $name, $id, $header_id )) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/**
	 * Determines if valid name.
	 *
	 * @param      <type>   $name  The  name
	 * @param      integer  $id     The  identifier
	 *
	 * @return     boolean  True if valid name, False otherwise.
	 */
	function is_valid_name( $name, $id = 0, $header_id )
	{		
		$conds['name'] = $name;
		$conds['header_id'] = $header_id;

		if( $id != "") {

			if ( strtolower( $this->Attributedetail->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Attributedetail->exists( ($conds ))) {
				// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
		} else {

			if ( $this->Attributedetail->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
		} 
		
		return true;
	}
	

}