<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for category table
 */
class Coupon extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_coupons', 'id', 'cou' );
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
			$this->db->where( 'is_published', 1 );
		}

		// cat_name condition
		if ( isset( $conds['coupon_name'] )) {
			$this->db->where( 'coupon_name', $conds['coupon_name'] );
		}

		// cat_code condition
		if ( isset( $conds['coupon_code'] )) {
			$this->db->where( 'coupon_code', $conds['coupon_code'] );
		}

		// cat_amount condition
		if ( isset( $conds['coupon_amount'] )) {
			$this->db->where( 'coupon_amount', $conds['coupon_amount'] );
		}


		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'coupon_name', $conds['searchterm'] );
			$this->db->or_like( 'coupon_name', $conds['searchterm'] );
			$this->db->group_end();
		}

		$this->db->order_by( 'added_date', 'desc' );
	}
}