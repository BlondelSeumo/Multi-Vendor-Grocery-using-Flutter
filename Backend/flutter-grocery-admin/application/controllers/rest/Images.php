<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for News
 */
class Images extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Image' );
		$this->load->library( 'PS_Image' );
	}

	function upload_post()
	{
		
		$platform_name = $this->post('platform_name');
		if ( !$platform_name ) {
			$this->custom_response( get_msg('Required Platform') ) ;
		}
		
		$user_id = $this->post('user_id');
		$users = global_user_check($user_id);

		if($platform_name == "ios") {
			
			
			if ( !$user_id ) {
				$this->custom_response( get_msg('Required User ID') );
			}
			
			$uploaddir = 'uploads/';
			
			$path_parts = pathinfo( $_FILES['pic']['name'] );
			//$filename = $path_parts['filename'] . date( 'YmdHis' ) .'.'. $path_parts['extension'];
			$filename = $path_parts['filename'] .'.'. $path_parts['extension'];
			
			//if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploaddir . $filename)) {
			if ($this->ps_image->upload( $_FILES )) {
				
				//call to image reseize
			   	//$this->image_resize_calculation( FCPATH. $uploaddir . $filename );

			   	$user_data = array( 'user_profile_photo' => $filename );
				   if ( $this->User->save( $user_data, $user_id ) ) {
					   	
					   	$user = $this->User->get_one( $user_id );

					   	$this->ps_adapter->convert_user( $user );
					   	
					   	$this->custom_response( $user );
				   } else {
					   	$this->error_response( get_msg('file_na') );
				   }
			   
			} else {
			   $this->error_response( get_msg('file_na') );
				
			}
			
		} else {
			
			$uploaddir = 'uploads/';

			$path_parts = pathinfo( $_FILES['file']['name'] );
			//$filename = $path_parts['filename'] . date( 'YmdHis' ) .'.'. $path_parts['extension'];
			$filename = $path_parts['filename'] .'.'. $path_parts['extension'];

			//if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $filename)) {
			if ($this->ps_image->upload( $_FILES )) {

				//call to image reseize
			   	//$this->image_resize_calculation( FCPATH. $uploaddir . $filename );

			   $user_data = array( 'user_profile_photo' => $filename );
				   if ( $this->User->save( $user_data, $user_id ) ) {

					   	$user = $this->User->get_one( $user_id );

					   	$this->ps_adapter->convert_user( $user );
					   	
					   	$this->custom_response( $user );

				   } else {
					   	$this->error_response( get_msg('file_na') );
				   }
			} else {
			   $this->error_response( get_msg('file_na') );
				
			}



		}
		
	}

	function upload_shop_post()
	{
		
		$shop_rate_id = $this->post('shop_rate_id');
		$files = $this->post('file');
		$img_id = $this->post('img_id');

		if ($img_id == "") {
			
			// upload images
			$upload_data = $this->ps_image->upload( $_FILES );
			foreach ( $upload_data as $upload ) {
			   	$shop_img_data = array( 
				   	'img_parent_id'=> $shop_rate_id,
					'img_path' => $upload['file_name'],
					'img_type' => "shop_rate",
					'img_width'=> $upload['image_width'],
					'img_height'=> $upload['image_height']
			   	);
			}
		   if ( $this->Image->save( $shop_img_data, $img_id ) ) {
		   		$conds['img_path'] = $shop_img_data['img_path'];
		   		$img_id = $this->Image->get_one_by($conds)->img_id;
			   	$image = $this->Image->get_one( $img_id );

			   	$this->ps_adapter->convert_image( $image );
			   	
			   	$this->custom_response( $image );
		   } else {
			   	$this->error_response( get_msg('file_na') );
		   }
			
			   
		} else {
			
			// upload images
			$upload_data = $this->ps_image->upload( $_FILES );

			foreach ( $upload_data as $upload ) {
			   	$shop_img_data = array( 
			   		'img_id' => $img_id,
				   	'img_parent_id'=> $shop_rate_id,
					'img_path' => $upload['file_name'],
					'img_width'=> $upload['image_width'],
					'img_height'=> $upload['image_height']
			   	);
			}
		   	if ( $this->Image->save( $shop_img_data, $img_id ) ) {
			   	
			   	$image = $this->Image->get_one( $img_id );

			   	$this->ps_adapter->convert_image( $image );
			   	
			   	$this->custom_response( $image );
		   	} else {
			   	$this->error_response( get_msg('file_na') );
		   	}
		
		}
	}

	function image_resize_calculation( $path )
	{

		// Start 

		$uploaded_file_path = $path;

		list($width, $height) = getimagesize($uploaded_file_path);
		$uploaded_img_width = $width;
		$uploaded_img_height = $height;

		$org_img_type = "";

		$org_img_landscape_width_config = $this->Backend_config->get_one("be1")->landscape_width; //setting
		$org_img_portrait_height_config = $this->Backend_config->get_one("be1")->potrait_height; //setting
		$org_img_square_width_config   = $this->Backend_config->get_one("be1")->square_height; //setting

		
		$thumb_img_landscape_width_config = $this->Backend_config->get_one("be1")->landscape_thumb_width; //setting
		$thumb_img_portrait_height_config = $this->Backend_config->get_one("be1")->potrait_thumb_height; //setting
		$thumb_img_square_width_config   = $this->Backend_config->get_one("be1")->square_thumb_height; //setting


		// $org_img_landscape_width_config = 1000; //setting
		// $org_img_portrait_height_config = 1000; //setting
		// $org_img_square_width_config   = 1000; //setting

		
		// $thumb_img_landscape_width_config = 200; //setting
		// $thumb_img_portrait_height_config = 200; //setting
		// $thumb_img_square_width_config   = 200; //setting


		$need_resize = 0; //Flag
			
		$org_img_ratio = 0; 
		$thumb_img_ratio = 0;

		if($uploaded_img_width > $uploaded_img_height) {
			$org_img_type = "L";
		} else if ($uploaded_img_width < $uploaded_img_height) {
			$org_img_type = "P";
		} else {
			$org_img_type = "S";
		}


		if( $org_img_type == "L" ) {
			//checking width because of Landscape Image
			if( $org_img_landscape_width_config < $uploaded_img_width ) {

				$need_resize = 1;
				$org_img_ratio = round($org_img_landscape_width_config / $uploaded_img_width,3);
				$thumb_img_ratio = round($thumb_img_landscape_width_config / $uploaded_img_width,3);


			}

		}

		if( $org_img_type == "P" ) {
			//checking width because of portrait Image
			if( $org_img_portrait_height_config < $uploaded_img_height ) {

				$need_resize = 1;
				$org_img_ratio = round($org_img_portrait_height_config / $uploaded_img_height,3);
				$thumb_img_ratio = round($thumb_img_portrait_height_config / $uploaded_img_height,3);
			}
			
		}

		if( $org_img_type == "S" ) {
			//checking width (or) hight because of square Image
			if( $org_img_square_width_config < $uploaded_img_width ) {

				$need_resize = 1;
				$org_img_ratio = round($org_img_square_width_config / $uploaded_img_width,3);
				$thumb_img_ratio = round($thumb_img_square_width_config / $uploaded_img_width,3);

			}
			
		}


		// if( $need_resize == 1 ) {
			//original image need to resize according to config width and height
			
			// resize for original image
			$new_image_path = FCPATH . "uploads/";
			// $org_img_width  = round($uploaded_img_width * $org_img_ratio, 0);
			// $org_img_height = round($uploaded_img_height * $org_img_ratio, 0);
			if( $need_resize == 1 ) {
				$org_img_width  = round($uploaded_img_width * $org_img_ratio, 0);
				$org_img_height = round($uploaded_img_height * $org_img_ratio, 0);
			} else {
				$org_img_width = $org_img_width - 2;
				$org_img_height = $org_img_height - 2;
			}
			
			
			$this->ps_image->create_thumbnail( $uploaded_file_path, $org_img_width, $org_img_height, $new_image_path );
			
			// resize for thumbnail image
			$new_image__thumb_path = FCPATH . "uploads/thumbnail/";
			$thumb_img_width  = round($uploaded_img_width * $thumb_img_ratio, 0);
			$thumb_img_height = round($uploaded_img_height * $thumb_img_ratio, 0);
			
			
			$this->ps_image->create_thumbnail( $uploaded_file_path, $thumb_img_width, $thumb_img_height, $new_image__thumb_path );

			

			//End Modify

		// }


		// End


	}
}