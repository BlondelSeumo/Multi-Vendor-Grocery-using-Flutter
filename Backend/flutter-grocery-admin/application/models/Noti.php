<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Noti extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_push_notification_messages', 'id', 'noti' );
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

		// notification_name condition
		if ( isset( $conds['message'] )) {
			$this->db->where( 'message', $conds['message'] );
		}

		// notification description condition
		if ( isset( $conds['desc'] )) {
			$this->db->where( 'description', $conds['desc'] );
		}

		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'message', $conds['searchterm'] );
		}
		$this->db->order_by( 'added_date', 'desc' );
		
	}
}