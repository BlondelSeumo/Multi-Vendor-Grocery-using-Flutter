<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for product delete table
 */
class Delete_history extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_delete_history', 'id', 'del_his_' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		

		// product_id condition
		if ( isset( $conds['type_id'] )) {
			$this->db->where( 'type_id', $conds['type_id'] );
		}

		// product_id condition
		if ( isset( $conds['type_name'] )) {
			$this->db->where( 'type_name', $conds['type_name'] );
		}

		//Date Range
		if ( isset( $conds['start_date'] ) && isset( $conds['end_date'] )) {
			$this->db->where( 'deleted_date >=', $conds['start_date'] );
			$this->db->where( 'deleted_date <=', $conds['end_date'] );
		}

		// order by
		if ( isset( $conds['order_by'] )) {

			$order_by_field = $conds['order_by_field'];
			$order_by_type = $conds['order_by_type'];
			
			$this->db->order_by( $order_by_field, $order_by_type);
		}


	}
}