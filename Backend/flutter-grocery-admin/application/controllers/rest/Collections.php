<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Collections
 */
class Collections extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Collection' );
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
			$conds['collection_get'] = 1;
			$conds['order_by'] = 1;
			$conds['order_by_field'] = "added_date";
			$conds['order_by_type'] = "desc";
			

			if($this->get('product_limit') != "") {
				$conds['product_limit'] = $this->get('product_limit');
			}

			
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
		
		// convert customize category object
		$this->ps_adapter->convert_collection( $obj );
	}



}