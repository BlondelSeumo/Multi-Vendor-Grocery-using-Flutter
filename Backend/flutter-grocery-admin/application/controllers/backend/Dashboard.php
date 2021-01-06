<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 */
class Dashboard extends BE_Controller {

	/**
	 * set required variable and libraries
	 */
	function __construct() {
		parent::__construct( ROLE_CONTROL, 'DASHBOARD' );
		///start allow module check by MN
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];
		
		$conds_mod['module_name'] = $this->router->fetch_class();
		$module_id = $this->Module->get_one_by($conds_mod)->module_id;
		
		$logged_in_user = $this->ps_auth->get_user_info();

		$user_id = $logged_in_user->user_id;
		if(empty($this->User->has_permission( $module_id,$user_id )) && $logged_in_user->user_is_sys_admin!=1){
			return redirect( site_url('/admin/'.$shop_id) );
		}
		///end check
	}

	/**
	 * Home page for the dashbaord controller
	 */
	function index($shop_id = 0) {
		$sess_array = array('shop_id' => $shop_id);
		$user_id = $this->session->userdata('user_id');
		$is_sys_admin = $this->session->userdata('is_sys_admin');
		$allow_shop_id = $this->session->userdata('allow_shop_id');

		$url = base_url(uri_string());
		$current_url = explode('/', $url);
		$conds_shop_user['user_id'] = $user_id;
		$shop_user = $this->User_shop->get_all_by( $conds_shop_user )->result();

		if (end($current_url) == "dashboard") {
			if($is_sys_admin == 1 || count($shop_user) > 1){
				redirect(site_url());
			}else{
				redirect(site_url() . "/admin/dashboard/index/" . $allow_shop_id);
			}
		}

		if($is_sys_admin == 1){
			
			$this->session->set_userdata('selected_shop_id', $sess_array);

		 	$this->load_template( 'dashboard', false, false, true );
		} else {
			$conds_user_shop['shop_id'] = $shop_id;
			$conds_user_shop['user_id'] = $user_id;

			$user_shops = $this->User_shop->get_one_by($conds_user_shop);
			$is_empty_object = $user_shops->is_empty_object;
		
			if ($is_empty_object == 1) {
				redirect(site_url('logout'));
			
			} else {
				$this->session->set_userdata('selected_shop_id', $sess_array);

			 	$this->load_template( 'dashboard', false, false, true );
			}

		} 

	}

	function exports()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$export = $this->dbutil->backup();
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('ps_news.zip', $export);
	}
}