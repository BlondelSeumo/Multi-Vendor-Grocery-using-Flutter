<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller
 * 1) login
 * 2) logout
 * 3) Reset Password
 */
class Main extends BE_Controller {

	/**
	 * load required variables, libraries
	 */
	function __construct() {
		parent::__construct( NO_AUTH_CONTROL, 'MAIN' );

		$this->load->library( 'PS_Mail' );

		if ( isset( $_GET['url'] )) {
		// if source url is existed, that url need to be redirected after login/logout
		
			$this->session->set_userdata( 'source_url', $_GET['url'] );
		}
	}

	/**
	 * Redirec to home page
	 */
	function index() {

		// get home page
		$homepage = $this->config->item( 'homepage' );

		// redirect to home page
		redirect( site_url( $homepage ));
	}

	/**
	 * Login from or Redirect to home page if already logged in
	 */
	function login() {
		
		if ( $this->ps_auth->is_logged_in() ) {
		 // if the user is already logged in, redirect to respective url
			
			$this->redirect_url();
		}

		if ( $this->is_POST() ) {
		// if the user is not yet logged in, authenticate url or load the login form view
			if ( $this->is_valid_login_input()) {
			// if valid input,

				// if request is post method, login and redirect
				$user_email = $this->get_data( 'email' );
				$user_password = $this->get_data( 'password' );

				if ($this->ps_auth->login( $user_email, $user_password ) == 1) {
				// if credentail is wrong, redirect to login
					$conds['user_email'] = $user_email;
					$role_id = $this->User->get_one_by($conds)->role_id;
					if ($role_id != '4') {
						if($this->session->userdata('allow_shop_count') == 1) {
							
							redirect(site_url() . "/admin/dashboard/index/" . $this->session->userdata('allow_shop_id'));
						} else if($this->session->userdata('allow_shop_count') > 1) {
							
							redirect(site_url());
						} else {
							
							$this->set_flash_msg('error',"err_email_pwd_not_match");
							redirect(site_url());
						}
						// if credential is correct, redirect to respective url
						$this->redirect_url();
					} 
					else {
						$this->session->set_flashdata('error',"You don't have access to admin panel.");
					}

				} elseif ($this->ps_auth->login( $user_email, $user_password ) == 2) {
					$this->set_flash_msg( 'error', 'approval_shop_login' );
					redirect(site_url('login'));
				} elseif ($this->ps_auth->login( $user_email, $user_password ) == 5) {
					$this->set_flash_msg( 'error', 'error_deli_boy' );
					redirect(site_url('login'));
				} else {
					$this->set_flash_msg( 'error', 'error_login' );
					redirect(site_url('login'));
				}
				
			}
		}

		// load login form 
		$this->load_view( 'partials/header' ); 
		$this->load_view( 'login' );
		$this->load_view( 'partials/footer' ); 
	}

	/**
	 * Logout from the system
	 */
	function logout() {
		// logout 
		$this->ps_auth->logout();

		// redirect
		$this->redirect_url();
	}

	/**
	 * Rest password by email
	 */
	function reset_request() {

		if ( $this->is_POST() ) {
		// if the user is not yet logged in, authenticate url or load the login form view

			if ( $this->is_valid_reset_request_input()) {
			// if valid input,

				// get email and user info
				$user_email = $this->get_data( 'email' );

				$user_info = $this->User->get_one_by( array( "user_email" => $user_email ));

		        if ( isset( $user_info->is_empty_object )) {
		        // if user info is empty,
		        	
		        	$this->set_flash_msg( 'error', 'err_user_not_exist' );
					redirect( 'reset_request' );
		        }

				// generate code
		        $code = md5(time().'teamps');

		        // insert to reset
		        $data = array(
					'user_id' => $user_info->user_id,
					'code' => $code
				);

				if ( !$this->ResetCode->save( $data )) {
				// if error in inserting,

					$this->set_flash_msg( 'error', 'err_model' );
					redirect( 'reset_request' );
				}

				// Send email with reset code
				$to = $user_info->user_email;
			    $subject = get_msg('pwd_reset_label');
				$msg = "<p>".get_msg( 'hi_label' )." ".','." ". $user_info->user_name ."</p>".
							"<p>".get_msg( 'pwd_reset_link' )."<br/>".
							"<a href='". site_url( $this->config->item( 'reset_url') .'/'. $code ) ."'>".get_msg( 'reset_link_label' )."</a></p>".
							"<p>".get_msg( 'best_regards_label' ).",<br/>". $this->Backend_config->get_one('be1')->sender_name ."</p>";

				// send email from admin
				if ( ! $this->ps_mail->send_from_admin( $to, $subject, $msg ) ) {

					$this->set_flash_msg( 'error', 'err_email_not_send' );
					redirect( 'reset_request' );
				}
				
				$this->set_flash_msg( 'success', 'success_reset_email_sent' );
				redirect( 'reset_request' );
			}
		}
		
		// load reset form 
		$this->load_view( 'partials/header' ); 
		$this->load_view( 'reset_request' );
		$this->load_view( 'partials/footer' ); 
	}

