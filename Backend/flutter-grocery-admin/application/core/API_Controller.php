<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller for API classes
 */
class API_Controller extends REST_Controller
{
	// model to access database
	protected $model;

	// validation rule for new record
	protected $create_validation_rules;

	// validation rule for update record
	protected $update_validation_rules;

	// validation rule for delete record
	protected $delete_validation_rules;

	// is adding record?
	protected $is_add;

	// is updating record?
	protected $is_update;

	// is deleting record?
	protected $is_delete;

	// is get record using GET method?
	protected $is_get;

	// is search record using GET method?
	protected $is_search;

	// login user id API parameter key name
	protected $login_user_key;

	// login user id
	protected $login_user_id;

	// if API allowed zero login user id,
	protected $is_login_user_nullable;

	// default value to ignore user id
	protected $ignore_user_id;

	/**
	 * construct the parent 
	 */
	function __construct( $model, $is_login_user_nullable = false )
	{
		// header('Access-Control-Allow-Origin: *');
    	// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		parent::__construct();

		// set the model object
		$this->model = $this->{$model};

		// load security library
		$this->load->library( 'PS_Security' );

		// load the adapter library
		$this->load->library( 'PS_Adapter' );
		
		// set the login user nullable
		$this->is_login_user_nullable = $is_login_user_nullable;

		// login user id key
		$this->login_user_key = "login_user_id";

		// default value to ignore user id for API
		$this->ignore_user_id = "nologinuser";

		if ( $this->is_logged_in()) {
		// if login user id is existed, pass the id to the adapter

			$this->login_user_id = $this->get_login_user_id();

			if ( !$this->User->is_exist( $this->login_user_id ) && !$this->is_login_user_nullable ) {
			// if login user id not existed in system,

				$this->error_response( get_msg( 'invalid_login_user_id' ));
			}

			$this->ps_adapter->set_login_user_id( $this->login_user_id );
		}

		// load the mail library
		$this->load->library( 'PS_Mail' );

		if ( ! $this->is_valid_api_key()) {
		// if invalid api key

			$this->response( array(
				'status' => 'error',
				'message' => get_msg( 'invalid_api_key' )
			), 404 );
		}

		// default validation rules
		$this->default_validation_rules();
	}

	/**
	 * Determines if logged in.
	 *
	 * @return     boolean  True if logged in, False otherwise.
	 */
	function is_logged_in()
	{
		// it is login user if the GET login_user_id is not null and default key
		// it is login user if the POST login_user_id is not null
		// it is login user if the PUT login_user_id is not null
		return ( $this->get( $this->login_user_key ) != null && $this->get( $this->login_user_key ) != $this->ignore_user_id ) ||
			( $this->post( $this->login_user_key ) != null ) ||
			( $this->put( $this->login_user_key ) != null ) ;
	}

	/**
	 * Gets the login user identifier.
	 */
	function get_login_user_id()
	{
		/**
		 * GET['login_user_id'] will create POST['user_id']
		 * POST['login_user_id'] will create POST['user_id'] and remove POST['login_user_id']
		 * PUT['login_user_id'] will create PUT['user_id'] and remove PUT['login_user_id']
		 */
		// if exist in get variable,
		if ( $this->get( $this->login_user_key ) != null) {

			// get user id
			$login_user_id = $this->get( $this->login_user_key );

			// replace user_id
			$this->_post_args['user_id'] = $this->get( $this->login_user_key );
			
			return $this->get( $this->login_user_key );
		}

		// if exist in post variable,
		if ( $this->post( $this->login_user_key ) != null) {

			// get user id
			$login_user_id = $this->post( $this->login_user_key );

			// replace user_id
			$this->_post_args['user_id'] = $this->post( $this->login_user_key );
			unset( $this->_post_args[ $this->login_user_key ] );
			
			return $login_user_id;
		}

		// if exist in put variable,
		if ( $this->put( $this->login_user_key ) != null) {

			// get user id
			$login_user_id = $this->put( $this->login_user_key );

			// replace user_id
			$this->_put_args['user_id'] = $this->put( $this->login_user_key );
			unset( $this->_put_args[ $this->login_user_key ] );
			
			return $login_user_id;
		}
	}

