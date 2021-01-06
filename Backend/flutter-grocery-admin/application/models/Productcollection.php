<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for products_collection table
 */
class Productcollection extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_products_collection', 'id', 'col_prd' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// collection id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// collection id condition
		if ( isset( $conds['collection_id'] )) {
			$this->db->where( 'collection_id', $conds['collection_id'] );
		}

		// product id condition
		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id']);
		}
	}
		
}