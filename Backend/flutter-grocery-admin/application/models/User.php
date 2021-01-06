<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model for core_USERS table
 */
class User extends PS_Model {

	// table name for module
	protected $module_table_name;

	// table name for permission
	protected $permission_table_name;

	// table name for role access
	protected $role_access_table_name;

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'core_users', 'user_id', 'usr' );

		// initialize table names
		$this->module_table_name = "core_modules";
		$this->permission_table_name = "core_permissions";
		$this->role_access_table_name = "core_role_access";
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// status condition
		if ( isset( $conds['status'] )) {
			$this->db->where( 'status', $conds['status'] );
		} else {
			//$this->db->where( 'status', 1 );
		}


		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( $this->primary_key, $conds['user_id'] );
		}

		// system_role_id condition
		if ( isset( $conds['system_role_id'] )) {
			$this->db->where( 'role_id !=', $conds['system_role_id'] );
		}

		// normal_role_id condition
		if ( isset( $conds['register_role_id'] )) {
			$this->db->where( 'role_id', $conds['register_role_id'] );
		}

		// deli_role_id condition
		if ( isset( $conds['deli_role_id'] )) {
			$this->db->where( 'role_id !=', $conds['deli_role_id'] );
		}

		// role_id condition
		if ( isset( $conds['role_id'] )) {
			$this->db->where( 'role_id', $conds['role_id'] );
		}

		// user_email condition
		if ( isset( $conds['user_email'] )) {
			$this->db->where( 'user_email', $conds['user_email'] );
		}

		// user_name condition
		if ( isset( $conds['user_name'] )) {
			$this->db->where( 'user_name', $conds['user_name'] );
		}

		// user_phone condition
		if ( isset( $conds['user_phone'] )) {
			$this->db->where( 'user_phone', $conds['user_phone'] );
		}

		// user_pass condition
		if ( isset( $conds['user_password'] )) {
			$this->db->where( 'user_password', md5( $conds['user_password'] ));
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'user_name', $conds['searchterm'] );
			$this->db->or_like( 'user_email', $conds['searchterm'] );
		}

		// // searchterm
		// if ( isset( $conds['searchterm'] )) {
		// 	$this->db->like( 'user_email', $conds['searchterm'] );
		// 	$this->db->or_like( 'user_email', $conds['searchterm'] );
		// }
		
		// user_is_sys_admin condition
		if ( isset( $conds['user_is_sys_admin'] )) {
			$this->db->where( 'user_is_sys_admin', $conds['user_is_sys_admin'] );
		}

		// is_banned condition
		if ( isset( $conds['is_banned'] )) {
			$this->db->where( 'is_banned', $conds['is_banned'] );
		}

		// code condition
		if ( isset( $conds['code'] )) {
			$this->db->where( 'code', $conds['code'] );
		}

		// country_id condition
		if ( isset( $conds['country_id'] )) {
			$this->db->where( 'country_id', $conds['country_id'] );
		}

		// city_id condition
		if ( isset( $conds['city_id'] )) {
			$this->db->where( 'city_id', $conds['city_id'] );
		}

		// google_id condition
		if ( isset( $conds['google_id'] )) {
			$this->db->where( 'google_id', $conds['google_id'] );
		}

		// facebook_id condition
		if ( isset( $conds['facebook_id'] )) {
			$this->db->where( 'facebook_id', $conds['facebook_id'] );
		}

		// phone_id condition
		if ( isset( $conds['phone_id'] )) {
			$this->db->where( 'phone_id', $conds['phone_id'] );
		}


		$this->db->order_by( 'added_date', 'desc' );
	}

	/**
	 * Save function creates/updates the user data to users table.
	 * If the user_id is already exist in the users table,update user data
	 * else, the function will create new data row
	 * 
	 * @param ref array $user_data
	 * @param int $user_id
	 * @return bool
	 */
	function save_user( &$user_data, $permission_data, $user_id = false )
	{
		// start the transaction
		$this->db->trans_start();

		if ( !$user_id && ! $this->exists( array( 'user_email' => $user_data['user_email'] ))) {
		//if there is no data with this id, insert new			
			
			// generate new user id
			$user_id = $this->generate_key( 'USR' );
			$user_data['user_id'] = $user_id;
			
			if ( ! $this->db->insert( $this->table_name, $user_data )) {
			// if error in inserting new, rollback

				$this->db->trans_rollback();
        		return false;
			}

		} else {
		//else update the data
		
			$this->db->where( 'user_id', $user_id );
			
			if ( ! $this->db->update( $this->table_name, $user_data )) {
			// if error in updating, rollback
				
				$this->db->trans_rollback();
        		return false;
			}
		}
		
		//Clear existing permission & Insert new permission
		if ( ! $this->db->delete( $this->permission_table_name, array( $this->primary_key => $user_id )) ) {
		// if error in cleaing existing permission, rollback	

			$this->db->trans_rollback();
    		return false;
		}
		// loop and insert the passed permissions
		foreach ( $permission_data as $module ) {

			// prep module data
			$data = array( 'module_id' => $module, $this->primary_key => $user_id );

			if ( ! $this->db->insert(  $this->permission_table_name, $data )) {
			// if error in inserting permission data, rollback
				
				$this->db->trans_rollback();
        		return false;
			}
		}

		// commit the transaction
		return $this->db->trans_commit();
	}

	/**
	 * Delete function update 1 to deleted fields from users table
	 * according to the user id
	 * 
	 * @param int $user_id
	 * @return bool
	 */
	function delete( $user_id )
	{
		if ( $user_id == $this->ps_auth->get_user_info()->user_id ) {
		// Don't let user deleted their self
			
			return false;
		}

		// start the transaction
		$this->db->trans_start();
		
		if ( ! $this->db->delete( $this->permission_table_name, array( $this->primary_key => $user_id ))) {
		// if error in deleteing permission, rollback
		
			$this->db->trans_rollback();
			return false;
		}

		$this->db->where( $this->primary_key, $user_id );

		if ( ! $this->db->update( $this->table_name, array( 'status' => 0 ))) {
		// if error in updating user status,

			$this->db->trans_rollback();
			return false;
		}

		// commit the transaction
		return $this->db->trans_commit();
	}

	/**
	 * Has-permission determine whether the user has access for module
	 * 
	 * @return bool
	 */
	function has_permission( $module_id, $user_id )
	{
		// if no module id is null,allow access
		if ( $module_id == null ) {
			return true;
		}

		// Join Permission Table, Module Table & User Table
		$this->db->from( $this->permission_table_name );
		$this->db->where( $this->primary_key, $user_id );
		$this->db->join( $this->module_table_name, $this->module_table_name .".module_id = ". $this->permission_table_name .".module_id" );
		$this->db->where( $this->module_table_name .'.module_id', $module_id );
		
		$query = $this->db->get();
		return $query->num_rows() == 1;

	}

	/**
	 * has_access determine whether the user has access for action
	 */
	function has_access( $action_id, $role_id)
	{
		//if action is null, allow access
		if ( $action_id == null ) {
			return true;
		}
		
		$this->db->from( $this->role_access_table_name );
		$this->db->where( 'role_id', $role_id );
		$this->db->where( 'action_id', $action_id );
		$query = $this->db->get();
		
		return $query->num_rows() == 1;
	}
}