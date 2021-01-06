<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Role Model for Role Table
 */
class Role extends PS_Model {

	// table for role
protected $role_access_table_name;

	/**
	 * Constructs the required data
	 */
	function __construct() {
		parent::__construct( 'core_roles', 'role_id', 'role' );
		$this->role_access_table_name = "core_role_access";
	}

	/**
	 * Gets the name.
	 *
	 * @param      <type>  $role_id  The role identifier
	 *
	 * @return     string  The name.
	 */
	function get_name( $role_id )
	{
		$query = $this->db->get_where( $this->table_name, array( 'role_id' => $role_id ));
		
		if ( $query->num_rows() == 1 ) {
			$row = $query->row();
			return $row->role_desc;
		}
		
		return "Unknown Module";
	}
	
	/**
	 * Gets the information by name.
	 *
	 * @param      <type>  $module_name  The module name
	 *
	 * @return     <type>  The information by name.
	 */
	function get_info_by_name( $module_name)
	{
		$query = $this->db->get_where( $this->table_name, array( 'role_name' => $role_name ));
		
		if ( $query->num_rows() == 1 ) {
			return $query->row();
		} else {
			return $this->get_empty_object( $this->table_name );
		}
	}

	/**
	 * Gets the allowed accesses.
	 *
	 * @param      <type>  $role_id  The role identifier
	 *
	 * @return     array   The allowed accesses.
	 */
	function get_allowed_accesses( $role_id )
	{
		$query = $this->db->get_where( $this->role_access_table_name, array( 'role_id' => $role_id ));
		$accesses = array();
		foreach ( $query->result() as $access ) {
			$accesses[] = $access->action_id;
		}
		
		return $accesses;
	}
}