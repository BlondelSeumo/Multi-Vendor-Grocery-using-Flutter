<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH .'libraries/REST_Controller.php' );

class My_Controller {}

/**
 * PanaceaSoft Main Controller which extends the CI Controller
 * 1) Authentication
 * 2) Load Template 
 * 3) Load View
 * 4) Base Url & Site Url
 * 5) Set flash message
 * 6) Get Pagination Config
 * 7) Search Term Handler
 */
class PS_Controller extends CI_Controller
{
	// template folder path
	protected $template_path;

	// module folder path (excluding template path)
	protected $module_path;

	// level of authentication (login, module)
	protected $auth_level;

	// name of the requested module
	protected $module_name;

	// controller url
	protected $module_url;

	// pagination config
	protected $pag;

	// data to load in the view
	protected $data;

	/**
	 * constucts CI_Controller construction
	 */
	function __construct( $auth_level, $module_name )
	{
		parent::__construct();

		// constructs required variables
		$this->template_path = "";
		$this->auth_level = $auth_level;
		$this->module_name = $module_name;

		// base url and site url
		$this->module_url = strtolower( get_class( $this ));
		$this->module_path = $this->module_url;

		// load libraries
		$this->load->library( 'PS_Auth' );
		$this->load->library( 'PS_Image' );
		$this->load->library( 'PS_Library' );
		$this->load->library( 'PS_Security' );
		$this->load->library( 'PS_Delete' );

		// check authentication
		if ( ! $this->authenticate()) {
			//echo "wwwwww"; die;
			redirect( 'login' );
		}
		//echo "ssss"; die;
		if ( $this->ps_auth->is_logged_in()) {
		// load logged in user info if the use is logged in
			
			$this->load_userinfo();
		}
	}

	/**
	 * Load Title & meta data
	 * meta_type, meta_title, meta_desc, meta_keywords
	 */
	function load_metadata( $meta_data = array())
	{
		// SEO Data
		// $meta_data['title'] = get_msg( 'site_name' ) . get_msg( 'title_bar_seperator' ) . ucfirst( strtolower( $this->module_name ));

		$meta_data['title'] = get_msg( 'site_name' ) ;
		
		$meta_data['site_name'] = get_msg( 'site_name' );
		$meta_data['module_name'] = $this->module_name;

		// Folder Paths
		$meta_data['template_path'] = $this->template_path;
		$meta_data['module_path'] = $this->module_path;

		// URls
		$meta_data['module_site_url'] = $this->module_site_url();
		$meta_data['mobule_base_url'] = $this->base_url();

		// Backend and FE Urls
		$meta_data['fe_url'] = site_url( $this->config->item( 'fe_url' ));
		$meta_data['be_url'] = site_url( $this->config->item( 'be_url' ));

		$this->load->vars( $meta_data );
	}

	/**
	 * Loads an userinfo.
	 */
	function load_userinfo() 
	{
		// get logged in user info
		$user = $this->ps_auth->get_user_info();

		// load global data
		$data['module_groups'] = $this->Module->get_groups_info()->result();
		$data['user_info'] = $user;

		if ( $this->ps_auth->is_system_admin() ) {
		// if the user is system admin, load all modules and access

			$data['allowed_modules'] = $this->Module->get_all()->result();
			$data['allowed_accesses'] = $this->Role->get_all()->result();

		} else {

			// if the user is shop admin, load all modules and access
			$data['allowed_modules'] = $this->Module->get_allowed_modules( $user->user_id )->result();
			$data['allowed_accesses'] = $this->Role->get_allowed_accesses( $user->role_id );
		}
		
		$this->load->vars( $data );
	}

