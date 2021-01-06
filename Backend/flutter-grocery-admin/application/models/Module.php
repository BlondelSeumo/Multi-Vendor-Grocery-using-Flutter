<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Module Model for Module Table
 */
class Module extends PS_Model {

	// table for permision 
	protected $permission_table_name;

	// table for menu groups
	protected $menu_group_table_name;

	/**
	 * Constructs the required data
	 */
	function __construct() {
		parent::__construct( 'core_modules', 'module_id', 'mod' );
		$this->permission_table_name = "core_permissions";
		$this->menu_group_table_name = "core_menu_groups";
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

		// module_name condition
		if ( isset( $conds['module_name'] )) {
			$this->db->where( 'module_name', $conds['module_name'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'module_name', $conds['searchterm'] );
			$this->db->or_like( 'module_name', $conds['searchterm'] );
			$this->db->group_end();
		}

		$this->db->order_by( 'ordering', 'desc' );
		
	}

	/**
	 * Gets the name.
	 *
	 * @param      <type>  $module_id  The module identifier
	 *
	 * @return     string  The name.
	 */
	function get_name( $module_id )
	{
		$query = $this->db->get_where( $this->table_name, array( 'module_id' => $module_id ));
		
		if ( $query->num_rows() == 1 ) {
			$row = $query->row();
			return $row->module_name;
		}
		
		return "Unknown Module";
	}

	/**
	 * Gets the allowed modules.
	 *
	 * @param      <type>  $user_id  The user identifier
	 *
	 * @return     <type>  The allowed modules.
	 */
	function get_allowed_modules( $user_id )
	{
		$this->db->from( $this->table_name );
		$this->db->join( $this->permission_table_name, $this->permission_table_name .".module_id = ". $this->table_name .".module_id" );
		$this->db->where( $this->permission_table_name .".user_id", $user_id );
		$this->db->order_by( $this->table_name .'.ordering' );
		return $this->db->get();
	}
	
	/**
	 * Gets the groups information.
	 *
	 * @return     <type>  The groups information.
	 */
	function get_groups_info() 
	{
		$this->db->distinct();
		$this->db->select( $this->menu_group_table_name .'.group_id, group_name, group_icon, group_lang_key' );
		$this->db->from( $this->menu_group_table_name );
		$this->db->join( $this->table_name, $this->menu_group_table_name .".group_id = ". $this->table_name .".group_id");

		$this->db->order_by( $this->menu_group_table_name .'.group_id' );
		
		return $this->db->get();
		
	}
}