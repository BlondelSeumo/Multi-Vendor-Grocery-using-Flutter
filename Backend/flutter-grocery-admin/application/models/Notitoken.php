<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Notitoken extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_push_notification_tokens', 'id', 'noti_tkn_' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{

		// push_noti_token_id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		// os_type condition
		if ( isset( $conds['os_type'] )) {
			$this->db->where( 'os_type', $conds['os_type'] );
		}

		// os_type condition
		if ( isset( $conds['device_id'] )) {
			$this->db->where( 'device_id', $conds['device_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}
		
		$this->db->order_by( 'added_date', 'desc' );
		
	}
}