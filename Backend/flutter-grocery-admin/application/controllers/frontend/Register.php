<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Front End Controller
 */
class Register extends FE_Controller 
{

	/**
	 * constructs required variables
	 */
	function __construct()
	{
		parent::__construct( NO_AUTH_CONTROL, 'REGISTER' );

		// load paypal library
		$this->load_paypal();



	}

	/**
	 * loads paypal config and libraries
	 */
	function load_paypal()
	{
		// Load PayPal config
        $this->config->load('paypal');

        $paypal = $this->Paypal_config->get_one_by('id');

        //prepare paypal config
        $config = array(

        	// Sandbox / testing mode option.
            'Sandbox' => $paypal->sandbox,

            // PayPal API username of the API caller
            'APIUsername' => $paypal->api_username,

            // PayPal API password of the API caller
            'APIPassword' => $paypal->api_password,

            // PayPal API signature of the API caller
            'APISignature' => $paypal->api_signature,

            // PayPal API subject (email address of 3rd party user that has granted API permission for your app)   
            'APISubject' => '',

            // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'APIVersion' => $paypal->api_version
        );

        if ($config['Sandbox']) {
        // if paypal is testing,open error reporting
        
            //error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        //load paypal library
        $this->load->library('paypal/Paypal_pro', $config);
	}
	

	/**
	 * Register Page
	 */
	function register()
	{
		$this->load_template( 'register' );
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
		
		$shop_data = array();
		
		if ( $this->get_data( 'id' )) {
			$shop_data['id'] = $this->get_data( 'id' );
		}

		// prepare shop name
		if ( $this->has_data( 'name' )) {
			$shop_data['name'] = $this->get_data( 'name' );
		}

		// prepare shop description
		if ( $this->has_data( 'description' )) {
			$shop_data['description'] = $this->get_data( 'description' );
		}

		// prepare shop email
		if ( $this->has_data( 'email' )) {
			$shop_data['email'] = $this->get_data( 'email' );
		}

		// prepare shop address1
		if ( $this->has_data( 'address1' )) {
			$shop_data['address1'] = $this->get_data( 'address1' );
		}

		// prepare shop address2
		if ( $this->has_data( 'address2' )) {
			$shop_data['address2'] = $this->get_data( 'address2' );
		}

		// prepare shop address3
		if ( $this->has_data( 'address3' )) {
			$shop_data['address3'] = $this->get_data( 'address3' );
		}

		// prepare shop about_phone1
		if ( $this->has_data( 'about_phone1' )) {
			$shop_data['about_phone1'] = $this->get_data( 'about_phone1' );
		}

		// prepare shop about_phone2
		if ( $this->has_data( 'about_phone2' )) {
			$shop_data['about_phone2'] = $this->get_data( 'about_phone2' );
		}

		// prepare shop about_phone2
		if ( $this->has_data( 'about_phone3' )) {
			$shop_data['about_phone3'] = $this->get_data( 'about_phone3' );
		}

		// prepare shop about_website
		if ( $this->has_data( 'about_website' )) {
			$shop_data['about_website'] = $this->get_data( 'about_website' );
		}
			
		$shop_data['is_featured'] = 0;
		
		$shop_data['status'] = 2;
		
		//user information
		if ( $this->get_data( 'user_id' )) {
			$user_data['user_id'] = $this->get_data( 'user_id' );
		}

		if ( $this->has_data( 'user_name' )) {
		
			$user_data['user_name'] = $this->get_data( 'user_name' );
		}

		if ( $this->has_data( 'user_email' )) {
		
			$user_data['user_email'] = $this->get_data( 'user_email' );
		}

		if ( $this->has_data( 'user_password' ) 
			&& !empty( $this->get_data( 'user_password' ))) {
			$user_data['user_password'] = md5( $this->get_data( 'user_password' ));
		}

		$user_data['role_id'] = 1;
		$user_data['status'] = 3;

		// save shop
		if ( ! $this->Shop->save( $shop_data, $id )) {
		
			// rollback the transaction
			//$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model');
			
			return;
		}
		// save user
		if ( ! $this->User->save( $user_data, $user_id )) {
		
			// rollback the transaction
			//$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model');
			
			return;
		}


		//get inserted product id
		$id = ( !$id )? $shop_data['id']: $id ;
		// prepare shop tag multiple select
		if ( $id ) {
			
			if($this->get_data( 'tagselect' ) != "") {
				$shop_data['prdselect'] = explode(",", $this->get_data( 'tagselect' ));
			} else {
				$shop_data['prdselect'] = explode(",", $this->get_data( 'existing_tagselect' ));
			}
			
			if(!$this->ps_delete->delete_shop_tag( $id )) {
				//loop
				for($i=0; $i<count($shop_data['prdselect']);$i++) {
					if($shop_data['prdselect'][$i] != "") {
						$select_data['tag_id'] = $shop_data['prdselect'][$i];
						$select_data['shop_id'] = $id;
						$select_data['added_date'] = date("Y-m-d H:i:s");
						$select_data['added_user_id'] = $user_data['user_id'];

						$this->Shoptag->save($select_data);
					}

				}
			}

			if ( ! $this->insert_images_icon_and_cover( $_FILES, 'shop', $id, "cover" )) {
				// if error in saving image

				// commit the transaction
				$this->db->trans_rollback();
				
				return;
			}
			
			if ( ! $this->insert_images_icon_and_cover( $_FILES, 'shop-icon', $id, "icon" )) {
				// if error in saving image

				// commit the transaction
				$this->db->trans_rollback();
				
				return;
			}
		}

		//// Need to save user & shop
		$user_id = ( !$user_id )? $user_data['user_id']: $user_id ;
		// prepare product checkbox
		if ( $user_id ) {
						
			$shopuser_data['shop_id'] = $id;
			$shopuser_data['user_id'] = $user_id;
			
			$this->User_shop->save($shopuser_data);
			
		}


		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_register_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_register_add' ));
			}
		}