	/**
	 * Convert logged in user id to user_id
	 */
	function get_similar_key( $actual, $similar )
	{
		if ( empty( parent::post( $actual )) && empty( parent::put( $actual ))) {
		// if actual key is not existed in POST and PUT, return similar

			return $similar;
		}

		// else, just return normal key
		return $actual;
	}

	/**
	 * Override Get variables
	 *
	 * @param      <type>  $key    The key
	 */
	function get( $key = NULL, $xss_clean = true )
	{
		return $this->ps_security->clean_input( parent::get( $key, $xss_clean ));
	}

	/**
	 * Override Post variables
	 *
	 * @param      <type>  $key    The key
	 */
	function post( $key = NULL, $xss_clean = true )
	{
		if ( $key == 'user_id' ) {
		// if key is user_id and user_id is not in variable, get the similar key

			$key = $this->get_similar_key( 'user_id', $this->login_user_key );
		}

		return $this->ps_security->clean_input( parent::post( $key, $xss_clean ));
	}

	/**
	 * Override Put variables
	 *
	 * @param      <type>  $key    The key
	 */
	function put( $key = NULL, $xss_clean = true )
	{
		if ( $key == 'user_id' ) {
		// if key is user_id and user_id is not in variable, get the similar key
			
			$key = $this->get_similar_key( 'user_id', $this->login_user_key );
		}

		return $this->ps_security->clean_input( parent::put( $key, $xss_clean ));
	}

	/**
	 * Determines if valid api key.
	 *
	 * @return     boolean  True if valid api key, False otherwise.
	 */
	function is_valid_api_key()
	{	
		$client_api_key = $this->get( 'api_key' );

		if ( $client_api_key == NULL ) {
		// if API key is null, return false;

			return false;
		}

		$server_api_key = $this->Api_key->get_one( 'apikey1' )->key;

		if ( $client_api_key != $server_api_key ) {
		// if API key is different with server api key, return false;

			return false;
		}

		return true;
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj ) 
	{
		// convert added_date date string
		if ( isset( $obj->added_date )) {
			
			// added_date timestamp string
			$obj->added_date_str = ago( $obj->added_date );
		}

		if ( isset( $obj->trans_status_id )) {
			$trans_status = $this->Transactionstatus->get_one( $obj->trans_status_id );

			$this->ps_adapter->convert_transaction_status( $trans_status );

			$obj->transaction_status = $trans_status;
		}

		if ( isset( $obj->shop_id )) {
			$trans_shop = $this->Shop->get_one( $obj->shop_id );

			$this->ps_adapter->convert_shop( $trans_shop );

			$obj->shop = $trans_shop;
		}
	}

	/**
	 * Gets the default photo.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $type   The type
	 */
	function get_default_photo( $id, $type )
	{
		$default_photo = "";

		// get all images
		$img = $this->Image->get_all_by( array( 'img_parent_id' => $id, 'img_type' => $type ))->result();

		if ( count( $img ) > 0 ) {
		// if there are images for news,
			
			$default_photo = $img[0];
		} else {
		// if no image, return empty object

			$default_photo = $this->Image->get_empty_object();
		}

		return $default_photo;
	}

	/**
	 * Response Error
	 *
	 * @param      <type>  $msg    The message
	 */
	function error_response( $msg )
	{
		$this->response( array(
			'status' => 'error',
			'message' => $msg
		), 404 );
	}

	/**
	 * Response Success
	 *
	 * @param      <type>  $msg    The message
	 */
	function success_response( $msg )
	{
		$this->response( array(
			'status' => 'success',
			'message' => $msg
		));
	}

