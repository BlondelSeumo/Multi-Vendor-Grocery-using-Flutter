<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Transactiondetail table
 */
class Transactiondetail extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_transactions_detail', 'id', 'trans_det_' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// default where clause
		
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// shop_id condition
		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}

		if ( isset( $conds['transactions_header_id'] )) {
			$this->db->where( 'transactions_header_id', $conds['transactions_header_id'] );
		}

		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id'] );
		}

		// added_user_id condition
		if ( isset( $conds['added_user_id'] )) {
			$this->db->where( 'added_user_id', $conds['added_user_id'] );
		}
		
		$this->db->order_by( 'added_date', 'desc' );

	}

	
} 