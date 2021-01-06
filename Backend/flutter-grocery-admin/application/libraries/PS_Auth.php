<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Authentication
 */
class PS_Auth {

	// codeigniter instance
	protected $CI;

	// logged in user
	protected $logged_in_user;

	/**
	 * constrcuts required variables
	 */
	function __construct( )
	{
		// get CI instance
		$this->CI =& get_instance();

		// get logged in user info
		$this->logged_in_user = $this->get_user_info();
	}

	/**
	 * Validate the user and requested actions
	 * @return [type] [description]
	 */
	function validate( $module_name = false )
	{
		if ( ! $this->is_logged_in()) {
		// if there is no logged in user, return false
			
			return false;
		}
		
		return true;
	}

	/**
	 * login by user info and keep in session
	 *
	 * @param      <type>   $user_email  The user email
	 * @param      <type>   $user_pass   The user pass
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function login( $user_email, $user_pass )
	{
		// prep conditions
		$conds = array( 'user_email' => $user_email, 'user_password' => $user_pass, 'is_banned' => 0 );
		$user_data = $this->CI->User->get_one_by( $conds );

		if ($user_data->role_id == 5) {
			return 5;
		}

		if ($user_data->status == 3 && $user_data->is_shop_admin == 0) {
			$conds['status'] = 3;
		} else {
			$conds['status'] = 1;
		}
		
		if ($conds['status'] == 3) {
			return 2;
		} else {
			
			if ( ! $this->CI->User->exists( $conds )) {
			// if the user email and password is not existed, return false
				return false;
			}
		}
		
		if ( $user = $this->CI->User->get_one_by( $conds ) ) {
			$this->CI->session->set_userdata( 'user_id', $user->user_id );
			$this->CI->session->set_userdata( 'is_sys_admin', $user->user_is_sys_admin );
			$this->CI->session->set_userdata( 'role_id', $user->role_id );
			$this->CI->session->set_userdata('is_shop_admin',0);
			$this->CI->session->set_userdata('allow_shop_id',$user->shop_id);

			if($user->is_shop_admin) {
				//Checking more than one shop
				$conds_user_shop['user_id'] =  $user->user_id;
				$user_shop = $this->CI->User_shop->get_all_by( $conds_user_shop )->result();
				//print_r($user_shop);die;
				if(count($user_shop) == 1) {
					
					// keep user info in session
					$this->CI->session->set_userdata('allow_shop_id',$user_shop[0]->shop_id);
					$this->CI->session->set_userdata('allow_shop_count',1);
					$this->CI->session->set_userdata('is_shop_admin',true);

				} else if(count($user_shop) > 1) {
					
					// keep user info in session
					$this->CI->session->set_userdata('allow_shop_id','many');
					$this->CI->session->set_userdata('allow_shop_count',count($user_shop));
					$this->CI->session->set_userdata('is_shop_admin',true);
				}
				
			} 
			return true;
		}

		return false;
	}

	/**
	 * logout the logged in user
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function logout()
	{
		// keep user info in session
		$this->CI->session->unset_userdata( 'user_id' );
		$this->CI->session->unset_userdata( 'role_id' );
		$this->CI->session->unset_userdata( 'is_sys_admin' );
		$this->CI->session->unset_userdata( 'is_shop_admin' );
		$this->CI->session->unset_userdata( 'allow_shop_count' );

		return true;
	}

	/**
	 * Determines if logged in.
	 */
	function is_logged_in()
	{
		return $this->CI->session->userdata( 'user_id' ) != false;
	}

	/**
	 * Determines if it has permission.
	 *
	 * @param      <type>   $module_name  The module name
	 *
	 * @return     boolean  True if has permission, False otherwise.
	 */
	function has_permission( $module_name )
	{
		$conds_mod['$conds_mod'] = $module_name;
		$module_id = $this->CI->Module->get_one_by($conds_mod)->module_id;

		if ( ! $this->logged_in_user ) {
		// if there is no logged in user, return false

			return false;
		}

		if ( $this->is_system_admin()) {
		// system admin can access everywhere

			return true;
		}

		return $this->CI->User->has_permission( $module_id, $this->logged_in_user->user_id );
	}

	/**
	 * Determines if it has access.
	 *
	 * @param      <type>   $module_name  The module name
	 * @param      <type>   $action_id    The action identifier
	 *
	 * @return     boolean  True if has access, False otherwise.
	 */
	function has_access( $action_id )
	{
		if ( ! $this->logged_in_user ) {
		// if there is no logged in user, return false

			return false;
		}

		if ( $this->is_system_admin()) {
		// system admin can access everywhere

			return true;
		}

		return $this->CI->User->has_access( $action_id, $this->logged_in_user->role_id );
	}

	/**
	 * Gets the logged in user information
	 */
	function get_user_info()
	{
		if ( $this->is_logged_in()) {
		// if there is logged in user,
			
			return $this->CI->User->get_one( $this->CI->session->userdata( 'user_id' ));
		}

		return false;
	}

	/**
	 * Determines if system admin.
	 *
	 * @return     boolean  True if system admin, False otherwise.
	 */
	function is_system_admin()
	{
		return ( $this->CI->session->userdata( 'is_sys_admin' ) == 1 );
	}

	/**
	 * Determines if system user.
	 */
	function is_system_user() 
	{
		return ( $this->CI->session->userdata( 'role_id' ) != 4 );
	}

	/**
	 * Determines if backend user.
	 *
	 * @return     boolean  True if backend user, False otherwise.
	 */
	function is_backend_user()
	{
		return true;
	}

	/**
	 * Determines if frontend user.
	 *
	 * @return     boolean  True if frontend user, False otherwise.
	 */
	function is_frontend_user()
	{
		return ( $this->CI->session->userdata( 'role_id' ) == 4 );
	}
}