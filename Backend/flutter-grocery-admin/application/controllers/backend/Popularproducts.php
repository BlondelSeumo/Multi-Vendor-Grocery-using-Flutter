<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Popularproducts Controller
 */
class Popularproducts extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'Most Popular Products' );
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

		$this->data['selected_shop_id'] = $shop_id;
		// get rows count
		$this->data['rows_count'] = $this->Popularproduct->count_product_by($conds);
		// get categories
		$this->data['popularproducts'] = $this->Popularproduct->get_product_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'popular_prd_search' );
		
		// condition with search term
		if ($this->input->post('submit') != NULL ) {

			$conds = array( 'search_term' => $this->searchterm_handler( $this->input->post( 'search_term' )),
							'cat_id' => $this->searchterm_handler( $this->input->post( 'cat_id' )),
							'sub_cat_id' => $this->searchterm_handler( $this->input->post( 'sub_cat_id' )) );

			// condition passing date
			$conds['date'] = $this->input->post( 'date' );

			if($this->input->post('search_term') != "") {
				$conds['search_term'] = $this->input->post('search_term');
				$this->data['search_term'] = $this->input->post('search_term');
				$this->session->set_userdata(array("search_term" => $this->input->post('search_term')));
			} else {
				
				$this->session->set_userdata(array("search_term" => NULL));
			}


			if($this->input->post('cat_id') != ""  || $this->input->post('cat_id') != '0') {

				$conds['cat_id'] = $this->input->post('cat_id');
				$this->data['cat_id'] = $this->input->post('cat_id');
				$this->data['selected_cat_id'] = $this->input->post('cat_id');
				$this->session->set_userdata(array("cat_id" => $this->input->post('cat_id')));
				$this->session->set_userdata(array("selected_cat_id" => $this->input->post('cat_id')));

			} else {
				$this->session->set_userdata(array("cat_id" => NULL ));
			}

			if($this->input->post('sub_cat_id') != ""  || $this->input->post('sub_cat_id') != '0') {
				$conds['sub_cat_id'] = $this->input->post('sub_cat_id');
				$this->data['sub_cat_id'] = $this->input->post('sub_cat_id');
				$this->session->set_userdata(array("sub_cat_id" => $this->input->post('sub_cat_id')));
			} else {
				$this->session->set_userdata(array("sub_cat_id" => NULL ));
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
			if($this->session->userdata('search_term') != NULL){
				$conds['search_term'] = $this->session->userdata('search_term');
				$this->data['search_term'] = $this->session->userdata('search_term');
			}

			if($this->session->userdata('cat_id') != NULL){
				$conds['cat_id'] = $this->session->userdata('cat_id');
				$this->data['cat_id'] = $this->session->userdata('cat_id');
				$this->data['selected_cat_id'] = $this->session->userdata('cat_id');
			}

			if($this->session->userdata('sub_cat_id') != NULL){
				$conds['sub_cat_id'] = $this->session->userdata('sub_cat_id');
				$this->data['sub_cat_id'] = $this->session->userdata('sub_cat_id');
				$this->data['selected_cat_id'] = $this->session->userdata('cat_id');
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
		
		$this->data['selected_shop_id'] = $shop_id;

		// pagination
		$this->data['rows_count'] = $this->Popularproduct->count_product_by( $conds );
		// search data
		$this->data['popularproducts'] = $this->Popularproduct->get_product_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}
	/**
 	* Update the existing one
	*/
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'popular_prd_view' );

		// load user
		$this->data['popularproduct'] = $this->Product->get_one( $id );
		$this->data['product_id'] = $id;
		// call the parent edit logic
		parent::edit( $id );
	}

	function get_all_sub_categories($cat_id)
    {
    	$conds['cat_id'] = $cat_id;
    	$sub_categories = $this->Subcategory->get_all_by($conds);
		echo json_encode($sub_categories->result());
    }


}