	/**
	 * Custome Response return 404 if not data found
	 *
	 * @param      <type>  $data   The data
	 */
	function custom_response( $data,$offset = false, $require_convert = true )
	{
		if ( empty( $data )) {
		// if there is no data, return error
			if (empty( $data ) && $offset == 0) {


				$this->error_response( $this->config->item( 'record_not_found') );
			} else if (empty( $data ) && $offset > 0) {
				$this->error_response( $this->config->item( 'record_no_pagination') );
			
			} 
		} else if ( $require_convert ) {
		// if there is data, return the list
			if ( is_array( $data )) {
			// if the data is array

				foreach ( $data as $obj ) {

					// convert object for each obj
					$this->convert_object( $obj );
				}
			} else {

				$this->convert_object( $data );
			}
		}

		$data = $this->ps_security->clean_output( $data );

		$this->response( $data );
	}


	/**
	 * Custome Response return 404 if not data found
	 *
	 * @param      <type>  $data   The data
	 */
	function custom_fail_response( $data, $require_convert = true, $message = "" )
	{
		if ( empty( $data )) {
		// if there is no data, return error

			$this->error_response( get_msg( 'no_record' ) );

		} else if ( $require_convert ) {
		// if there is data, return the list

			if ( is_array( $data )) {
			// if the data is array

				foreach ( $data as $obj ) {

					// convert object for each obj
					//$this->convert_object( $obj );
					$obj->trans_status = $message;
					$this->ps_adapter->convert_product( $obj );
				}
			} else {
				$data->trans_status = $message;
				//$this->convert_object( $data );
				$this->ps_adapter->convert_product( $data );
			}
		}

		$data = $this->ps_security->clean_output( $data );

		$this->response( $data );
		// $this->response( array(
		// 	'status' => $message,
		// 	'data' => $data
		// ));
	}

	/**
	 * Default Validation Rules
	 */
	function default_validation_rules()
	{
		// default rules
		$rules = array(
			array(
				'field' => $this->model->primary_key,
				'rules' => 'required|callback_id_check'
			)
		);

		// set to update validation rules
		$this->update_validation_rules = $rules;

		// set to delete_validation_rules
		$this->delete_validation_rules = $rules;
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
    	$tmp_model = $this->model;

    	if ( $model_name != false) {
    		$tmp_model = $this->{$model_name};
    	}

        if ( !$tmp_model->is_exist( $id )) {
        
            $this->form_validation->set_message('id_check', 'Invalid {field}');
            return false;
        }

        return true;
    }

	/**
	 * { function_description }
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
		$user_data = array_merge( $this->get(), $this->post(), $this->put() );

		$this->form_validation->set_data( $user_data );
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules( $rules );

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			$errors = $this->form_validation->error_array();

			if ( count( $errors ) == 1 ) {
			// if error count is 1, remove '\n'

				$this->error_response( trim(validation_errors()) );
			}

			$this->error_response( validation_errors());
		}

		return true;
	}

	/**
	 * Returns default condition like default order by
	 * @return array custom_condition_array
	 */
	function default_conds()
	{
		return array();
	}

