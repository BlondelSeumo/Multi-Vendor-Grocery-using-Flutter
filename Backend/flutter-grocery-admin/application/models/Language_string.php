<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for language table
 */
class Language_string extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_language_string', 'id', 'langstr' );
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

		// language_id condition
		if ( isset( $conds['language_id'] )) {
			$this->db->where( 'language_id', $conds['language_id'] );
		}

		// key condition
		if ( isset( $conds['key'] )) {
			$this->db->where( 'key', $conds['key'] );
		}

		// value condition
		if ( isset( $conds['value'] )) {
			$this->db->where( 'value', $conds['value'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'key', $conds['searchterm'] );
			$this->db->or_like( 'key', $conds['searchterm'] );

		}

		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'value', $conds['searchterm'] );
			$this->db->or_like( 'value', $conds['searchterm'] );
			$this->db->group_end();

		}

	}
}