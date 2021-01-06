<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Tags
 */
class Tags extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		$is_login_user_nullable = false;

		// call the parent
		parent::__construct( 'Tag', $is_login_user_nullable );

	}

	function default_conds()
	{
		$conds = array();

		if ( $this->is_get ) {
		// if is get record using GET method
			//$conds['order_by_field'] = "added_date";
			//$conds['order_by_type'] = "desc";
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
		$this->ps_adapter->convert_tag( $obj );
	}
}