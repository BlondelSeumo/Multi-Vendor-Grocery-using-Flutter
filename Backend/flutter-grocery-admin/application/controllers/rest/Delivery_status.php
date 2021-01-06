<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for News
 */
class Delivery_status extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Deliverystatus' );

		// set the validation rules for create and update
		$this->validation_rules();
	}

	/**
	 * Determines if valid input.
	 */
	function validation_rules()
	{
		// validation rules for create
		$this->create_validation_rules = array(
			array(
	        	'field' => 'transactions_header_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'trans_status_id',
	        	'rules' => 'required'
	        ),
        );
	}


	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

	}

	/**
	 * Update Delivery Status a post.
	 */
	function update_delivery_status_post()
	{

		// set the add flag for custom response
		$this->is_add = true;

		if ( !$this->is_valid( $this->create_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$id = $this->post('transactions_header_id');
		$data['trans_status_id'] = $this->post('trans_status_id');
		if ( !$this->Transactionheader->save( $data, $id )) {
			$this->error_response( get_msg( 'err_model' ));
		}
		$trans_status_id = $data['trans_status_id'];
		$title = $this->Transactionstatus->get_one($trans_status_id)->title;
		$message = "Your order delivery status is " . $title;

		//@start
		//get device token from user
		$user_id = $this->Transactionheader->get_one($id)->user_id;
		$device_token = $this->User->get_one($user_id)->device_token;

		$device_tokens[] = $device_token;

		$status = $this->send_android_fcm( $device_tokens, $message, $id );
		if ( !$status ) $error_msg .= "Fail to push all android devices <br/>";
		// response the inserted object	
		$obj = $this->Transactionheader->get_one( $id );

		$this->custom_response( $obj );
	}

	/**
	* Sending Message From FCM For Android
	*/
	function send_android_fcm( $registatoin_ids, $message, $id ) 
    {
    	//Google cloud messaging GCM-API url
    	$url = 'https://fcm.googleapis.com/fcm/send';

    	$message = $message;
    	$trans_header_id = $trans_header_id;

    	// - Testing Start
		$noti_arr = array(
    		'title' => get_msg('site_name'),
    		'body' => $message,
    		'message' => $message,
    		'flag' => 'transaction',
	    	'sound'=> 'default'
    	);
    	// - Testing End


    	$fields = array(
    		'notification' => $noti_arr,
    	    'registration_ids' => $registatoin_ids,
    	    'data' => array(
    	    	'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
    	    	'message' => $message,
    	    	'flag' => 'transaction',
    	    	'trans_header_id' => $trans_header_id
    	    )

    	);
    	

    	// $fields = array(
    	//     'registration_ids' => $registatoin_ids,
    	//     'data' => $message,
    	// );
    	// Update your Google Cloud Messaging API Key
    	//define("GOOGLE_API_KEY", "AIzaSyCCwa8O4IeMG-r_M9EJI_ZqyybIawbufgg");
    	define("GOOGLE_API_KEY", $this->Backend_config->get_one('be1')->fcm_api_key);  	
    		
    	$headers = array(
    	    'Authorization: key=' . GOOGLE_API_KEY,
    	    'Content-Type: application/json'
    	);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    	$result = curl_exec($ch);				
    	if ($result === FALSE) {
    	    die('Curl failed: ' . curl_error($ch));
    	}
    	curl_close($ch);

    	return $result;
    }

	/**
	 * Completed order a post.
	 */
	function completed_order_post()
	{

		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'delivery_boy_id',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $user_id = $this->post('delivery_boy_id');
        $users = global_user_check($user_id);

		// get trans status id that is final stage
		$conds_stage['final_stage'] = '1';
		$trans_data = $this->Transactionstatus->get_one_by($conds_stage);
		$trans_status_id = $trans_data->id;
		
		$conds['delivery_boy_id'] = $this->post('delivery_boy_id');
		$conds['trans_status_id'] = $trans_status_id;
		$conds['status'] = "completed";
		// response the inserted object	
		$tmp_deli_com = $this->Transactionheader->get_all_order_delivery( $conds )->result();

		$this->custom_response( $tmp_deli_com );
	}

	/**
	 * Pending order a post.
	 */
	function pending_order_post()
	{

		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'delivery_boy_id',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $user_id = $this->post('delivery_boy_id');
        $users = global_user_check($user_id);

		// get trans status id that is final stage
		$conds_stage['final_stage'] = '1';
		$trans_data = $this->Transactionstatus->get_one_by($conds_stage);
		$trans_status_id = $trans_data->id;

		$conds['delivery_boy_id'] = $this->post('delivery_boy_id');
		$conds['trans_status_id'] = $trans_status_id;
		$conds['status'] = "pending";

		// response the inserted object	
		$tmp_deli_com = $this->Transactionheader->get_all_order_delivery( $conds )->result();

		$this->custom_response( $tmp_deli_com );

		//$this->ps_adapter->convert_transaction_header( $tmp_deli_com );
	}

}