	/**
	 * Get all or Get One
	 */
	function get_get()
	{
		// add flag for default query
		$this->is_get = true;

		// get id
		$id = $this->get( 'id' );
		$shop_id = $this->get( 'shop_id' );
		
		if ( $id ) {
			// if 'id' is existed, get one record only
			$data = $this->model->get_one( $id, $shop_id );

			if ( isset( $data->is_empty_object )) {
			// if the id is not existed in the return object, the object is empty
				
				$data = array();
			}

			$this->custom_response( $data );
		}

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );
		if ($conds['shop_id'] == "" && $conds['feed_status'] == 1) {
			$conds_status['no_publish_filter'] = 0;
			$unplish_shop = $this->Shop->get_one_by($conds_status);
			$shop_id = $unplish_shop->id;
			if ($shop_id!=" ") {
				$conds['check_status'] = 1;
				$conds['shop_id'] = $shop_id;
			}
		}
		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( count( $conds ) == 0 ) {
		// if 'id' is not existed, get all	
		
			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty
				
				$data = $this->model->get_all( $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				
				$data = $this->model->get_all( $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all()->result();
			}

			$this->custom_response( $data,$offset );
		} else {

			if ($conds['collection_get'] == 1 || $conds['blog_get'] == 1) {
				$conds['shop_status'] = 1;
				if ( !empty( $limit ) && !empty( $offset )) {
				// if limit & offset is not empty

					$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
				} else if ( !empty( $limit )) {
				// if limit is not empty

					$data = $this->model->get_all_by( $conds, $limit )->result();
				} else {
				// if both are empty

					$data = $this->model->get_all_by( $conds )->result();
				}
			}else{
				if ( !empty( $limit ) && !empty( $offset )) {
				// if limit & offset is not empty

					$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
				} else if ( !empty( $limit )) {
				// if limit is not empty

					$data = $this->model->get_all_by( $conds, $limit )->result();
				} else {
				// if both are empty

					$data = $this->model->get_all_by( $conds )->result();
				}
			}

			

			$this->custom_response( $data , $offset);

			
		}
	}

	/**
	 * Get all or Get One
	 */
	function get_favourite_get()
	{
		// add flag for default query
		$this->is_get = true;

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );
		$conds['user_id'] = $this->get_login_user_id();
		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty

			$data = $this->model->get_product_favourite( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->get_product_favourite( $conds, $limit )->result();
		} else {
		// if both are empty
			$data = $this->model->get_product_favourite( $conds )->result();
		}

