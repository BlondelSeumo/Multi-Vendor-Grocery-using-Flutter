<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for product delete table
 */
class Product_delete extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_product_deleted', 'id', 'del' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		

		// product_id condition
		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id'] );
		}

		//Date Range
		if ( isset( $conds['start_date'] ) && isset( $conds['end_date'] )) {
			$this->db->where( 'deleted_date >=', $conds['start_date'] );
			$this->db->where( 'deleted_date <=', $conds['end_date'] );
		}


	}
}