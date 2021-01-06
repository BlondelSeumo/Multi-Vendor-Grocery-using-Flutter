<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for feed table
 */
class Feed extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_feeds', 'id', 'feed' );
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

		// feed_name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		// feed_desc condition
		if ( isset( $conds['description'] )) {
			$this->db->where( 'description', $conds['description'] );
		}

		// shop_id condition
		if (isset($conds['check_status'])) {
			if ( isset( $conds['shop_id'] )) {
				$this->db->where_not_in( 'shop_id', $conds['shop_id'] );
			}
		} else {
			if ( isset( $conds['shop_id'] )) {
				$this->db->where( 'shop_id', $conds['shop_id'] );
			}
		}

		// shop_status condition
		if ( isset( $conds['shop_status'] )) {
			$this->db->where( 'shop_status', $conds['shop_status'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );
			$this->db->group_end();
		}

		$this->db->order_by( 'added_date', 'desc' );
	}
}