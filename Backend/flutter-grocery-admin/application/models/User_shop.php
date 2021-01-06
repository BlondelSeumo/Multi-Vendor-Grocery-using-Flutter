<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for api table
 */
class User_shop extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_user_shops', 'id', 'usershop' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// api_id condition
		if ( isset( $conds['id'] )) {
			
			$this->db->where( 'id', $conds['id'] );
		}

		// api_constant condition
		if ( isset( $conds['user_id'] )) {
			
			$this->db->where( 'user_id', $conds['user_id'] );
		}

			// api_constant condition
		if ( isset( $conds['shop_id'] )) {
			
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}
	}
}