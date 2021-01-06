<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Frontend Controller which extends PS main Controller
 * 1) Loading Template
 */
class FE_Controller extends PS_Controller {
   	
	/**
	 * constructs required variables
	 * 1) template path
	 * 2) base url
	 * 3) site url
	 *
	 * @param      <type>  $auth_level   The auth level
	 * @param      <type>  $module_name  The module name
	 */
	function __construct( $auth_level, $module_name )
	{
		parent::__construct( $auth_level, $module_name );
		
		// template path
		$this->template_path = $this->config->item( 'fe_view_path' );

		// base url & site url
		$fe_url = $this->config->item( 'fe_url' );

		if ( !empty( $fe_url )) {
		// if fe controller path is not empty,
			
			$this->module_url = $fe_url .'/'. $this->module_url;
		}

		// load meta data
		$this->load_metadata();

		// load widget library
		$this->load->library( 'PS_Widget' );
		$this->ps_widget->set_template_path( $this->template_path );
	}

	/**
	 * returns site url for controller
	 *
	 * @param      boolean  $path   The path
	 *
	 * @return     <type>   ( description_of_the_return_value )
	 */
	function module_site_url( $path = false )
	{
		if ( $path ) {
		// if the path is exists,
			
			return site_url( $path );
		}

		return site_url();
	}

	function insert_images_icon_and_cover( $files, $img_type, $img_parent_id, $type )
	{
		
		// return false if the image type is empty
		if ( empty( $img_type )) return false;

		// return false if the parent id is empty
		if ( empty( $img_parent_id )) return false;

		
		if($type == "cover") {
			
			// upload images
			$upload_data = $this->ps_image->upload_cover( $files );
				
			if ( isset( $upload_data['error'] )) {
			// if there is an error in uploading

				// set error message
				$this->data['error'] = $upload_data['error'];
				
				return;
			}
			$image = array(
				'img_parent_id'=> $img_parent_id,
				'img_type' => $img_type,
				'img_desc' => "",
				'img_path' => $upload_data[0]['file_name'],
				'img_width'=> $upload_data[0]['image_width'],
				'img_height'=> $upload_data[0]['image_height']
			);
			
			if ( ! $this->Image->save( $image )) {
			// if error in saving image
				
				// set error message
				$this->data['error'] = get_msg( 'err_model' );
				
				return false;
			}
		} else if($type == "icon") {

			// upload images
			$upload_data = $this->ps_image->upload_icon( $files );
				
			if ( isset( $upload_data['error'] )) {
			// if there is an error in uploading

				// set error message
				$this->data['error'] = $upload_data['error'];
				
				return;
			}
			$image = array(
				'img_parent_id'=> $img_parent_id,
				'img_type' => $img_type,
				'img_desc' => "",
				'img_path' => $upload_data[0]['file_name'],
				'img_width'=> $upload_data[0]['image_width'],
				'img_height'=> $upload_data[0]['image_height']
			);

			
			if ( ! $this->Image->save( $image )) {
			// if error in saving image
				
				// set error message
				$this->data['error'] = get_msg( 'err_model' );
				
				return false;
			}

		}
		
		return true;
	}
}