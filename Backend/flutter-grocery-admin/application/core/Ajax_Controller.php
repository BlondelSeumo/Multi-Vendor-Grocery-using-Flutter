<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Front End Controller
 */
class Ajax_Controller extends CI_Controller {

	/**
	 * Check if the request is ajax
	 */
	function __construct( $request_type_checking = true )
	{
		parent::__construct();

		$ajax_check = $this->config->item( 'ajax_request_checking' );

		$this->load->library( 'PS_Security' );

		if ( $ajax_check && !$this->input->is_ajax_request()) {
		// show 404, if the request is not ajax
			
			show_404();
		}
	}

	/**
	 * Ajax Response
	 *
	 * @param      <type>  $obj    The object
	 */
	function response( $obj )
	{
		echo json_encode( $obj );
		exit;
	}


		/**
	 * Ajax Response
	 *
	 * @param      <type>  $obj    The object
	 */
	function response_appinfo( $obj )
	{
		

		echo json_encode( $obj );
		exit;
	}

	/**
	 * Error Response
	 *
	 * @param      <type>  $msg    The message
	 */
	function error_response( $msg )
	{
		$this->response( array(
			'status' => 'error',
			'message' => $msg
		));
	}

	/**
	 * Success Response
	 *
	 * @param      <type>  $msg    The message
	 */
	function success_response( $msg, $obj = false )
	{
		$response = array(
			'status' => 'success',
			'message' => $msg
		);

		if ( $obj ) {
			$response['data'] = $obj;
		}

		$this->response( $response );
	}

	/**
	 * validation function
	 *
	 * @param      <type>   $conds  The conds
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function is_valid( $rules )
	{
		if ( empty( $rules )) {
		// if rules is empty, no checking is required
			
			return true;
		}

		// GET data
		$user_data = $_REQUEST;

		$this->form_validation->set_data( $user_data );
		$this->form_validation->set_error_delimiters('', '<br/>');
		$this->form_validation->set_rules( $rules );

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			$this->error_response( validation_errors());

			return false;
		}

		return true;
	}

	/**
	 * Id Checking
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function id_check( $id, $model_name = false )
    {
        if ( !$this->{$model_name}->is_exist( $id )) {
        
            $this->form_validation->set_message('id_check', 'Invalid {field}');
            return false;
        }

        return true;
    }

	/**
	 * Determines if it has data.
	 *
	 * @param      <type>   $name   The name
	 *
	 * @return     boolean  True if has data, False otherwise.
	 */
	function set_data( &$data, $key ) {

		if ( isset( $_REQUEST[ $key ] )) {
		// if there is key in request, assign to the data
			
			$data[ $key ] = $this->ps_security->clean_input( $_REQUEST[ $key ] );
		}
	}
}