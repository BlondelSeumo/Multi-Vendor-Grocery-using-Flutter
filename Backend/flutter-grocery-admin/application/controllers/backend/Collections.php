<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Collection Controller
 */
class Collections extends BE_Controller
{
	/**
	 * Construt required variables
	 */
	function __construct()
	{
		parent::__construct( MODULE_CONTROL, 'COLLECTIONS' );
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
		$this->data['rows_count'] = $this->Collection->count_all_by( $conds );

		// get discounts
		$this->data['collections'] = $this->Collection->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'collect_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Collection->count_all_by( $conds );

		// search data
		$this->data['collections'] = $this->Collection->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Create product one
	 */
	function add() {

		// no publish filter
		$conds['no_publish_filter'] = 1;

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'collect_add' );

		// get rows count
		$this->data['rows_count'] = $this->Product->count_all_by( $conds );

		// get Product
		$this->data['prds_list'] = $this->Product->get_all_by( $conds, 40, $this->uri->segment( 4 ) );

		// call the core add logic
		parent::add();
	}

	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save collection
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) {
	/** 
	* Insert collection Records 
	*/	
	// product check count
	$data['prdcheck'] = explode(",", $this->get_data( 'newchkval' ));

	$prdcheck = "";

	if($id == "") {
		//for first time save 
		$prdcheck = $data['prdcheck'][1];
	
	} else {
		//for edit case
		$prdcheck = $data['prdcheck'][0];

	}

	if($prdcheck != "") {

			$logged_in_user = $this->ps_auth->get_user_info();
			$data = array();
				$discount_percent = $this->get_data( 'percent' );
				$selected_shop_id = $this->session->userdata('selected_shop_id');

			if($id) {
				$check_count = $this->get_data( 'prdcheck' );
				$edit_collect_id = $id;
			}

			// prepare collect name
			if ( $this->has_data( 'name' )) {
				$data['name'] = $this->get_data( 'name' );
			}

			// if 'status' is checked,
			if ( $this->has_data( 'status' )) {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}

			$data['shop_id'] = $selected_shop_id['shop_id'];

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

			// save collect
			if ( ! $this->Collection->save( $data, $id )) {
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
			// if id is false, this is adding new record

				if ( ! $this->insert_images( $_FILES, 'collection', $data['id'] )) {
				// if error in saving image

					// commit the transaction
					$this->db->trans_rollback();
					
					return;
				}
			}

			//get inserted collection id
			$id = ( !$id )? $data['id']: $id ;

			// prepare product checkbox
			if ( $id ) {
				$data['prdcheck'] = explode(",", $this->get_data( 'newchkval' ));

				if(!$this->ps_delete->delete_prd_collection( $id )) {
				//loop
					for($i=0; $i<count($data['prdcheck']);$i++) {
						if($data['prdcheck'][$i] != "") {
							$check_data['collection_id'] = $id;
							$check_data['product_id'] = $data['prdcheck'][$i];
							$check_data['added_date'] = date("Y-m-d H:i:s");
							$check_data['added_user_id'] = $logged_in_user->user_id;

							$this->Productcollection->save($check_data);
						}

					}

				}

				
			}

			// commit the transaction
			if ( ! $this->check_trans()) {
	        	
				// set flash error message
				$this->set_flash_msg( 'error', get_msg( 'err_model' ));
			} else {

				if ( $edit_collect_id  ) {
				// if user id is not false, show success_add message
					
					$this->set_flash_msg( 'success', get_msg( 'success_collect_edit' ));
				} else {
				// if user id is false, show success_edit message
					
					$this->set_flash_msg( 'success', get_msg( 'success_collect_add' ));
				}
			}

			redirect( $this->module_site_url());
		} else {
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'please_select_product' ) );
				if ( !$id ){
					redirect( site_url() . '/admin/collections/add');
				} else {
					redirect( site_url() . '/admin/collections/edit/' . $id);
				}
		}

	}

	

	/**
	 * Update the existing one
	 */
	/**
 	* Update the existing one
	*/
	function edit( $id ) {

	// no publish filter
	$conds['no_publish_filter'] = 1;

	// breadcrumb urls
	$this->data['action_title'] = get_msg( 'collect_edit' );

	// get rows count
	$this->data['rows_count'] = $this->Product->count_all_by( $conds );

	// get Product
	$this->data['prds_list'] = $this->Product->get_all_by( $conds, 40, $this->uri->segment( 5 ) );

		// load user
	$this->data['collection'] = $this->Collection->get_one( $id );

	// call the parent edit logic
	parent::edit( $id );
	}

	/**
	 * Delete the record
	 * 1) delete collection
	 * 2) delete image from folder and table
	 * 3) check transactions
	 */
	function delete( $collection_id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		if ( !$this->ps_delete->delete_collection( $collection_id )) {

			// set error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));

			// rollback
			$this->trans_rollback();

			// redirect to list view
			redirect( $this->module_site_url());
		}

		//Need to product collection table delete by id
		$conds['collection_id'] = $collection_id;
		if ( !$this->Productcollection->delete_by( $conds )) {
			// rollback
			$this->db->trans_rollback();

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
        	
			$this->set_flash_msg( 'success', get_msg( 'success_cat_delete' ));
		}
		
		redirect( $this->module_site_url());
	}


	/**
	 * Delete all the news under collection
	 *
	 * @param      integer  $category_id  The collection identifier
	 */
	function delete_all( $collection_id = 0 )
	{
		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete collection and images
		$enable_trigger = true; 

		/** Note: enable trigger will delete news under collection and all news related data */
		if ( $this->ps_delete->delete_prd_collection( $collection_id, $enable_trigger ) ) {
		// if error in deleting category,

			// set error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));

			// rollback
			 $this->trans_rollback();

			// redirect to list view
			redirect( $this->module_site_url());
		}

		if ( !$this->ps_delete->delete_collection( $collection_id, $enable_trigger )) {
		// if error in deleting collection,

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
        	
			$this->set_flash_msg( 'success', get_msg( 'success_collect_delete' ));
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
	 * Check collection name via ajax
	 *
	 * @param      boolean  $Collection_id  The cat identifier
	 */
	function ajx_exists( $id = false )
	{
		// get collection name
		$name = $_REQUEST['name'];

		if ( $this->is_valid_name( $name, $id )) {
		// if the collection name is valid,
			
			echo "true";
		} else {
		// if invalid collection name,
			
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
	function is_valid_name( $name, $id = 0, $shop_id = 0 )
	{		
		$conds['name'] = $name;
     	$selected_shop_id = $this->session->userdata('selected_shop_id');
     	$shop_id = $selected_shop_id['shop_id'];
     	$conds['shop_id'] = $shop_id;

			if ( strtolower( $this->Collection->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Collection->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
			return true;
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $collection_id  The collection identifier
	 */
	function ajx_publish( $collection_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$collection_data = array( 'status'=> 1 );
			
		// save data
		if ( $this->Collection->save( $collection_data, $collection_id )) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $collection_id  The collection identifier
	 */
	function ajx_unpublish( $collection_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$collection_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->Collection->save( $collection_data, $collection_id )) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
}