<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for category table
 */
class Image extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'core_images', 'img_id', 'img' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// img_id condition
		if ( isset( $conds['img_id'] )) {
			$this->db->where( 'img_id', $conds['img_id'] );
		}
	
		// img_type condition
		if ( isset( $conds['img_type'] )) {
			$this->db->where( 'img_type', $conds['img_type'] );
		}

		// img_parent_id condition
		if ( isset( $conds['img_parent_id'] )) {
			$this->db->where( 'img_parent_id', $conds['img_parent_id'] );
		}

		// img_path condition
		if ( isset( $conds['img_path'] )) {
			$this->db->where( 'img_path', $conds['img_path'] );
		}

		// is_default condition
		if ( isset( $conds['is_default'] )) {
			$this->db->where( 'is_default', $conds['is_default'] );
		}

		$this->db->order_by( 'added_date', 'desc' );
	}
}