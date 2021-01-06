<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for reservation table
 */
class Reservation extends PS_Model {
	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_reservation', 'id', 'res' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// order by
		if ( isset( $conds['order_by'] )) {

			$order_by_field = $conds['order_by_field'];
			$order_by_type = $conds['order_by_type'];
			
			$this->db->order_by( 'rt_reservation.'.$order_by_field, $order_by_type);
		}
		
		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}
		// status_id condition
		if ( isset( $conds['status_id'] )) {
			$this->db->where( 'status_id', $conds['status_id'] );
		}

		$this->db->order_by( 'added_date', 'desc' );
	}
}