<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for api table
 */
class Api extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_apis', 'api_id', 'api' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// api_id condition
		if ( isset( $conds['api_id'] )) {
			
			$this->db->where( 'api_id', $conds['api_id'] );
		}

		// api_constant condition
		if ( isset( $conds['api_constant'] )) {
			
			$this->db->where( 'api_constant', $conds['api_constant'] );
		}
	}
}