<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for discount table
 */
class Discount extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_discounts', 'id', 'dis' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// discount name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		// discount condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// discount percent
		if ( isset( $conds['percent'] )) {
			$this->db->where( 'percent', $conds['percent'] );
		}

		//status discount
		if ( $this->is_filter_status( $conds )) {
			$this->db->where( 'status', '1' );	
		}

		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );
			$this->db->group_end();
		}

		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		$this->db->order_by( 'added_date', 'desc' );
	}

	/**
	 * Determines if filter discount.
	 *
	 * @return     boolean  True if filter discount, False otherwise.
	 */
	function is_filter_status( $conds )
	{
		return ( isset( $conds['discount'] ) && $conds['discount'] == 1 );
	}
}