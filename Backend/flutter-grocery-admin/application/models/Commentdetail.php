<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for touch table
 */
class Commentdetail extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_comments_detail', 'id', 'cmt_det' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// comment_header_id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		// header_id condition
		if ( isset( $conds['header_id'] )) {
			$this->db->where( 'header_id', $conds['header_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		$this->db->order_by('added_date', 'desc' );

	}
}