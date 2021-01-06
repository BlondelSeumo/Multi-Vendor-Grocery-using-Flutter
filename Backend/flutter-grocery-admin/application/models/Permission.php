<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permission Model for Permission Table
 */
class Permission extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() {
		parent::__construct( 'core_permissions', false, false );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// module_id condition
		if ( isset( $conds['module_id'] )) {
			$this->db->where( 'module_id', $conds['module_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		
	}
}