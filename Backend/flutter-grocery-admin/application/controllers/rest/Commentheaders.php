<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Commentheaders
 */
class Commentheaders extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		$is_login_user_nullable = false;

		// call the parent
		parent::__construct( 'Commentheader', $is_login_user_nullable );

		// set the validation rules for create and update
		$this->validation_rules();
	}

	function default_conds()
	{
		$conds = array();

		if ( $this->is_get ) {
		// if is get record using GET method
			//$conds['order_by_field'] = "added_date";
			//$conds['order_by_type'] = "desc";
		}

		return $conds;
	}

	/**
	 * Determines if valid input.
	 */
	function validation_rules()
	{
		// validation rules for create
		$this->create_validation_rules = array(
			array(
	        	'field' => 'product_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'header_comment',
	        	'rules' => 'required'
	        )
        );

	}


	/**
	* When user press like button from app
	*/
	function press_post() 
	{
		
		// validation rules for create
		$rules = array(
			array(
	        	'field' => 'product_id',
	        	'rules' => 'required|callback_id_check[Product]'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
	        )
        );

		// validation
        if ( !$this->is_valid( $rules )) exit;

		$product_id 		 	= $this->post('product_id');
		$user_id 			 	= $this->post('user_id');
		$header_comment 		= $this->post('header_comment');
		$shop_id				= $this->post('shop_id');

		$users = global_user_check($user_id);
		
		// prep data
        $data = array( 
        	'product_id' => $product_id, 
        	'user_id' => $user_id, 
        	'shop_id' => $shop_id,
        	'header_comment' => $header_comment
        );

        if ( !$this->Commentheader->save( $data )) {
			$this->error_response( get_msg( 'err_model_header' ));
		}

		
		$conds = array("id" => $data['id']);
		$comments = $this->Commentheader->get_all_by($conds)->result();

		foreach ( $comments as $cmt_obj ) {
			$cmt_obj->comment_reply_count =  $this->Commentdetail->count_all_by(array("header_id" => $cmt_obj->id));
		}

		$this->custom_response( $comments );
		

	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		$obj->comment_reply_count =  $this->Commentdetail->count_all_by(array("header_id" => $obj->id));

		$obj->user = $this->User->get_one_by(array("user_id" => $obj->user_id));

		parent::convert_object( $obj );

	}
}