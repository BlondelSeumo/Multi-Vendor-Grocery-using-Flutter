<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for News
 */
class Products extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Product' );
	}

	/**
	 * Default Query for API
	 * @return [type] [description]
	 */
	function default_conds()
	{
		$conds = array();

		if ( $this->is_get ) {
		// if is get record using GET method

			// get default setting for GET_ALL_PRODUCTS
			$setting = $this->Api->get_one_by( array( 'api_constant' => GET_ALL_PRODUCTS ));

		}

		if ( $this->is_search ) {

			//$setting = $this->Api->get_one_by( array( 'api_constant' => SEARCH_WALLPAPERS ));

			if($this->post('searchterm') != "") {
				$conds['searchterm']   = $this->post('searchterm');
			}

			if($this->post('cat_id') != "") {
				$conds['cat_id']   = $this->post('cat_id');
			}

			if($this->post('sub_cat_id') != "") {
				$conds['sub_cat_id']   = $this->post('sub_cat_id');
			}

			if($this->post('is_featured') != "") {
				$conds['is_featured']   = $this->post('is_featured');
			}

			if($this->post('is_discount') != "") {
				$conds['is_discount']   = $this->post('is_discount');
			}

			if($this->post('is_available') != "") {
				$conds['is_available']   = $this->post('is_available');
			}			

			if($this->post('min_price') != "") {
				$conds['min_price']   = $this->post('min_price');
			}

			if($this->post('max_price') != "") {
				$conds['max_price']   = $this->post('max_price');
			}


			if($this->post('rating_value') != "") {
				$conds['rating_value']   = $this->post('rating_value');
			}

			if($this->post('shop_id') != "") {
				$conds['shop_id']   = $this->post('shop_id');
			}

			$conds['prd_search'] = 1;
			$conds['order_by'] = 1;
			$conds['order_by_field']    = $this->post('order_by');
			$conds['order_by_type']     = $this->post('order_type');
				
		}

		

		return $conds;
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize product object
		$this->ps_adapter->convert_product( $obj );
	}
}