	/**
	 * Reset Email
	 */
	function reset_email( $code )
	{
		if ( !$code ) redirect( site_url());

		if ( !$this->ResetCode->exists( array( 'code' => $code ))) redirect( site_url());

		if ( $this->is_POST() ) {
		// if the user is not yet logged in, authenticate url or load the login form view

			if ( $this->is_valid_reset_email_input()) {

				// get post data
				$password = $this->get_data( 'password' );

				// get user id
				$user_id = $this->ResetCode->get_one_by( array( 'code' => $code ))->user_id;

				// start the transaction
				$this->db->trans_start();

				$user_data = array( 'user_password' => md5( $password ));

				if ( !$this->User->save( $user_data, $user_id )) {
				// if error in updating password,

					$this->db->trans_rollback();
					$this->set_flash_msg( 'error', 'err_model' );
					redirect( 'reset_email' );
				}

				if ( !$this->ResetCode->delete_by( array( 'user_id' => $user_id ))) {
				// if error in deleting all reset codes by user id,

					$this->db->trans_rollback();
					$this->set_flash_msg( 'error', 'err_model' );
					redirect( 'reset_email' );
				}

				if ( $this->db->trans_status() === FALSE ) {
		        	
		        	// rollback the transaction
					$this->db->trans_rollback();
					$this->set_flash_msg( 'error', 'err_model' );
					redirect( 'reset_email' );
				}

				// commit and success return
				$this->db->trans_commit();
				$this->set_flash_msg( 'success', 'success_reset' );
				redirect( 'login' );
			}
		}

		// load reset form 
		$this->load_view( 'partials/header', array( 'code' => $code )); 
		$this->load_view( 'reset_email' );
		$this->load_view( 'partials/footer' );
	}

	/**
	 * redirects to the respective urls based on user action
	 * 
	 */
	function redirect_url()
	{
		
		/* different urls based on user credential */
		$admin_url = site_url( 'admin' );
		$login_url = site_url( 'login ');
		$frontend_url = site_url();

		if ( null !== $this->session->userdata( 'source_url' )) {
		// if coming from existing url
			
			$source_url = $this->session->userdata( 'source_url' );
			$this->session->unset_userdata( 'source_url' );
			redirect( $source_url );		

		} else if ( !$this->ps_auth->is_logged_in() ) {
		// if user is not yet logged in, redirect to login
		
			redirect( $login_url );
		} else if ( $this->ps_auth->is_frontend_user() ) {
		// if the logged in user is frontend user, 

			redirect( $frontend_url );
		} else if ( $this->ps_auth->is_system_user() ) {
		// if the logged in user is system user, redirect to admin
			
			redirect( $admin_url );
		} else {
		// if the logged in user is not frontend user, redirect to dashbaord
			
			//$this->goto_approved_cities();
		}
	}

	/**
	 * Determines if valid input
	 */
	function is_valid_login_input() {

		$validation = array(
			array(
				'field' => 'email',
				'label' => get_msg( 'email' ),
				'rules' => 'trim|required|valid_email'
			),
			array(
				'field' => 'password',
				'label' => get_msg( 'password' ),
				'rules' => 'trim|required'
			)
		);

		$this->form_validation->set_rules( $validation );

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating, 
			
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}

		return true;
	}

	/**
	 * Determines if valid reset request input.
	 *
	 * @return     boolean  True if valid reset request input, False otherwise.
	 */
	function is_valid_reset_request_input() {

		$rules = array(
			array(
				'field' => 'email',
				'label' => get_msg( 'email' ),
				'rules' => 'trim|required|valid_email'
			)
		);
		
		$this->form_validation->set_rules( $rules );

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating, 
			
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}

		return true;
	}

	/**
	 * Determines if valid reset email input.
	 *
	 * @return     boolean  True if valid reset email input, False otherwise.
	 */
	function is_valid_reset_email_input()
	{
		$rules = array(
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			),
			array(
				'field' => 'conf_password',
				'label' => 'Confirm Password',
				'rules' => 'required|matches[password]'
			)
		);

		$this->form_validation->set_rules( $rules );

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating, 
			
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}

		return true;
	}

	/**
     * Checking the reset code
     *
     * @param      <type>   $code   The code
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    function code_check( $code )
    {
    	if ( !$this->ResetCode->exists( array( 'code' => $code ))) {

    		$this->form_validation->set_message('code_check', 'Invalid Reset Code');
            return false;
    	}

    	return true;
    }

    
}