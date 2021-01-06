<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for module group table
 */
class Module_group extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'core_menu_groups', 'group_id', 'group' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{

		// group_id condition
		if ( isset( $conds['group_id'] )) {
			$this->db->where( 'group_id', $conds['group_id'] );
		}

		// group_name condition
		if ( isset( $conds['group_name'] )) {
			$this->db->where( 'group_name', $conds['group_name'] );
		}

		// group_icon condition
		if ( isset( $conds['group_icon'] )) {
			$this->db->where( 'group_icon', $conds['group_icon'] );
		}

		// group_lang_key condition
		if ( isset( $conds['group_lang_key'] )) {
			$this->db->where( 'group_lang_key', $conds['group_lang_key'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'group_name', $conds['searchterm'] );
			$this->db->or_like( 'group_name', $conds['searchterm'] );
			$this->db->group_end();
		}

	}
}