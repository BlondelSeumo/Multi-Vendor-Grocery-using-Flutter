<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for shop table
 */
class Shop extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_shops', 'id', 'shop' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// default where clause
		if ( isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'status', $conds['no_publish_filter'] );
		} else {
			$this->db->where('status',1);
		}

		// order by
		if ( isset( $conds['order_by_field']) && isset( $conds['order_by_type'])) {
			
			$order_by_field = $conds['order_by_field'];
			$order_by_type = $conds['order_by_type'];
			
			$this->db->order_by( 'rt_shops.'.$order_by_field, $order_by_type);
		}
	
		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// is_featured condition
		if ( isset( $conds['is_featured'] )) {
			$this->db->where( 'is_featured', $conds['is_featured'] );
		}

		// shop_id condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}


		// // lat condition
		// if ( isset( $conds['lat'] )) {
		// 	$this->db->where( 'lat', $conds['lat'] );
		// }

		// // lng condition
		// if ( isset( $conds['lng'] )) {
		// 	$this->db->where( 'lng', $conds['lng'] );
		// }


		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );
			$this->db->group_end();
		}

		$this->db->order_by('added_date','desc');
	}
	
}
?>