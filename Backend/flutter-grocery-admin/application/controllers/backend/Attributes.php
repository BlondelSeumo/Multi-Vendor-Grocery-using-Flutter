<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Brands Controller
 */
class Attributes extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ATTRIBUTES' );
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
	function index($product_id = 0) {

		//breadcrumb urls
		$edit_product = get_msg('prd_edit');

		$list_attribute_header = get_msg('list_attribute_header');

		$product_list = get_msg('list_product_nav');


		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products"), 

			array( 'label' => $list_attribute_header, 'mod_name' => "attributes",'special_mod_name' => 'Products', 'special_mod_url' => $product_list) 
			
		);

		$conds['product_id'] = $product_id;
		
		// get rows count
		$this->data['rows_count'] = $this->Attribute->count_all_by( $conds );

		// get brands
		$this->data['attributes'] = $this->Attribute->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::att_header_index($product_id);
	}

	/**
	 * Searches for the first match.
	 */
	function search($product_id = 0) {

		$product_id = $this->get_data( 'product_id' );

		// breadcrumb urls
		$edit_product = get_msg('prd_edit');
		$product_list = get_msg('list_product_nav');

		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products" ), 
			array( 'url' => '/index/' . $product_id, 'label' => get_msg( 'list_attribute_header' ), 'mod_name' => 'attributes','special_mod_name' => 'Products', 'special_mod_url' => $product_list),
			array( 'label' => get_msg( 'att_search' ))
		);
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		//$conds['no_publish_filter'] = 1;

		$conds['product_id'] = $product_id;

		// pagination
		$this->data['rows_count'] = $this->Attribute->count_all_by( $conds );
		
		// search data
		$this->data['attributes'] = $this->Attribute->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		$this->data['product_id'] = $product_id;
		// load add list
		parent::attribute_search($product_id);
	}

	/**
	 * Create new one
	*/
	function add($product_id=0) {

		// breadcrumb urls
		$edit_product = get_msg('prd_edit');
		$product_list = get_msg('list_product_nav');

		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product ,'mod_name' => 'products'), 
			array( 'label' => get_msg( 'att_add' ), 'special_mod_name' => 'Products', 'special_mod_url' => $product_list)
		);

		$this->data['product_id'] = $product_id;

		// call the core add logic
		parent::add_att_header($product_id);
	}

	/**
	 * Update the existing one
	 */
	
	function edit( $id , $product_id = 0 ) {

		// breadcrumb urls
		$edit_product = get_msg('prd_edit');
		$product_list = get_msg('list_product_nav');
			
		$this->data['action_title'] = array( 
			array( 'url' => '/edit/'. $product_id, 'label' => $edit_product, 'mod_name' => "products"), 
			array(  'url' => '/index/'. $product_id, 'label' => get_msg('list_attribute_header'), 'mod_name' => "attributes", 'special_mod_name' => 'Products', 'special_mod_url' => $product_list),
			array( 'label' => get_msg( 'att_edit' ))
		);
		// load user
		$this->data['attribute'] = $this->Attribute->get_one( $id );
		$this->data['product_id'] = $product_id;
		
		// call the parent edit logic
		parent::att_edit( $id ,$product_id );
	}

	/**
	 * Delete the record
	 * 1) delete products
	 * 2) check transactions
	 */
	function delete( $attribute_id ) {
		$product_id = $this->Attribute->get_one( $attribute_id )->product_id;
		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// enable trigger to delete all products related data
		$enable_trigger = true;

		if ( ! $this->ps_delete->delete_attribute( $attribute_id, $enable_trigger )) {
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
        	
			$this->set_flash_msg( 'success', get_msg( 'success_att_delete' ));
		}
		
		redirect( site_url() . '/admin/attributes/index/'.$product_id);
	}

	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save product
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false , $product_id = 0 ) {

		$logged_in_user = $this->ps_auth->get_user_info();
		$selected_shop_id = $this->session->userdata('selected_shop_id');

		/** 
		 * Insert Product Records 
		 */	
		//Attribute Header id
		if ( $this->has_data( 'id' )) {
			$data['id'] = $this->get_data( 'id' );
		}	

		//Attribute Product id
		$data['product_id'] = $product_id;

		// prepare attribute name zawgyi
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}

		//Default Status is Publish 
		//$data['status'] = 1;

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
		if ( ! $this->Attribute->save( $data, $id )) {
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
				
				$this->set_flash_msg( 'success', get_msg( 'success_att_edit' ));
			} else {
			// if user id is false, show success_edit message
				
				$this->set_flash_msg( 'success', get_msg( 'success_att_add' ));
			}
		}
		
		redirect( site_url('/admin/attributes/index/' . $data['product_id']));
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'name', get_msg( 'name' ), $rule);
		$this->form_validation->set_rules( 'product_id', get_msg( 'product_id' ), 'required' );

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

		$product_id = $_REQUEST['product_id'];


		if ( $this->is_valid_name( $name, $id, $product_id )) {
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
	function is_valid_name( $name, $id = 0, $product_id )
	{		
		 $conds['name'] = $name;
		 $conds['product_id'] = $product_id;


			if ( strtolower( $this->Attribute->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} 
			else if ( $this->Attribute->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
			return true;
	}

}