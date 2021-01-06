<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Coupons
 */
class Coupons extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		$is_login_user_nullable = true;

		// call the parent
		parent::__construct( 'Coupon', $is_login_user_nullable );

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
	        	'field' => 'coupon_code',
	        	'rules' => 'required'
	        )
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


	function check_post() 
	{
		$coupon_code = $this->post('coupon_code');
		$conds['coupon_code'] = $coupon_code;

		$shop_id = $this->post('shop_id');
		$conds['shop_id'] = $shop_id;

		if ( isset( $conds['coupon_code'] )) {
			$coupons = $this->Coupon->get_one_by( $conds ) ;

			if( $coupons->id == ""  ){
			$this->error_response( get_msg('coupon_not_found'));
			}

			$this->custom_response( $coupons );
			
		} 
		
		else {
				$this->error_response( get_msg( 'err_model' ));
		}

	}
}
