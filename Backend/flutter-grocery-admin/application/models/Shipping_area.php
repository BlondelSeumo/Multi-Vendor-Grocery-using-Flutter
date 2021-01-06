<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Shipping_area extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_shipping_areas', 'id', 'shparea' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// default where clause
		if ( !isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'status', 1 );
		}
		
		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		// area_name condition
		if ( isset( $conds['area_name'] )) {
			$this->db->where( 'area_name', $conds['area_name'] );
		}

		// price condition name
		if ( isset( $conds['price'] )) {
			$this->db->where( 'price', $conds['price'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'area_name', $conds['searchterm'] );
			$this->db->or_like( 'area_name', $conds['searchterm'] );
			$this->db->group_end();
		}

		$this->db->order_by( 'added_date', 'desc' );

	}
}