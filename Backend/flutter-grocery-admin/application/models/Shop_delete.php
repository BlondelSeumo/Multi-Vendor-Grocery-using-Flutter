<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for product delete table
 */
class Shop_delete extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_shop_deleted', 'id', 'del' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		//Date Range
		if ( isset( $conds['start_date'] ) && isset( $conds['end_date'] )) {
			$this->db->where( 'deleted_date >=', $conds['start_date'] );
			$this->db->where( 'deleted_date <=', $conds['end_date'] );
		}


	}
}