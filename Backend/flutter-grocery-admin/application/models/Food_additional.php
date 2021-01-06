<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for food additional table
 */
class Food_additional extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_food_additional', 'id', 'foodadd' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		

		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// product_id condition
		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id'] );
		}

		// add_on_id condition
		if ( isset( $conds['add_on_id'] )) {
			$this->db->where( 'add_on_id', $conds['add_on_id'] );
		}

	}
}