<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Abouts extends BE_Controller {
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ABOUTS' );
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
	 * Load About Entry Form
	 */

	function index( $id = "abt1" ) {

		if ( $this->is_POST()) {
		// if the method is post

			// server side validation
			if ( $this->is_valid_input()) {

				// save user info
				$this->save( $id );
			}
		}

		$this->data['action_title'] = "About App";
		
		//Get About Object
		$this->data['about'] = $this->About->get_one( $id );

		$this->load_template( 'abouts/entry_form',$this->data, true );

	}

	/**
	 * Update the existing one
	 */
	function edit( $id = "abt1") {


		// load user
		$this->data['about'] = $this->About->get_one( $id );

		// call the parent edit logic
		parent::aboutedit( $id );
	}

	/**
	 * Saving Logic
	 * 1) save about data
	 * 2) check transaction status
	 *
	 * @param      boolean  $id  The about identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		// prepare data for save
		$data = array();

		// about_title
		if ( $this->has_data( 'about_title' )) {
			$data['about_title'] = $this->get_data( 'about_title' );
		}

		// about_description
		if ( $this->has_data( 'about_description' )) {
			$data['about_description'] = $this->get_data( 'about_description' );
		}

		// privacypolicy
		if ( $this->has_data( 'privacypolicy' )) {
			$data['privacypolicy'] = $this->get_data( 'privacypolicy' );
		}

		// about_email
		if ( $this->has_data( 'about_email' )) {
			$data['about_email'] = $this->get_data( 'about_email' );
		}

		// about_phone
		if ( $this->has_data( 'about_phone' )) {
			$data['about_phone'] = $this->get_data( 'about_phone' );
		}

		// about_website
		if ( $this->has_data( 'about_website' )) {
			$data['about_website'] = $this->get_data( 'about_website' );
		}

		// seo_title
		if ( $this->has_data( 'seo_title' )) {
			$data['seo_title'] = $this->get_data( 'seo_title' );
		}
		
		// seo_description
		if ( $this->has_data( 'seo_description' )) {
			$data['seo_description'] = $this->get_data( 'seo_description' );
		}

		// seo_keywords
		if ( $this->has_data( 'seo_keywords' )) {
			$data['seo_keywords'] = $this->get_data( 'seo_keywords' );
		}

		// if google adsense is checked,
		if ( $this->has_data( 'ads_on' )) {
			$data['ads_on'] = 1;
		} else {
			$data['ads_on'] = 0;
		}

		// ads_client
		if ( $this->has_data( 'ads_client' )) {
			$data['ads_client'] = $this->get_data( 'ads_client' );
		}

		// ads_slot
		if ( $this->has_data( 'ads_slot' )) {
			$data['ads_slot'] = $this->get_data( 'ads_slot' );
		}

		// if google analytic is checked,
		if ( $this->has_data( 'analyt_on' )) {
			$data['analyt_on'] = 1;
		} else {
			$data['analyt_on'] = 0;
		}

		// analyt_track_id
		if ( $this->has_data( 'analyt_track_id' )) {
			$data['analyt_track_id'] = $this->get_data( 'analyt_track_id' );
		}		
		
		// facebook
		if ( $this->has_data( 'facebook' )) {
			$data['facebook'] = $this->get_data( 'facebook' );
		}

		// google_plus
		if ( $this->has_data( 'google_plus' )) {
			$data['google_plus'] = $this->get_data( 'google_plus' );
		}

		// instagram
		if ( $this->has_data( 'instagram' )) {
			$data['instagram'] = $this->get_data( 'instagram' );
		}
		
		// youtube
		if ( $this->has_data( 'youtube' )) {
			$data['youtube'] = $this->get_data( 'youtube' );
		}

		// pinterest
		if ( $this->has_data( 'pinterest' )) {
			$data['pinterest'] = $this->get_data( 'pinterest' );
		}

		// twitter
		if ( $this->has_data( 'twitter' )) {
			$data['twitter'] = $this->get_data( 'twitter' );
		}

		// theme_style
		if ( $this->has_data( 'theme_style' )) {
			$data['theme_style'] = $this->get_data( 'theme_style' );
		}

		// save category
		if ( ! $this->About->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_about_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_about_add' ));
			}
		}

		$id = ( !$id )? $data['news_id']: $id ;

		if ( $this->has_data( 'gallery' )) {
		// if there is gallery, redirecti to gallery
			
			redirect( $this->module_site_url( 'gallery/'. $id));
		} else {
		// redirect to list view

			redirect( $this->module_site_url() );
		}

	}

	/**
	 * Show Gallery
	 *
	 * @param      <type>  $id     The identifier
	 */
	function gallery( $id ) {
		
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'about_gallery' );
		
		$_SESSION['parent_id'] = $id;
		$_SESSION['type'] = 'about';
    	    	
    	$this->load_gallery();
    }

    /**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		$this->form_validation->set_rules( 'about_title', get_msg( 'about_title_label' ), 'required');
		$this->form_validation->set_rules( 'about_description', get_msg( 'description_label' ), 'required');
		$this->form_validation->set_rules( 'about_email', get_msg( 'about_email_label' ), 'required');
		$this->form_validation->set_rules( 'about_phone', get_msg( 'about_phone_label' ), 'required');
		$this->form_validation->set_rules( 'about_website', get_msg( 'about_website_label' ), 'required');

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			return false;
		}

		return true;
	}
}