<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for ResetCode
 */
class ResetCode extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'core_reset_codes', 'code_id', 'rcode' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{	
		// code condition
		if ( isset( $conds['code'] )) {
			$this->db->where( 'code', $conds['code'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}
	}
}