	/**
	 * Authenticate the loggedin user
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function authenticate()
	{	
		if ( $this->auth_level == LOGIN_CONTROL ) {
		// if authentication level is login only 
			
			return $this->ps_auth->validate();
		} elseif ( $this->auth_level == MODULE_CONTROL ) {
		// if authentication level is until module
			return $this->ps_auth->validate( $this->module_name );
		} elseif ( $this->auth_level == ROLE_CONTROL ) {
		// if authentication level is until role, check if the user is system user

			if ( !$this->ps_auth->validate()) return false;

			return $this->ps_auth->is_system_user();
		}

		return true;
	}

	/**
	 * Loads a view.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_view( $view, $data = false, $load_side_menus = true )
	{
		
		$data['load_side_menus'] = $load_side_menus;
		
		if ( !empty( $this->template_path )) {
		// if the template path is not empty,
			
			$this->load->view( $this->template_path .'/'. $view, $data );	
		} else {
		// if the template path is empty
			
			$this->load->view( $view );	
		}
	}


	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_template( $view = false ) 
	{
		// load header
		$this->load_view( 'partials/header', $this->data );

		// load view
		if ( !empty( $view )){
			$this->load_view( $view );
		}

		// load footer
		$this->load_view( 'partials/footer' );
	}


		/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_detail( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/detail' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_list( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/list', $data );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function dashboard_load_list( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/dashboard_list', $data );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_list_att_header( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/attribute_list' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_list_shop( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/shoplist' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_shop_view( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'shops_list' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_list_addatt( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/attribute_form' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_list_addatt_detail( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/attribute_form' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_attribute_search( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/attribute_list' );

		// load footer
		$this->load_view( 'partials/footer' );
	}



	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_list_att_detail( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/attribute_list' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_form( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/form' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a template.
	 *
	 * @param      <type>  $view   The view
	 */
	function load_att_form( $data ) 
	{
		// load header
		$this->load_view( 'partials/header', $data );

		// load view
		$this->load_view( 'partials/attribute_form' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Loads a gallery.
	 *
	 * @param      <type>  $data   The data
	 */
	function load_gallery()
	{
		// set true to load gallery
		$this->data['load_gallery_js'] = true;

		// load header
		$this->load_view( 'partials/header', $this->data );

		// load view
		$this->load_view( 'partials/gallery' );

		// load footer
		$this->load_view( 'partials/footer' );
	}

	/**
	 * Load the message from language file and Sets the flash message.
	 *
	 * @param      <type>  $key    The key
	 * @param      <type>  $value  The value
	 */
	function set_flash_msg( $key, $value )
	{
		// get lanaguage
		$message = get_msg( $value );

		// set flash data
		$this->session->set_flashdata( $key, $message );
	}

	/**
	 * return base url for controller
	 *
	 * @param      boolean  $path   The path
	 *
	 * @return     <type>   ( description_of_the_return_value )
	 */
	function base_url( $path = false )
	{
		if ( $path ) {
		// if the path is exists,
			
			return base_url( $this->module_url .'/'. $path );
		}

		return base_url( $this->module_url );
	}

	/**
	 * returns site url for controller
	 *
	 * @param      boolean  $path   The path
	 *
	 * @return     <type>   ( description_of_the_return_value )
	 */
	function module_site_url( $path = false )
	{
		if ( $path ) {
		// if the path is exists,
			
			return site_url( $this->module_url .'/'. $path );
		}

		return site_url( $this->module_url );
	}

	/**
	 * Determines if post.
	 *
	 * @return     boolean  True if post, False otherwise.
	 */
	function is_POST()
	{
		return ( $this->input->method( TRUE ) == 'POST' );
	}

	/**
	 * provide pagination configuration
	 */
	function load_pag( $base_url, $rows_count )
	{
		// load pagination
		$pag = $this->config->item('pagination');

		// set base url
		$pag['base_url'] = $base_url;

		// set total row count
		$pag['total_rows'] = $rows_count;

		$this->data['pag'] = $pag;
		// $this->pagination->initialize( $this->pag );
	}

	/**
	 * handle the searchterm in session
	 *
	 * @param      <type>  $searchterms  The searchterm
	 *
	 * @return     array   ( description_of_the_return_value )
	 */
	function searchterm_handler( $searchterms )
	{


		if ( is_array( $searchterms )) {

			
		// if searchterms is array
			$data = array();
			
			if ( $this->is_POST()) {
			// if the method is post, set the searchterms
				foreach ( $searchterms as $name => $term) {
					if ( ! empty( $term) ) {
					// if the term is not empty, keep in session
						
						$this->session->set_userdata( $name, $term );
						$data[$name] = $term;
					} else {
					// if the term is empty, remove from session
						
						$this->session->unset_userdata($term);
						$data[$name] = "";
					}
				}
			} else {
			// if the method is not POST, find in session
				foreach ( $searchterms as $name => $term) {
					if ( $this->session->userdata( $name )) {
					// if found in session,
						$data[$name] = $this->session->userdata($name);
					} else { 
					// if not found in session,
						$data[$name] = "";
					}
				}
			}
			
			// return the searchterm data
			return $data;
		} else {
		// if search term is not array

			if ( !empty( $searchterms )) {
			// if searchterm is not empty, keep in session
		        
		        $this->session->set_userdata( $searchterms, $searchterms );
		    } elseif ($this->session->userdata( $searchterms )) {
		    // if searchterm is empty and found in session, take from session
		        
		        $searchterms = $this->session->userdata( $searchterms );
		    } else {
		    // else, clear the search term
		        
		        $searchterms ="";
		    }

	        return $searchterms;
		}
	}


	/**
	 * Determines if it has data.
	 *
	 * @param      <type>   $name   The name
	 *
	 * @return     boolean  True if has data, False otherwise.
	 */
	function has_data( $name ) {

		return ( isset( $_POST[ $name ] ));
	}

	/**
	 * Gets the clean data.
	 *
	 * @param      <type>   $name   The name
	 *
	 * @return     boolean  The clean data.
	 */
	function get_data( $name )
	{
		if ( ! isset( $_POST[$name] )) {
		// if there is no post variable with the name
			
			return false;
		}

		if ( is_array( $_POST[$name] )) {
		// if the value is array,
			
			return $this->input->post( $name );
		}

		// trim, htmlentites and return
		return $this->ps_security->clean_input( trim( $this->input->post( $name )));
	}

	/**
	 * Check the acces
	 *
	 * @param      <type>  $action_id  The action identifier
	 */
	function check_access( $action_id ) {
		
		if ( ! $this->ps_auth->has_access( $action_id )) {
		// if no add access for this module,
		
			$this->set_flash_msg( 'error', get_msg( 'err_access' ));
			redirect( $this->module_site_url());
		}
	}

	/**
	 * Check the database transactions
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function check_trans()
	{
		if ( $this->db->trans_status() === FALSE ) {
        	
        	// rollback the transaction
			$this->db->trans_rollback();
			return false;
		}

		// commit
		$this->db->trans_commit();
		return true;
	}

	
}

require_once( APPPATH .'core/FE_Controller.php' );

require_once( APPPATH .'core/BE_Controller.php' );

require_once( APPPATH .'core/API_Controller.php' );

require_once( APPPATH .'core/Ajax_Controller.php' );