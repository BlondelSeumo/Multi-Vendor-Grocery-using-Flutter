<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language_strings Controller
 */
class Language_strings extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'LANGUAGE_STRINGS' );
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
	 * List down the registered users
	 */
	function lang_list( $language_id = 0 ) {
		$this->session->set_userdata(array("language_id" => $language_id ));
		
		redirect( site_url('admin/language_strings/index/') );
	}
	function index() {

		$language_id = $this->session->userdata('language_id');

		$language_list = get_msg('list_lang_label');
		$list_lang_str = get_msg('list_lang_str_label');
		$this->data['action_title'] = array( 
			array( 'label' => $list_lang_str, 'mod_name' => "language_strings",'special_mod_name' => 'Languages', 'special_mod_url' => $language_list)
			
		);

		$conds['language_id'] = $language_id;
		// get rows count
		$this->data['rows_count'] = $this->Language_string->count_all_by( $conds );
		
		// get langstrigs
		$this->data['langstrings'] = $this->Language_string->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );
		$this->data['language_id'] = $language_id;
		// load index logic
		parent::string_index($language_id);
	}

	/**
	 * Searches for the first match.
	 */
	function search( ) {
		$language_id = $this->session->userdata('language_id');
		// breadcrumb urls
		$language_list = get_msg('list_lang_label');
		$this->data['action_title'] = array( 
			array( 'url' => '/index/', 'label' => get_msg('list_lang_str_label'), 'mod_name' => 'language_strings','special_mod_name' => 'Languages', 'special_mod_url' => $language_list),
			array( 'label' => get_msg( 'lang_str_search' ))
			
		);
		
		// condition with search term
		if($this->input->post('submit') != NULL ){
			$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
			if($this->input->post('searchterm') != "") {
				$conds['searchterm'] = $this->input->post('searchterm');
				$this->data['searchterm'] = $this->input->post('searchterm');
				$this->session->set_userdata(array("searchterm" => $this->input->post('searchterm')));
			} else {
				
				$this->session->set_userdata(array("searchterm" => NULL));
			}
		}else{
			//read from session value
			if($this->session->userdata('searchterm') != NULL){
				$conds['searchterm'] = $this->session->userdata('searchterm');
				$this->data['searchterm'] = $this->session->userdata('searchterm');
			}
		}

		$conds['language_id'] = $language_id;
		// print_r($conds);die;
		// pagination
		$this->data['rows_count'] = $this->Language_string->count_all_by( $conds );

		// search data
		$this->data['langstrings'] = $this->Language_string->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		$this->data['language_id'] = $language_id;
		
		// load add list
		parent::string_search($language_id);
	}

	function fileupload( $language_id=0 ) {

		// File extension
  		$extension = pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION);
  		
  		// If file extension is 'csv'
  		if(!empty($_FILES['csv_file']['name']) && $extension == 'csv'){
  			
  			// Open file in read mode
		    $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
		    fgetcsv($csvFile); // Skipping header row
		    // Read file
		    while(($csvData = fgetcsv($csvFile)) !== FALSE){

		      	// Assign value to variables
			    $key = trim($csvData[0]);
			    $value = trim($csvData[1]);
			    // $language = $this->Language->get_language($conds_lang)->result();
			    // $language_id = $language[0]->id;
			    $conds_str['language_id'] = $language_id;
			    $conds_str['key'] = $key; 
			    $strrecord = $this->Language_string->get_language_string($conds_str)->result();
			   
			    if (!$strrecord) {
			    	$str_data = array(
			    	 	'language_id'=> $language_id,
			    	 	'key' => $key,
			    	 	'value' => htmlspecialchars_decode($value) 
			    	);
			    	
			    	$this->Language_string->save($str_data,$id);
			    }
		    	
		  	}
		  	
		}

		$this->set_flash_msg( 'success', get_msg( 'success_langstr_import' ));
		redirect( site_url('admin/language_strings/') );
	}

	/**
	 * Create new one
	 */
	function add($language_id=0) {

		// breadcrumb urls
		$language_list = get_msg('list_lang_label');
		$this->data['action_title'] = array( 
			array( 'url' => '/index/' . $language_id, 'label' => get_msg('list_lang_str_label'), 'mod_name' => 'language_strings','special_mod_name' => 'Languages', 'special_mod_url' => $language_list),
			array( 'label' => get_msg( 'lang_str_add' ))
			
		);

		$this->data['language_id'] = $language_id;

		// call the core add logic
		parent::add_language($language_id);
	}

	/**
	 * Update the existing one
	 */
	function edit( $id, $language_id ) {

		// breadcrumb urls
		$language_list = get_msg('list_lang_label');
		$this->data['action_title'] = array( 
			array( 'url' => '/index/', 'label' => get_msg('list_lang_str_label'), 'mod_name' => 'language_strings','special_mod_name' => 'Languages', 'special_mod_url' => $language_list),
			array( 'label' => get_msg( 'lang_str_edit' ))
			
		);

		// load user
		$this->data['langstr'] = $this->Language_string->get_one( $id );

		$this->data['language_id'] = $language_id;

		// call the parent edit logic
		parent::string_edit( $id, $language_id );
	}

	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save language
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false, $language_id =0 ) {
		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert Language Records 
		 */
		$data = array();

		// prepare language_id
		if ( $this->has_data( 'language_id' )) {
			$data['language_id'] = $this->get_data( 'language_id' );
		}

		// prepare key
		if ( $this->has_data( 'key' )) {
			$data['key'] = $this->get_data( 'key' );
		}

		// prepare value
		if ( $this->has_data( 'value' )) {
			$value = $this->get_data( 'value' );
			$data['value'] = htmlspecialchars_decode($value);
		}


		// save language
		if ( ! $this->Language_string->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}
		
		/** 
		 * Check Transactions 
		 */

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_lang_str_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_lang_str_add' ));
			}
		}

		redirect( site_url('admin/language_strings/'));
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {

		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'key', get_msg( 'name' ), $rule);

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			return false;
		}

		return true;
	}

	/**
	 * Determines if valid name.
	 *
	 * @param      <type>   $name  The  name
	 * @param      integer  $id     The  identifier
	 *
	 * @return     boolean  True if valid name, False otherwise.
	 */
	function is_valid_name( $name, $id = 0, $language_id=0 )
	{	
		$conds['key'] = $name;
		$conds['language_id'] = $language_id;

		 	if( $id != "") {
				if ( strtolower( $this->Language_string->get_one( $id )->key ) == strtolower( $name )) {
				// if the name is existing name for that user id,
					return true;
				} 
			} else {
				if ( $this->Language_string->exists( ($conds ))) {
				// if the name is existed in the system,
					$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
					return false;
				}
			}
			return true;
	}

	/**
	 * Check language name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	 */
	function ajx_exists( $id = false )
	{
		// get language name
		$name = $_REQUEST['key'];
		$language_id = $_REQUEST['language_id'];
		
		if ( $this->is_valid_name( $name, $id, $language_id )) {

		// if the language name is valid,
			
			echo "true";
		} else {
		// if invalid language name,
			
			echo "false";
		}
	}
}
?>