		$this->custom_response( $data ,$offset);
	}

	/**
	 * Get Like by user_id
	 */
	function get_like_get()
	{
		// add flag for default query
		$this->is_get = true;

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );
		$conds['user_id'] = $this->get( 'user_id' );

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty

			$data = $this->model->get_product_like( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->get_product_like( $conds, $limit )->result();
		} else {
		// if both are empty
			$data = $this->model->get_product_like( $conds )->result();
		}

		$this->custom_response( $data ,$offset);
	}

	function trending_category_get() 
	{
		// add flag for default query
		$this->is_get = true;

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty

			$data = $this->model->get_all_trending_category( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->get_all_trending_category( $conds, $limit )->result();
		} else {
		// if both are empty
			$data = $this->model->get_all_trending_category( $conds )->result();
		}

		$this->custom_response( $data ,$offset);
	}

	function related_product_trending_get()
	{
		// add flag for default query
		$this->is_get = true;

		$current_product_id = $this->get( 'id' );
		$current_cat_id 	= $this->get( 'cat_id' );


		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty

			$data = $this->model->get_all_related_product_trending( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->get_all_related_product_trending( $conds, $limit )->result();
		} else {
		// if both are empty
			$data = $this->model->get_all_related_product_trending( $conds )->result();
		}

		$this->custom_response( $data ,$offset);

	}

	function all_collection_products_get( $conds = array(), $limit = false, $offset = false ) 
	{
		$this->is_get = true;

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		$collection_id = $this->get( 'id' );

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty
			$data = $this->model->all_products_by_collection( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->all_products_by_collection( $conds, $limit )->result();
		} else {
		// if both are empty
			$data = $this->model->all_products_by_collection( $conds )->result();
		}
		$this->custom_response( $data ,$offset);
	}

	function get_shop_tag_id_get() 
	{
		// add flag for default query
		$this->is_get = true;

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );
		$conds['tag_id'] = $this->get( 'tag_id' );

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty

			$data = $this->model->get_all_shop_by_tag_id( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->get_all_shop_by_tag_id( $conds, $limit )->result();
		} else {
		// if both are empty
			$data = $this->model->get_all_shop_by_tag_id( $conds )->result();
		}


		$this->custom_response( $data ,$offset);
	}

	/**
	 * Search API
	 */
	function search_post()
	{
		// add flag for default query
		$this->is_search = true;

		// add default conds
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );

		// check empty condition
		$final_conds = array();
		foreach( $conds as $key => $value ) {
			if ( !empty( $value )) {
				$final_conds[$key] = $value;
			}
		}
		$conds = $final_conds;

		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		if ($conds['prd_search'] == 1) {
			$conds['shop_status'] = 1;

			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty

				$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				$data = $this->model->get_all_by( $conds, $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all_by( $conds )->result();
			}

		}else{

			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty

				$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				$data = $this->model->get_all_by( $conds, $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all_by( $conds )->result();
			}

		}

		$this->custom_response( $data, $offset );
	}

	//product_count
	function get_collection_id()
	{

		$collection_id = $this->get( 'collection_id' );

		return $collection_id;

	}


	/**
	 * Custome Response return 404 if not data found
	 *
	 * @param      <type>  $data   The data
	 */
	function custom_response_noti( $data,$offset = false, $require_convert = true )
	{	
		if ( empty( $data )) {
		// if there is no data, return error
			if (empty( $data ) && $offset == 0) {
				$this->error_response($this->config->item( 'record_not_found'));
			} else if (empty( $data ) && $offset > 0) {
				$this->error_response($this->config->item( 'record_no_pagination'));
			}

		} else if ( $require_convert ) {
		// if there is data, return the list
			if ( is_array( $data )) {
			// if the data is array
				foreach ( $data as $obj ) {
					// convert object for each obj
					if($this->get_login_user_id() != "") {
						$noti_user_data = array(
				        	"noti_id" => $obj->id,
				        	"user_id" => $this->get_login_user_id(),
				        	"device_token" => $this->post('device_token')
				    	);
						if ( !$this->Notireaduser->exists( $noti_user_data )) {
							$obj->is_read = 88;
						} else {
							$obj->is_read = 100;
						}
					} 

					$this->convert_object( $obj );
				}
			} else {
				if($this->get_login_user_id() != "") {
					$noti_user_data = array(
			        	"noti_id" => $data->id,
			        	"user_id" => $this->get_login_user_id(),
			        	"device_token" => $this->post('device_token')
			    	);
					if ( !$this->Notireaduser->exists( $noti_user_data )) {
						$data->is_read = 99;
					} else {
						$data->is_read = 100;
					}
				} 

				$this->convert_object( $data );
			}
		}
		$data = $this->ps_security->clean_output( $data );

		

		$this->response( $data );
	}

	/**
	 * Adds a post.
	 */
	function add_post()
	{
		// set the add flag for custom response
		$this->is_add = true;

		if ( !$this->is_valid( $this->create_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->post();

		if ($data['shop_id'] != "") {
			$data['shop_id'] = $this->post('shop_id');

		}
		
		if ( !$this->model->save( $data )) {
			$this->error_response( get_msg( 'err_model' ));
		}

		// response the inserted object	
		$obj = $this->model->get_one( $data[$this->model->primary_key] );

		$this->custom_response( $obj );
	}

	/**
	 * Adds a post.
	 */
	function add_rating_post()
	{
		// set the add flag for custom response
		$this->is_add = true;

		if ( !$this->is_valid( $this->create_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->post();
		$user_id = $data['user_id'];

		$users = global_user_check($user_id);
		
		$conds['user_id'] = $user_id;
		$conds['product_id'] = $data['product_id'];
		
		$id = $this->model->get_one_by($conds)->id;

		$rating = $data['rating'];
		if ( $id ) {

			$this->model->save( $data, $id );

			// response the inserted object	
			$obj = $this->model->get_one( $id );
		} else {
			$this->model->save( $data );

			// response the inserted object	
			$obj = $this->model->get_one( $data[$this->model->primary_key] );
		}

		//Need to update rating value at product
		$conds_rating['product_id'] = $obj->product_id;

		$total_rating_count = $this->Rate->count_all_by($conds_rating);
		$sum_rating_value = $this->Rate->sum_all_by($conds_rating)->result()[0]->rating;

		if($total_rating_count > 0) {
			$total_rating_value = number_format((float) ($sum_rating_value  / $total_rating_count), 1, '.', '');
		} else {
			$total_rating_value = 0;
		}

		$item_data['overall_rating'] = $total_rating_value;
		$this->Product->save($item_data, $obj->product_id);

		
		//$obj_item = $this->Product->get_one( $obj->product_id );
		$obj_rating = $this->Rate->get_one( $obj->id );

		$this->ps_adapter->convert_rating( $obj_rating);
		$this->custom_response( $obj_rating );
	}

	/**
	 * Adds a post.
	 */
	function add_touch_post()
	{
		// set the add flag for custom response
		$this->is_add = true;

		if ( !$this->is_valid( $this->create_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->post();
		$data['shop_id'] = $this->post('shop_id');
		if ( !$this->model->save( $data )) {
			$this->error_response( get_msg( 'err_model' ));
		}

		// response the inserted object	
		$obj = $this->model->get_one( $data[$this->model->primary_key] );

		if($obj->type_name == "product"){
			//Need to update touch count value at product
			$conds_rating['type_id'] = $obj->type_id;

			$total_touch_count = $this->Touch->count_all_by($conds_rating);

			$item_data['touch_count'] = $total_touch_count;
			$this->Product->save($item_data, $obj->type_id);
		} else if($obj->type_name == "category"){
			//Need to update touch count value at category
			$conds_rating['type_id'] = $obj->type_id;

			$total_touch_count = $this->Touch->count_all_by($conds_rating);

			$cat_data['touch_count'] = $total_touch_count;
			$this->Category->save($cat_data, $obj->type_id);
		} else {
			//Need to update touch count value at shop
			$conds_rating['type_id'] = $obj->type_id;

			$total_touch_count = $this->Touch->count_all_by($conds_rating);

			$shop_data['touch_count'] = $total_touch_count;
			$this->Shop->save($shop_data, $obj->type_id);
		}
		$this->custom_response( $obj );
	}

	/**
	 * Adds a post.
	 */
	function update_put()
	{
		// set the add flag for custom response
		$this->is_update = true;

		if ( !$this->is_valid( $this->update_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->put();

		// get id
		$id = $this->get( $this->model->primary_key );

		if ( !$this->model->save( $data, $id )) {
		// error in saving, 
			
			$this->error_response( get_msg( 'err_model' ));
		}

		// response the inserted object	
		$obj = $this->model->get_one( $id );

		$this->custom_response( $obj );
	}

	/**
	 * Delete the record
	 */
	function delete_delete()
	{
		// set the add flag for custom response
		$this->is_delete = true;

		if ( !$this->is_valid( $this->delete_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get id
		$id = $this->get( $this->model->primary_key );

		if ( !$this->model->delete( $id )) {
		// error in saving, 
			
			$this->error_response( get_msg( 'err_model' ));
		}

		$this->success_response( get_msg( 'success_delete' ));
	}


	/**
  	* Get Delete Product By Date Range.
  	*/
	 function get_delete_product_post()
	 {
	  $start = $this->post('start_date');
	  $end   = $this->post('end_date');
	  
	  $conds['start_date'] = $start;
	  $conds['end_date']   = $end;
	  $conds['type_name']  = "product";


	  //$deleted_product_ids = $this->Product_delete->get_all_by($conds)->result();
	  $deleted_product_ids = $this->Delete_history->get_all_by($conds)->result();

	  $this->custom_response( $deleted_product_ids, false );



	 }

	/**
  	* Get Delete Shop By Date Range.
  	*/
	function get_delete_shop_post()
	{
	  
		$start = $this->post('start_date');
		$end   = $this->post('end_date');
		  
		$conds['start_date'] = $start;
		$conds['end_date']   = $end;


		$deleted_shop_ids = $this->Shop_delete->get_all_by($conds)->result();

		$this->custom_response( $deleted_shop_ids, false );

	}

	function get_token_get()
	{

		$shop_obj = $this->Shop->get_all()->result();


		$environment = $shop_obj[0]->paypal_environment;
		$merchantId  = $shop_obj[0]->paypal_merchant_id;
		$publicKey   = $shop_obj[0]->paypal_public_key;
		$privateKey  = $shop_obj[0]->paypal_private_key;


		//echo ">>" . $environment . " - " . $merchantId . " - " . $publicKey . " - " . $privateKey; die;

		$gateway = new Braintree_Gateway([
		  'environment' => 'sandbox',
		  'merchantId' => 'h6ggypvjgt4tzz2k',
		  'publicKey' => '256y6grqr936tpjf',
		  'privateKey' => '0d6aadf4b586a84844ceadc834dc851f'
		]);

		$clientToken = $gateway->clientToken()->generate();

		//$this->custom_response( $clientToken );

		if($clientToken != "") {
			$this->response( array(
				'status' => 'success',
				'message' => $clientToken
			));
		} else {
			$this->error_response( get_msg( 'token_not_round' ));
		}

	}




	/**
  	* Get Delete History By Date Range.
  	*/
	function get_delete_history_post()
	{
	  	

		$start = $this->post('start_date');
		$end   = $this->post('end_date');
		$user_id = $this->post('user_id');
		  
		$conds['start_date'] = $start;
		$conds['end_date']   = $end;

		$conds['order_by'] = 1;
		$conds['order_by_field'] = "type_name";
		$conds['order_by_type'] = "desc";


		//$deleted_his_ids = $this->Delete_history->get_all_history_by($conds)->result();
		$deleted_his_ids = $this->Delete_history->get_all_by($conds)->result();

		$this->custom_response_history( $deleted_his_ids, $user_id, false );

	}


	/**
	 * Custome Response return 404 if not data found
	 *
	 * @param      <type>  $data   The data
	 */
	function custom_response_history( $data, $user_id, $require_convert = true )
	{
		

		$version_object = new stdClass; 
		//version obj
		$version_object->version_no           = $this->Version->get_one("1")->version_no; 
		$version_object->version_force_update = $this->Version->get_one("1")->version_force_update;
		$version_object->version_title        = $this->Version->get_one("1")->version_title;
		$version_object->version_message      = $this->Version->get_one("1")->version_message;
		$version_object->version_need_clear_data      = $this->Version->get_one("1")->version_need_clear_data;

		//deliboy version obj
		$deliboy_version_object->deli_boy_version_no           = $this->Version->get_one("1")->deli_boy_version_no; 
		$deliboy_version_object->deli_boy_version_force_update = $this->Version->get_one("1")->deli_boy_version_force_update;
		$deliboy_version_object->deli_boy_version_title        = $this->Version->get_one("1")->deli_boy_version_title;
		$deliboy_version_object->deli_boy_version_message      = $this->Version->get_one("1")->deli_boy_version_message;
		$deliboy_version_object->deli_boy_version_need_clear_data      = $this->Version->get_one("1")->deli_boy_version_need_clear_data;

		$is_banned = $this->User->get_one($user_id)->is_banned;
		$user_object->user_status = $this->User->get_one($user_id)->status;

		$user_data = $this->User->get_one($user_id);
		//($user_data->status);die;

		if ($user_id == "nologinuser") {
			$user_object->user_status = "nologinuser";
		}elseif ($user_data->is_empty_object == 1 ) {
			$user_object->user_status = "deleted";
		}elseif ($is_banned == 1 ) {
			$user_object->user_status = "banned";
		}elseif ($user_object->user_status == 1) {
			$user_object->user_status = "active";
		}elseif ($user_object->user_status == 2) {
			$user_object->user_status = "pending";
		}elseif ($user_object->user_status == 0) {
			$user_object->user_status = "unpublished";
		}

		//shop

		$conds['status'] = 1;

		$shop_count = $this->Shop->count_all_by($conds);

		if ($shop_count == 1) {
			$shop_object->is_multi = 0;
			$shop_id = $this->Shop->get_one_by($conds)->id;
			$shop_object->shop = $this->Shop->get_one($shop_id);
			
		}elseif ($shop_count > 1) {
			$shop_object->is_multi = 1;
			$shop_id = $this->Shop->get_one_by($conds)->id;
			$shop_object->shop = $this->Shop->get_one($shop_id);
		}
		
		
		$final_data->version = $version_object;
		$final_data->deliboy_version = $deliboy_version_object;
		$final_data->user_info = $user_object;
		$final_data->paystack_enabled = $this->Shop->get_one($id)->paystack_enabled;
		$final_data->paystack_key = $this->Shop->get_one($id)->paystack_key;
		$final_data->delete_history = $data;
		//$final_data->enable_comment = $this->App_config->get_one("app_set1")->enable_comment;
		//$final_data->enable_review = $this->App_config->get_one("app_set1")->enable_review; 
		$final_data->contact_phone = $this->About->get_one("abt1")->about_phone;
		$final_data->contact_email = $this->About->get_one("abt1")->about_email; 
		$final_data->contact_website = $this->About->get_one("abt1")->about_website;
		$final_data->shop_obj = $shop_object;



		
		$final_data = $this->ps_security->clean_output( $final_data );


		$this->response( $final_data );

	}

	/**
	 * Adds a post.
	 */
	function add_shop_rating_post()
	{
		// set the add flag for custom response
		$this->is_add = true;

		if ( !$this->is_valid( $this->create_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->post();
		$user_id = $data['user_id'];

		$users = global_user_check($user_id);
		
		$conds['user_id'] = $user_id;
		$conds['shop_id'] = $data['shop_id'];
		$id = $this->model->get_one_by($conds)->id;
		$rating = $data['rating'];
		if ( $id ) {

			$this->model->save( $data, $id );

			// response the inserted object	
			$obj = $this->model->get_one( $id );
		} else {
			$this->model->save( $data );

			// response the inserted object	
			$obj = $this->model->get_one( $data[$this->model->primary_key] );
		}

		//Need to update rating value at product
		$conds_rating['shop_id'] = $obj->shop_id;

		$total_rating_count = $this->Shop_rate->count_all_by($conds_rating);
		$sum_rating_value = $this->Shop_rate->sum_all_by($conds_rating)->result()[0]->rating;

		if($total_rating_count > 0) {
			$total_rating_value = number_format((float) ($sum_rating_value  / $total_rating_count), 1, '.', '');
		} else {
			$total_rating_value = 0;
		}

		//print_r($total_rating_value);die;

		$shop_data['overall_rating'] = $total_rating_value;
		$this->Shop->save($shop_data, $obj->shop_id);

		
		$obj_shop = $this->Shop->get_one( $obj->shop_id );
		
		$this->ps_adapter->convert_shop( $obj_shop);
		$this->custom_response( $obj_shop );
	}

	// search category

	function search_cat_post()
	{
		// add flag for default query
		$this->is_search = true;

		// add default conds
		$default_conds = $this->default_conds();
		$user_conds = $this->get();
		$conds = array_merge( $default_conds, $user_conds );

		// check empty condition
		$final_conds = array();
		foreach( $conds as $key => $value ) {
			if ( !empty( $value )) {
				$final_conds[$key] = $value;
			}
		}
		$conds = $final_conds;

		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		$conds['shop_id'] = $this->post('shop_id');

		if ($conds['shop_id'] == "") {
			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty

				$data = $this->model->get_category( $conds, $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				$data = $this->model->get_category( $conds, $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_category( $conds )->result();
			}
		} else{

			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty

				$data = $this->model->get_category( $conds, $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				$data = $this->model->get_category( $conds, $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_category( $conds )->result();
			}
		}
		
		$this->custom_response( $data );

	}	

  
}