<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model for BE_USERS table
 */
class Example extends PS_Model {

	/**
	 * set the table name
	 */
	function __construct()
	{
		parent::__construct( 'be_users', 'user_id', 'usr' );
	}

	/**
	 * Implement the where clause
	 * 1) get_all_by
	 * 2) count_all_by
	 * 3) delete_by
	 *
	 * @param      array  $conds  The conds
	 */
	function conditions( $conds = array())
	{
		// if condition is empty, return true
		if ( empty( $conds )) return true;

		// Where clause
		if ( isset( $conds['user_email'] )) {
			$this->db->where( 'user_email', $conds['user_email'] );
		}
	}

	/**
	 * Customer Query Execution
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function custom_query()
	{
		//sql script
		$sql = "select * from be_users where id = ?";

		// parameters
		$params = array( 1 );

		return $this->exec_sql( $sql, $params );
	}
}