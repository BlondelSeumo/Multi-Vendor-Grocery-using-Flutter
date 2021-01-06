<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Notireaduser extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_push_notification_users', 'id', 'noti_red_' );
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

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		// noti_id condition
		if ( isset( $conds['noti_id'] )) {
			$this->db->where( 'noti_id', $conds['noti_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		// device_token condition
		if ( isset( $conds['device_token'] )) {
			$this->db->where( 'device_token', $conds['device_token'] );
		}

		$this->db->order_by( 'added_date', 'desc' );
	}
}