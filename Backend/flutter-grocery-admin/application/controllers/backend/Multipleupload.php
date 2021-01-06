<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Multipleupload extends BE_Controller {
		/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'Multiple Upload' );
		$this->load->library('uploader');
		$this->load->library('csvimport');
		///start allow module check by MN
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];
		
		$conds_mod['module_name'] = $this->router->fetch_class();
		$module_id = $this->Module->get_one_by($conds_mod)->module_id;
		
		$logged_in_user = $this->ps_auth->get_user_info();

		$user_id = $logged_in_user->user_id;
		if(empty($this->User->has_permission( $module_id,$user_id )) && $logged_in_user->user_is_sys_admin!=1){
			return redirect( site_url('/admin/'.$shop_id) );
		}
		///end check
	}

	/**
	 * Load Api Key Entry Form
	 */

	function index( ) {
		$selected_shop_id = $this->session->userdata('selected_shop_id');
		$shop_id = $selected_shop_id['shop_id'];
		$this->data['selected_shop_id'] = $shop_id;
		$this->load_form($this->data);

	}

	

	function upload($id = false) {
		
		if ( $this->is_POST()) {

			// If file upload form submitted
	        if(!empty($_FILES['images']['name'])){
	            
	        	//Start Prepare Data

	        	// color count
				if($id) {
					$color_counter_total = $this->get_data( 'color_total_existing' );
					$edit_prd_id = $id;
				} else {
					$color_counter_total = $this->get_data( 'color_total' );
				}

				// specification count
				if($id) {
					$spec_counter_total = $this->get_data( 'spec_total_existing' );
					$edit_spec_id = $id;
				} else {
					$spec_counter_total = $this->get_data( 'spec_total' );
				}
				
				$logged_in_user = $this->ps_auth->get_user_info();
				
				/** 
				 * Insert Product Records 
				 */
				$data = array();
				$selected_shop_id = $this->session->userdata('selected_shop_id');

				// Product id
			   if ( $this->has_data( 'id' )) {
					$data['id'] = $this->get_data( 'id' );

				}

			   // Category id
			   if ( $this->has_data( 'cat_id' )) {
					$data['cat_id'] = $this->get_data( 'cat_id' );
				}

				// Sub Category id
			   if ( $this->has_data( 'sub_cat_id' )) {
					$data['sub_cat_id'] = $this->get_data( 'sub_cat_id' );
				}

				// Sub Category id
			   	if ( $this->has_data( 'discount_type_id' )) {
					$data['discount_type_id'] = $this->get_data( 'discount_type_id' );
				}

				// prepare product name
				if ( $this->has_data( 'name' )) {
					$data['name'] = $this->get_data( 'name' );
				}

				// prepare product description
				if ( $this->has_data( 'description' )) {
					$data['description'] = $this->get_data( 'description' );
				}
				
				// prepare product unit price
				if ( $this->has_data( 'unit_price' )) {
					$data['unit_price'] = $this->get_data( 'unit_price' );
				}

				// prepare product original price
				if ( $this->has_data( 'unit_price' )) {
					$data['original_price'] = $this->get_data( 'unit_price' );
				}

				// prepare product search tag
				if ( $this->has_data( 'search_tag' )) {
					$data['search_tag'] = $this->get_data( 'search_tag' );
				}

				// prepare product highlight information
				if ( $this->has_data( 'highlight_information' )) {
					$data['highlight_information'] = $this->get_data( 'highlight_information' );
				}

				// prepare product product code
				if ( $this->has_data( 'code' )) {
					$data['code'] = $this->get_data( 'code' );
				}

				
				// if 'is featured' is checked,
				if ( $this->has_data( 'is_featured' )) {
					
					$data['is_featured'] = 1;
					if ($data['is_featured'] == 1) {

						if($this->get_data( 'is_featured_stage' ) == $this->has_data( 'is_featured' )) {
							$data['updated_date'] = date("Y-m-d H:i:s");
						} else {
							$data['featured_date'] = date("Y-m-d H:i:s");
							
						}
					}
				} else {
					
					$data['is_featured'] = 0;
				}

				// if 'is available' is checked,
				if ( $this->has_data( 'is_available' )) {
					$data['is_available'] = 1;
				} else {
					$data['is_available'] = 0;
				}

				// if 'status' is checked,
				if ( $this->has_data( 'status' )) {
					$data['status'] = 1;
				} else {
					$data['status'] = 0;
				}
			
				
				// set timezone
				$data['shop_id'] = $selected_shop_id['shop_id'];
				$data['added_user_id'] = $logged_in_user->user_id;

				if($id == "") {
					//save
					$data['added_date'] = date("Y-m-d H:i:s");
				} else {
					//edit
					unset($data['added_date']);
					$data['updated_date'] = date("Y-m-d H:i:s");
					$data['updated_user_id'] = $logged_in_user->user_id;
				}
            	
            	//End Prepare Data


	            $filesCount = count($_FILES['images']['name']);
	            
	           	$counter = $this->get_data( 'counter' );
	       
	           	$prd_name = $data['name'];

	            for($i = 0; $i < $filesCount; $i++){
	            	
	            	// start the transaction
					$this->db->trans_start();

					

					$data['name'] = $prd_name . " " . $counter;
					$counter++;


	            	// save product
					if ( ! $this->Product->save( $data, $id )) {
					// if there is an error in inserting user data,	
						// rollback the transaction
						$this->db->trans_rollback();

						// set error message
						$this->data['error'] = get_msg( 'err_model' );
						
						return;
					}

					if ( $data['id'] != "" ) {

						$_FILES['file']['name']     = $_FILES['images']['name'][$i];
		                $_FILES['file']['type']     = $_FILES['images']['type'][$i];
		                $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
		                $_FILES['file']['error']    = $_FILES['images']['error'][$i];
		                $_FILES['file']['size']     = $_FILES['images']['size'][$i];
		                
		                // File upload configuration
		                $config['upload_path'] = $this->config->item('upload_path');
		                $config['allowed_types'] = $this->config->item('image_type');
		                
		                // Load and initialize upload library
		                $this->load->library('upload', $config);
		                $this->upload->initialize($config);
		                
		                // Upload file to server
		                if($this->upload->do_upload('file')){
		                    // Uploaded file data
		                    $uploaded_data = $this->upload->data();

		                    $image_path = $uploaded_data['full_path'];

							$thumb_width  =   round($uploaded_data['image_width'] * 0.25, 0);
							$thumb_height =   round($uploaded_data['image_height'] * 0.25, 0);

							// create thumbnail
							$this->image_lib->clear();

							$config = array(
								'source_image' => $image_path, //$image_data['full_path'],
								'new_image'    => $this->config->item('upload_thumbnail_path'),
								'maintain_ration' => true,
								'width' => $thumb_width,
								'height' => $thumb_height
							);

							$this->image_lib->initialize($config);
							$this->image_lib->resize();


							 // prepare image data
							$image = array(
								'img_parent_id'	=> $data['id'],
								'img_type' 		=> "product",
								'img_desc' 		=> "",
								'img_path' 		=> $uploaded_data['file_name'],
								'img_width'		=> $uploaded_data['image_width'],
								'img_height'	=> $uploaded_data['image_height']
							);
							// print_r($image);die;

							// save image 
							if ( ! $this->Image->save( $image )) {
							// if error in saving image
								// set error message
								$this->data['error'] = get_msg( 'err_model' );
								
								return false;
							}
							// echo "1";die;
							
		                }
		                //if id is false, this is adding new record
						if($color_counter_total == false) { 
							// edit color
							$color_value = $this->get_data( 'colorvalue1' );
							if($color_value != "") {
								$color_data['product_id'] = $data['id'];
								$color_data['color_value'] = $color_value;
								$color_data['added_date'] = date("Y-m-d H:i:s");
								$color_data['added_user_id'] = $logged_in_user->user_id;
								
								$this->Color->save($color_data);
							}

						} else { 
							// save color
							for($p=1; $p<=$color_counter_total; $p++) {

								 $color_value = $this->get_data( 'colorvalue' . $p );
								
								if($color_value != "") {

									$color_data['product_id'] = $data['id'];
									$color_data['color_value'] = $color_value;
									$color_data['added_date'] = date("Y-m-d H:i:s");
									$color_data['added_user_id'] = $logged_in_user->user_id;
									$this->Color->save($color_data);
								}

							}
						}

						// prepare specification 
						if($spec_counter_total == false) {
						
							$spec_title = $this->get_data('prd_spec_title1');
							$spec_desc = $this->get_data('prd_spec_desc1');
								if($spec_title != "" || $spec_desc != "") {
									$spec_data['product_id'] = $data['id'];
									$spec_data['name'] = $spec_title;
									$spec_data['description'] = $spec_desc;
									$spec_data['added_date'] = date("Y-m-d H:i:s");
									$spec_data['added_user_id'] = $logged_in_user->user_id;

									$this->Specification->save($spec_data);
								}
						} else {
							
							for($j=1; $j<=$spec_counter_total; $j++) {
								$spec_title = $this->get_data('prd_spec_title' . $j);
								$spec_desc = $this->get_data('prd_spec_desc' . $j);
								if( $spec_title != "" || $spec_desc != "" ) {
									$spec_data['product_id'] = $data['id'];
									$spec_data['name'] = $spec_title;
									$spec_data['description'] = $spec_desc;
									$spec_data['added_date'] = date("Y-m-d H:i:s");
									$spec_data['added_user_id'] = $logged_in_user->user_id;

									$this->Specification->save($spec_data);
								}
							}
						}

					}


					//End - Images Upload 

					/** 
					 * Check Transactions 
					 */

					// commit the transaction
					if ( ! $this->check_trans()) {
						// set flash error message
						$this->set_flash_msg( 'error', get_msg( 'err_model' ));
					} else {
						if ( $id ) {
						// if user id is not false, show success_add message
							$this->set_flash_msg( 'success', get_msg( 'success_prd_edit' ));
						} else {
						// if user id is false, show success_edit message
							$this->set_flash_msg( 'success', get_msg( 'success_prd_add' ));
						}
					}


	            }
	            
	            redirect( site_url('/admin/products/'));

	        }
	        // end if $_FILES


		} else {
			//echo "66666";
			$selected_shop_id = $this->session->userdata('selected_shop_id');
			$shop_id = $selected_shop_id['shop_id'];
			$this->data['selected_shop_id'] = $shop_id;
			$this->load_form($this->data);
		}
		

	}

}