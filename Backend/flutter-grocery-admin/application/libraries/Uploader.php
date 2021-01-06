<?php
/**
 * Uploader class for image uploading
 */
class Uploader
{
	protected $CI;

	/**
	 * Initialize Upload Config and load the Upload Library
	 */
	function __construct()
	{
		//Create CI instance to load library and helper
		$this->CI =& get_instance();
					
		// image upload configuration
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = $this->CI->config->item('image_type');
		$config['overwrite'] = FALSE;
		
		// initialize config and load library
		$this->CI->load->helper('file');
		$this->CI->load->library('upload');
		$this->CI->load->library('image_lib');
		$this->CI->upload->initialize($config);
	}
	
	/**
	 * Upload image and resize the required dimension
	 *
	 * @param      <type>          $files   The files
	 * @param      integer|string  $userId  The user identifier
	 * @param      string          $type    The type
	 *
	 * @return     array           ( description_of_the_return_value )
	 */
	function upload( $files )
	{
		// empty array to return processed data
		$data = array();

		if ( empty( $files )) {
		// if there is no file, show error
			
			$data['error'] = "Choose file to upload";
			return $data;
		}
		
		// loop if the files array
		foreach ( $files as $field => $file ) {

			// assign the file name
			$_FILES[$field]['name'] = $_FILES[$field]['name'];
				
			if ( $file['error'] == 0 ) {    
			// if there is no error in file,		
					
				if ( $this->CI->upload->do_upload( $field )) {
				// if file uploading is success

					// get uploaded data
					$uploaded_data = $this->CI->upload->data();
					
					// keep uploaded data in return object
					$data[] = $uploaded_data;

					// create thumbnail
					$image_path = $uploaded_data['full_path'];
					$this->create_thumbnail( $image_path );

				} else {
				// if file uploading is fail,	
					
					// return error
					$data['error'] = $this->CI->upload->display_errors();
				}
			}
		}

		if ( empty( $data )) {
			$data['error'] = "No file is uploaded";
		}
			
		return $data;
	}

	/**
	 * Creats a thumbnail by passed width and height
	 *
	 * @param      <type>   $image_data  The image data
	 * @param      integer  $width       The width
	 * @param      integer  $height      The height
	 */
	function create_thumbnail( $image_path, $width = 150, $height = 100 )
	{
		// create thumbnail
		$this->CI->image_lib->clear();

		$config = array(
			'source_image' => $image_path, //$image_data['full_path'],
			'new_image' => './uploads/thumbnail',
			'maintain_ration' => true,
			'width' => $width,
			'height' => $height
		);

		$this->CI->image_lib->initialize($config);
		$this->CI->image_lib->resize();
	}
}
?>