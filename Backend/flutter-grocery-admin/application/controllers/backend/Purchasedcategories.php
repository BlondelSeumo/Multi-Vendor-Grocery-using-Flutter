<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Purchsedcategories Controller
 */
class Purchasedcategories extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'Most Purchase Categories' );
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
		$this->data['rows_count'] = $this->Purchasedcategory->count_purchased_category_by($conds);
		// get categories
		$this->data['purchasedcategories'] = $this->Purchasedcategory->get_purchased_category_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'purchased_cat_search' );
		
		// condition with search term
		$conds = array( 'search_term' => $this->searchterm_handler( $this->input->post( 'search_term' )) );
		// no publish filter

		//condition passing date
		$conds['no_publish_filter'] = 1;
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];

		$conds['shop_id'] = $shop_id;

		$conds['date'] = $this->input->post( 'date' );

		// pagination
		$this->data['rows_count'] = $this->Purchasedcategory->count_purchased_category_by( $conds );

		// search data
		$this->data['purchasedcategories'] = $this->Purchasedcategory->get_purchased_category_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}
	/**
	 	* Update the existing one
		*/
		function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'purchased_cat_view' );

		// load user
		$this->data['purchasedcategory'] = $this->Purchasedcategory->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
		}
}