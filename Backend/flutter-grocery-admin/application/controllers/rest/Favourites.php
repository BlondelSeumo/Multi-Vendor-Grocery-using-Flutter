<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Favourites
 */
class Favourites extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		$is_login_user_nullable = false;

		// call the parent
		parent::__construct( 'Favourite', $is_login_user_nullable );

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
	        	'field' => 'product_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        )
        );

	}


	/**
	* When user press favourite button from app
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

		$product_id = $this->post('product_id');
		$user_id = $this->post('user_id');
		$shop_id = $this->post('shop_id');


		$users = global_user_check($user_id);
		// prep data
        $data = array( 'product_id' => $product_id, 'user_id' => $user_id, 'shop_id' => $shop_id );


		if ( $this->Favourite->exists( $data )) {
			
			if ( !$this->Favourite->delete_by( $data )) {
				$this->error_response( get_msg( 'err_model' ));
			} else {
				$conds_fav['product_id'] = $product_id;

			    $total_fav_count = $this->Favourite->count_all_by($conds_fav);

			    $prd_data['favourite_count'] = $total_fav_count;
			    $this->Product->save($prd_data, $product_id);
			}

		} else {

			if ( !$this->Favourite->save( $data )) {
				$this->error_response( get_msg( 'err_model' ));
			} else {
				$conds_fav['product_id'] = $product_id;

			    $total_fav_count = $this->Favourite->count_all_by($conds_fav);

			    $prd_data['favourite_count'] = $total_fav_count;
			    $this->Product->save($prd_data, $product_id);
			}

		}

		$obj = new stdClass;
		$obj->id = $product_id;
		$product = $this->Product->get_one( $obj->id );
		
		$product->login_user_id_post = $user_id;
		$this->ps_adapter->convert_product( $product );
		$this->custom_response( $product );
		

	}
}