		/* do paypal transaction */
		if ( $this->Paypal_config->is_paypal_enable()) {
		// if paypal is enable,
			if ( ! $this->set_express_checkout( $shop_data )) {
			// if there is an error in paypal transaction, redirect itself
				
				$this->session->set_flashdata( 'error', $this->lang->line('f_err_paypal_trans'));
				$this->db->trans_rollback();
				redirect( site_url( 'register' ));
			}
		} else {
		 	redirect( site_url('success'));
		}

		redirect( site_url() .'/register/' );
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $user_id = 0 ) {
	
		return true;
	}

	/**
	 * Check shop name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	*/
	function ajx_exists( $id = false )
	{
		// get shop name
		$name = $_REQUEST['name'];

		if ( $this->is_valid_name( $name, $id )) {
		// if the shop name is valid,
			
			echo "true";
		} else {
		// if invalid shop name,
			
			echo "false";
		}
	}

	/**
	 * Check shop name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	*/
	function ajx_exists_user( $id = false )
	{
		// get shop name
		$user_email = $_REQUEST['user_email'];

		if ( $this->is_valid_email( $user_email, $id )) {
		// if the shop name is valid,
			
			echo "true";
		} else {
		// if invalid shop name,
			
			echo "false";
		}
	}

	/**
	 * Determines if valid name.
	 *
	 * @param      <type>   $name  The  name
	 * @param      integer  $id     The  identifier
	 *
	 * @return     boolean  True if valid name, False otherwise.
	 */
	function is_valid_name( $name, $id = 0 )
	{		
		 $conds['name'] = $name;

			if ( strtolower( $this->Shop->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Shop->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
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
	function is_valid_email( $user_email, $id = 0 )
	{		
		 $conds['user_email'] = $user_email;

			if ( strtolower( $this->User->get_one( $id )->user_email ) == strtolower( $user_email )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->User->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}

			return true;
	}

	function success( ) {
		$this->load->view('frontend/partials/header', $this->data );
		$this->load->view('frontend/success.php' );
		$this->load->view('frontend/partials/footer' );
	}

	// Paypal Functions come here

	function set_express_checkout( $shop_data = false )
	{
		// prepare transaction info
        $this->prep_paypal_data( $shop_data, $Payments, $SECFields );

        $PayPalRequestData = array(
            'SECFields' => $SECFields,
            'Payments' => $Payments,
            'BuyerDetails' => array(),
            'ShippingOptions' => array(),
            'BillingAgreements' => array()
        );

        $PayPalResult = $this->paypal_pro->SetExpressCheckout( $PayPalRequestData );

        if ( ! $this->paypal_pro->APICallSuccessful( $PayPalResult['ACK'] )) {
        	//var_dump( $PayPalResult['ERRORS'] );
        	return false;
        } else {
            redirect( 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $PayPalResult['TOKEN'] );
            // Successful call.  Load view or whatever you need to do here.
        }
	}


	/**
	 * prepare paypal data
	 *
	 * @param      <type>   $city_data    The city data
	 * @param      array    $payments     The payments
	 * @param      array    $fields       The fields
	 * @param      boolean  $is_callback  Indicates if callback
	 */
	function prep_paypal_data( $shop_data, &$payments, &$fields, $is_callback = false )
	{
        // get paypal data
       	$paypal_info = $this->Paypal_config->get();
		// Payment Data
        $payments = array();
        $payment = array(
            'amt' => $paypal_info->price,
            'currencycode' => $paypal_info->currency_code, 
        );
		// prepare SECF and DECP data, items info
        if ( $is_callback ) {

        	$token = $this->input->get( 'token' );
	        $payer_id = $this->input->get( 'PayerID' );

	        $fields = array(
	        	// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
	            'token' => $token,

	            'payerid' => $payer_id,
	            'surveyquestion' => ''
            );
	        
        } else {
        	$fields = array(
        		// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
	            'returnurl' => site_url( 'success' ),

	            'cancelurl' => site_url( 'register' ),

	            'surveyquestion' => ''
	        );

	        // Payment Item
	        $payment_order_items = array();
	        $item = array(
				'name' => $shop_data['name'],
				'desc' => 'Registration fees for creating new shop`',
				'amt' => $paypal_info->price,
				'qty' => '1'
	        );
	        array_push($payment_order_items, $item);

	        $shop_update_data = array(
	        	'payment_status' => '1'
	        );
	        $this->Shop->save($shop_update_data,$shop_data['id']);
	        $this->load->library( 'PS_Mail' );
	        	//Sending Email to shop
				$to_who = "super_admin";
				$subject = get_msg('new_shop_register');
				$shop_id = $shop_data['id'];


				if ( !send_shop_registeration_emails( $shop_id, $to_who, $subject )) {

					$this->set_flash_msg( 'error', get_msg( 'err_email_not_send_to_user' ));
				
				}

				//Sending Email To user
				$to_who = "user";
				$subject = get_msg('success_shop_register');

				if ( !send_shop_registeration_emails( $shop_id, $to_who, $subject )) {

					$this->set_flash_msg( 'error', get_msg( 'err_email_not_send_to_user' ));
				
				}

	        // Add payment item to payment data
	        $payment['order_items'] = $payment_order_items;
        }

        array_push($payments, $payment);
	}

	/**
	 * privacy policy Page
	 */
	function privacy_policy()
	{
		$content = $this->Privacy_policy->get_one('privacy1')->content;
		$this->data['content'] = $content;
		$this->load_template( 'privacy_policy' );
	}

}