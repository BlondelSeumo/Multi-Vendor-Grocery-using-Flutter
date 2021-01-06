<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Notification
 */
class Notis extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Noti' );

	}

	/**
	* Register Device
	*/
	function register_post()
	{
		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'platform_name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'device_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;
        $user_id = $this->post('user_id');
        $users = global_user_check($user_id);
        if($this->post('platform_name') == "android") {

        	$noti_data = array(
	        	"device_id" => $this->post('device_id'), 
	        	"os_type" => "ANDROID",
	        	"user_id" => $user_id
        	);

        } else {

        	$noti_data = array(
	        	"device_id" => $this->post('device_id'), 
	        	"os_type" => "IOS",
	        	"user_id" => $user_id
        	);
        }

        $noti = array(
        	"device_id" => $noti_data['device_id']
        );
        if ( $this->Notitoken->exists( $noti )) {
        // if the noti data is already existed, return success

        	$this->success_response( get_msg( 'token_already_exist '));
        }

        if ( !$this->Notitoken->save( $noti_data )) {
        // if there is error in inserting noti data, return error

        	$this->error_response( get_msg( 'err_noti_register' ));
        }

        // else, return success
        $this->success_response( get_msg( 'success_noti_register '));
	}

	/**
	* Register Device
	*/
	function unregister_post()
	{
		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'device_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;
        $user_id = $this->post('user_id');
        $users = global_user_check($user_id);
    	$noti_data = array(
        	"device_id" => $this->post('device_id'),
        	"user_id" => $user_id
    	);
    	
    	if ( !$this->Notitoken->exists( $noti_data )) {
    	// if device id is not existed, return success

    		$this->success_response( get_msg( 'success_noti_unregister '));
    	}
    		
    	if ( !$this->Notitoken->delete_by( $noti_data )) {
    	// if there is an error in deleteing noti data, return error

    		$this->error_response( get_msg( 'err_noti_unregister' ));
    	}

    	// if no error, return success
    	$this->success_response( get_msg( 'success_noti_unregister '));
	}

	/**
	* To Update Read Status 
	*/
	function is_read_post()
	{
		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'noti_id',
	        	'rules' => 'required'
	        )

        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        if( $this->post('user_id') == "" && $this->post('device_token') == "") {
        	$this->error_response( get_msg( 'err_in_noti_read' ));
        	exit;
        } 


    	$noti_user_data = array(
        	"noti_id" => $this->post('noti_id'),
        	"user_id" => $this->post('user_id'),
        	"device_token" => $this->post('device_token')
    	);



    	if ( !$this->Notireaduser->exists( $noti_user_data )) {
    	// if device id is not existed, return success

    		$this->Notireaduser->save( $noti_user_data );
    		
    	} 

    	$obj = new stdClass;
		$obj->id = $this->post('noti_id');
		$noti = $this->Noti->get_one( $obj->id );
		
		$this->ps_adapter->convert_noti( $noti );
		$this->custom_response_noti( $noti );
    		
    	
	}

	function all_notis_post() 
	{
		
		$limit = $this->get( 'limit' );
   		$offset = $this->get( 'offset' );

		$noti_obj = $this->Noti->get_all($limit,$offset)->result();

		foreach ($noti_obj as $nt)
		{
			$noti_user_data = array(
	        	"noti_id" 		=> $nt->id,
	        	"user_id" 		=> $this->post('user_id'),
	        	"device_token"  => $this->post('device_token')

	    	);

	    	if ( $this->Notireaduser->exists( $noti_user_data )) {
	    		$nt->is_read = 1;
	    	} else {
	    		$nt->is_read = 0;
	    	}

	    	
		}

    	$this->custom_response_noti( $noti_obj, $offset );

	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize category object
		$noti_user_data = array(
        	"noti_id" => $obj->id,
        	"user_id" => $this->post('user_id'),
        	"device_token"  => $this->post('device_token')
    	);

    	if ( !$this->Notireaduser->exists( $noti_user_data )) {
    		
    		$obj->is_read = 0;
    	} else {
    		
    		$obj->is_read = 1;
    	}

		$this->ps_adapter->convert_noti( $obj );
	}

}