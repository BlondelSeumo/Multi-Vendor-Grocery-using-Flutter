<?php
require_once( APPPATH .'libraries/REST_Controller.php' );
require_once( APPPATH .'libraries/braintree_lib/autoload.php' );
require_once( APPPATH .'libraries/stripe_lib/autoload.php' );



/**
 * REST API for Transaction Header
 */
class Transactionheaders extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Transactionheader' );
	}
	/**
	 * Default Query for API
	 * @return [type] [description]
	 */
	function default_conds()
	{
		$conds = array();

		if ( $this->is_get ) {
		// if is get record using GET method
			$conds['order_by'] = 1;
			$conds['order_by_field'] = "added_date";
			$conds['order_by_type'] = "asc";
		}

		return $conds;
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		$this->ps_adapter->convert_transaction_header( $obj );
		
	}


	/**
	* When user submit transaction from app
	*/
	function submit_post() 
	{	

		$trans_details = $this->post( 'details' );

		for($i=0; $i<count($trans_details); $i++) 
		{

			//for prd checking unpublish, delete and available
			$product_id = $trans_details[$i]['product_id'];
			$product_data = $this->Product->get_one($product_id);

			if ( $product_data->is_empty_object == 1 || $product_data->status == 0 || $product_data->is_available == 0 ) {
				$this->error_response( get_msg( 'trans_prd_checkout' ) );
				exit;
			}

			//for shop checking unpublish and delete
			$shop_id = $trans_details[$i]['shop_id'];
			$shop_data = $this->Shop->get_one($shop_id);

			if ( $shop_data->is_empty_object == 1 || $shop_data->status == 0 ) {
				$this->error_response( get_msg( 'trans_shop_checkout' ) );
				exit;
			}
		}
		$user_id = $this->post( 'user_id' );
		$users = global_user_check($user_id);
		$payment_method = "";
		$paypal_result = 0;
		$stripe_result = 0;
		$cod_result = 0;
		$razor_result =0;


		$shop_obj = $this->Shop->get_all()->result();


		$shop_id = $shop_obj[0]->id;



		if($this->post( 'is_paypal' ) == 1) {

			//User using Paypal to submit the transaction
			$payment_method = "PAYPAL";

			$shop_info = $this->Shop->get_one($shop_id);

			//print_r($shop_info); die;
			
			$gateway = new Braintree_Gateway([
			  'environment' => trim($shop_info->paypal_environment),
			  'merchantId' => trim($shop_info->paypal_merchant_id),
			  'publicKey' => trim($shop_info->paypal_public_key),
			  'privateKey' => trim($shop_info->paypal_private_key)
			]);

			$result = $gateway->transaction()->sale([
			  'amount' 			   => $this->post( 'balance_amount' ),
			  'paymentMethodNonce' => $this->post( 'payment_method_nonce' ),
			  'options' => [
			    'submitForSettlement' => True
			  ]
			]);

			if($result->success == 1) {
			
				$paypal_result = $result->success;
			
			} else {

				$this->error_response( get_msg( 'paypal_transaction_failed' ) );
			
			}



		} else if($this->post( 'is_stripe' ) == 1) {

			//User using Stripe to submit the transaction
			$payment_method = "STRIPE";

			$shop_info = $this->Shop->get_one($shop_id);

			try {
			
				# set stripe test key
				\Stripe\Stripe::setApiKey( trim($shop_info->stripe_secret_key) );
				
				$charge = \Stripe\Charge::create(array(
			    	"amount" 	  => $this->post( 'balance_amount' ) * 100, // amount in cents, so need to multiply with 100 .. $amount * 100
			    	"currency"    => trim($shop_info->currency_short_form),
			    	"source"      => $this->post( 'payment_method_nonce' ),
			    	"description" => get_msg('order_desc')
			    ));
			    
			    if( $charge->status == "succeeded" )
			    {
			    	$stripe_result = 1;
			    } else {
			    	$this->error_response( get_msg( 'stripe_transaction_failed' ) );
			    }
				
			} 

			catch(exception $e) {
			  	
			 	$this->error_response( get_msg( 'stripe_transaction_failed' ) );
			    
			 }


		} else if($this->post( 'is_cod' ) == 1) {

			//User Using COD 
			$payment_method = "COD";


			$cod_result = 1;

		} else if($this->post( 'is_pickup' ) == 1) {

			//User Using COD 
			$payment_method = "Pick Up";


			$pickup_result = 1;

		} else if($this->post( 'is_razor' ) == 1) {

			//User Using COD 
			$payment_method = "Razor";


			$razor_result = 1;

		} else if ($this->post( 'is_bank' ) == 1) {

			//User Using COD 
			$payment_method = "BANK";


			$bank_result = 1;

		} else if($this->post( 'is_paystack' ) == 1) {

			//User Using COD 
			$payment_method = "Paystack";


			$paystack_result = 1;

		}else {

			//Not selected to payment 
			$this->error_response( get_msg( 'payment_not_select' ) );
		}

		

		if( $paypal_result == 1 || $stripe_result == 1 || $cod_result == 1 || $pickup_result == 1 || $bank_result == 1 || $razor_result == 1 || $paystack_result == 1) {

			//echo $payment_method; die;

			$this->db->trans_start();

			//First Time
	 		$transaction_row_count = $this->Transactionheader->count_all();
	 		$current_date_month = date("Ym");
	 		$current_date_time = date("Y-m-d H:i:s"); 

	 		$conds['code'] = $current_date_month;
	 		$trans_code_checking =  $this->Code->get_one_by($conds)->code;

	 		$id = false;


	 		if($trans_code_checking == "") {
	 			//New record for this year--mm, need to insert as inside the core_code_generator table
				$data['type']  =  "transaction";
		 		$data['code']  =  $today = date("Ym"); ;
		 		$data['count'] = $transaction_row_count + 1;
		 		$data['added_user_id'] = $this->post( 'user_id' );
		 		$data['added_date'] = date("Y-m-d H:i:s"); 
		 		$data['updated_date'] = date("Y-m-d H:i:s"); 
		 		$data['updated_user_id'] = 0;
		 		$data['updated_flag'] = 0;

	 			if( !$this->Code->save($data, $id) ) {
					// rollback the transaction
					$this->db->trans_rollback();
					$this->error_response( get_msg( 'err_model' ));
	 			}

	 			// get inserted id
				if ( !$id ) $id = $data['id']; 

				if($id) {
					$trans_code = $this->Code->get_one($id)->code;
				}


				
	 		} else {
	 			//record is already exist so just need to update for count field only
	 			$data['count'] = $transaction_row_count + 1;

	 			$core_code_generator_id =  $this->Code->get_one_by($conds)->id;

	 			if( !$this->Code->save($data, $core_code_generator_id) ) {
					// rollback the transaction
					$this->db->trans_rollback();
					$this->error_response( get_msg( 'err_model' ));
	 			}

	 			$conds['id'] = $core_code_generator_id;
	 			$trans_code =  $this->Code->get_one_by($conds)->code . ($transaction_row_count + 1);


	 		}

	 		// trans_status_id

	 		$conds_stage['start_stage'] = '1';
			$trans_data = $this->Transactionstatus->get_one_by($conds_stage);
			$trans_status_id = $trans_data->id;

			if( $paypal_result == 1 || $stripe_result == 1 || $pickup_result == 1 || $bank_result == 1 || $razor_result == 1) {
				$payment_status = 2;
			}else{
				$payment_status = 1;
			}	



	 		//Need to save inside transaction header table 
			$trans_header = array(
	 			'user_id' 				=> $this->post( 'user_id' ),
	 			'shop_id' 				=> $this->post( 'shop_id' ),
	 			'sub_total_amount' 		=> $this->post( 'sub_total_amount' ),
	 			'tax_amount' 			=> $this->post( 'tax_amount' ),
	 			'shipping_amount' 		=> $this->post( 'shipping_amount' ),
	 			'balance_amount' 		=> $this->post( 'balance_amount' ),
	 			'total_item_amount' 	=> $this->post( 'total_item_amount' ),
	 			'total_item_count' 	    => $this->post( 'total_item_count' ),
	 			'contact_name' 		    => $this->post( 'contact_name' ),
	 			'contact_phone' 		=> $this->post( 'contact_phone' ),
	 			'contact_email' 		=> $this->post( 'contact_email' ),
	 			'contact_address' 		=> $this->post( 'contact_address' ),
	 			'contact_area_id' 		=> $this->post( 'contact_area_id' ),
	 			'payment_method' 		=> $payment_method,
	 			'trans_status_id' 		=> $trans_status_id,
	 			'razor_id' 				=> $this->post( 'razor_id' ),
	 			'discount_amount'       => $this->post( 'discount_amount'),
	 			'coupon_discount_amount'=> $this->post( 'coupon_discount_amount'),
	 			'trans_code'            => $trans_code,
	 			'added_date'            => $current_date_time,
	 			'added_user_id'         => $this->post( 'user_id' ),
	 			'updated_date'          => $current_date_time,
	 			'updated_user_id'       => "0",
	 			'updated_flag'          => "0",
	 			'currency_symbol'       => $this->post( 'currency_symbol'),
	 			'currency_short_form'   => $this->post( 'currency_short_form'),
				'shipping_tax_percent'  => $this->post( 'shipping_tax_percent'),
				'tax_percent'  			=> $this->post( 'tax_percent'),
				'memo'   				=> $this->post( 'memo'),
				'trans_lat'   			=> $this->post( 'trans_lat'),
				'trans_lng'   			=> $this->post( 'trans_lng'),
				'pick_at_shop'   		=> $this->post( 'pick_at_shop'),
				'payment_status_id'		=> $payment_status,
				'delivery_pickup_date'	=> $this->post( 'delivery_pickup_date'),
			    'delivery_pickup_time'	=> $this->post( 'delivery_pickup_time')

	 		);

			$trans_header_id = false;
			
			if( !$this->Transactionheader->save($trans_header) ) {
				// rollback the transaction
				$this->error_response( get_msg( 'err_model' ) );
			} 

			$trans_header_id = $trans_header['id']; 

			$trans_details = $this->post( 'details' );

			for($i=0; $i<count($trans_details); $i++) 
			{
				// print_r($trans_details);die;
				$trans_detail[ 'shop_id' ]           			= $trans_details[$i]['shop_id'];
				$trans_detail[ 'product_id' ]           		= $trans_details[$i]['product_id'];
			    $trans_detail[ 'product_name' ]                 = $trans_details[$i]['product_name'];
			    $trans_detail[ 'product_customized_id' ]        = $trans_details[$i]['product_customized_id'];
			    $trans_detail[ 'product_customized_name' ]      = $trans_details[$i]['product_customized_name'];
			    $trans_detail[ 'product_customized_price' ]     = $trans_details[$i]['product_customized_price'];
			    $trans_detail[ 'product_addon_id' ]         	= $trans_details[$i]['product_addon_id'];
			    $trans_detail[ 'product_addon_name' ]       	= $trans_details[$i]['product_addon_name'];
			    $trans_detail[ 'product_addon_price' ]      	= $trans_details[$i]['product_addon_price'];
			    $trans_detail[ 'original_price' ]               = $trans_details[$i]['original_price'];
			    $trans_detail[ 'price' ]                   		= $trans_details[$i]['unit_price'];
			    $trans_detail[ 'product_color_id' ]             = $trans_details[$i]['product_color_id'];
			    $trans_detail[ 'product_color_code' ]           = $trans_details[$i]['product_color_code'];
			    $trans_detail[ 'qty' ]                          = $trans_details[$i]['qty'];
			    $trans_detail[ 'discount_value' ]               = $trans_details[$i]['discount_value'];
			    $trans_detail[ 'discount_percent' ]             = $trans_details[$i]['discount_percent'];
			    $trans_detail[ 'discount_amount' ]              = $trans_details[$i]['discount_amount'];
			    $trans_detail['transactions_header_id']         = $trans_header_id;
			    $trans_detail['added_date']             		= $current_date_time;
			    $trans_detail['added_user_id']          		= $this->post( 'user_id' );
			    $trans_detail['updated_date']           		= $current_date_time;
			    $trans_detail['updated_user_id']        		= "0";
			    $trans_detail['updated_flag']           		= "0";
			    $trans_detail['currency_short_form']            = $trans_details[$i]['currency_short_form'];
			    $trans_detail['currency_symbol']           	    = $trans_details[$i]['currency_symbol'];
			    $trans_detail['product_unit']					= $trans_details[$i]['product_unit'];
			    $trans_detail['product_unit_value']			= $trans_details[$i]['product_unit_value'];
			    
			    
			    if ( !$this->Transactiondetail->save( $trans_detail )) {
			          // if error in saving review rating,
			        $this->db->trans_rollback();
			        $this->error_response( get_msg( 'err_model' ) );
			     }

			     //Need to update transaction count table
				$prd_cat_id = $this->Product->get_one($trans_details[$i]['product_id'])->cat_id;
				$prd_sub_cat_id = $this->Product->get_one($trans_details[$i]['product_id'])->sub_cat_id;

				$trans_count['product_id'] = $trans_details[$i]['product_id'];
				$trans_count['shop_id']    = $trans_details[$i]['shop_id'];
				$trans_count['transactions_header_id']         = $trans_header_id;
				$trans_count['cat_id']     = $prd_cat_id;
				$trans_count['sub_cat_id'] = $prd_sub_cat_id;
				$trans_count['user_id']    = $this->post( 'user_id' );
				$trans_count['added_date'] = $current_date_time;


				if ( !$this->Transactioncount->save( $trans_count )) {
			          // if error in saving review rating,
			        $this->db->trans_rollback();
			        $this->error_response( get_msg( 'err_model' ) );

			    }

			 //    $device_token=$this->post( 'device_token');
				// $user_id = $this->post( 'user_id');
				// $user_data['device_token'] = $device_token;
				// if( !$this->User->save($user_data, $user_id) ) {
				// 	// rollback the transaction
				// 	$this->db->trans_rollback();
				// 	$this->error_response( get_msg( 'err_model' ));
		 	// 	}

			}

			
			

			if ($this->db->trans_status() === FALSE) {
	        	$this->db->trans_rollback();
	        	$this->error_response( get_msg( 'err_model' ) );
	    	} else {
				$this->db->trans_commit();
			}

			$trans_header_obj = $this->Transactionheader->get_one($trans_header_id);

			//Sending Email to shop
			$to_who = "shop";
			$subject = get_msg('order_receive_subject');
			send_transaction_order_emails( $trans_header_id, $to_who, $subject );
			/*
			if ( !send_transaction_order_emails( $trans_header_id, $to_who, $subject )) {

				$this->error_response( get_msg( 'err_email_not_send_to_shop' ));
			
			}

			//Sending Email To user
			$to_who = "user";
			$subject = get_msg('order_receive_subject');
			
			if ( !send_transaction_order_emails( $trans_header_id, $to_who, $subject )) {

				$this->error_response( get_msg( 'err_email_not_send_to_user' ));
			
			}
			*/

			$to_who = "user";
			$subject = get_msg('order_receive_subject');
			send_transaction_order_emails( $trans_header_id, $to_who, $subject );

			$this->convert_object($trans_header_obj);

			$this->custom_response($trans_header_obj);
	
		}


	}

	function checking_post()
	{

		$trans_details = $this->post( 'details' );

		$fail_trans = array();

		$fail_not_available_products = array();

		$fail_delete_products = array();

		$fail_price_change_products = array();

		$fail_trans = $this->ps_adapter->transaction_checking($trans_details);


		//[0] - is for delete products
		if(count($fail_trans[0]) > 0) {

			// Rule 1 : Delete Product Checking
			for($g = 0; $g<count($fail_trans[0]); $g++) {

				$fail_delete_products[] = $fail_trans[0][$g];

			}


		} else if( count($fail_trans[1]) > 0 ) {

			// Rule 2 : Avaiable Product Checking
			for($j = 0; $j<count($fail_trans[1]); $j++) {

				$fail_not_available_products[] = $fail_trans[1][$j];

			} 


		} else if( count($fail_trans[2]) > 0 ) {

			// Rile 3 : Price Checking
			for($h = 0; $h<count($fail_trans[2]); $h++) {

				$fail_price_change_products[] = $fail_trans[2][$h];

			}

		}

		$fail_delete_products = array_unique($fail_delete_products);


		if( count($fail_delete_products) > 0 ) {


			$prds = $this->Product->get_all_in($fail_delete_products)->result();
			$this->custom_fail_response( $prds,true, "Product is deleted from the system." );

		} else if (count($fail_not_available_products) > 0) {

			$prds = $this->Product->get_all_in($fail_not_available_products)->result();
			$this->custom_fail_response( $prds,true, "Product is not available from the system." );

		} else if (count($fail_price_change_products) > 0) {

			$prds = $this->Product->get_all_in($fail_price_change_products)->result();
			$this->custom_fail_response( $prds,true, "Product Price is has been changed." );

		} else {
			echo "ok!!!!";
		}

	}


	function stripe_checking_get()
	{

		\Stripe\Stripe::setApiKey("sk_test_lxHim6W6aJAjb4jjAtfviY0t");
		try {
		  \Stripe\Charge::all();
		  echo "TLS 1.2 supported, no action required.";
		} catch (\Stripe\Error\ApiConnection $e) {
		  echo "TLS 1.2 is not supported. You will need to upgrade your integration.";
		}

	}


	function assign_deliveryboy_post()
	{
		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'delivery_boy_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'transactions_header_id',
	        	'rules' => 'required'
	        )
        );


		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $user_id = $this->post('delivery_boy_id');
        $users = global_user_check($user_id);


        //save transaction header
        $id = $this->post('transactions_header_id');
        $data = array(
        	"delivery_boy_id" => $this->post('delivery_boy_id')
        );
        $this->Transactionheader->save($data,$id);
		// get the post data
		$conds['delivery_boy_id'] = $data['delivery_boy_id'];
		// response the inserted object	
		$tmp_deli_com = $this->Transactionheader->get_one( $id );

		$this->custom_response( $tmp_deli_com );
	}




}