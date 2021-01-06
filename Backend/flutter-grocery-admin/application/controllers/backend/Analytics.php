<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Analytics extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ANALYTICS' );
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
	 * Load Analytics Graph
	 */

	function index() {

		$cat_id = 0;
		$cat_name = "";
		
		if (htmlentities($this->input->post('cat_id'))) {
			$cat_id = htmlentities($this->input->post('cat_id'));
		}
		
		$data['cat_id'] = $cat_id;
		
		$wallpapers = $this->Wallpaper->get_all_by(array("cat_id" => $cat_id))->result();
		


		$wallpaper_arr = array();
		foreach ($wallpapers as $wallpaper) {
			$wallpaper_arr[$wallpaper->wallpaper_name] = $this->Analytic->count_all_by(array("wallpaper_id" => $wallpaper->wallpaper_id));
		}
		
		$graph_arr = array();
		foreach ($wallpaper_arr as $name=>$count) {
			$graph_arr[] = "['".$name."',".$count."]";
		}
		
		arsort($wallpaper_arr);
		$pie_arr = array();
		$i = 0;
		foreach ($wallpaper_arr as $name=>$count) {
			if(($i++) < 5){
				$pie_arr[] = "['".$name."',".$count."]";
			}
		}
		
		$data['count'] = count($wallpapers);
		$data['cat_name'] = $this->Category->get_one($cat_id)->cat_name;

		$data['graph_items'] = "[['Items','Touches'],".implode(',',$graph_arr)."]";
		$data['pie_items'] = "[['Items','Touches'],".implode(',',$pie_arr)."]";
		
		//$content['content'] = $this->load->view('reports/analytic',$data,true);		
		
		$this->load_template( "analytics/view", $data);
		//$this->load_view

	}

}