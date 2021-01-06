<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for category table
 */
class ProductDiscount extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_products_discount', 'id', 'prd_dis' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// color 
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// product 
		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id'] );
		}

		// discount
		if ( isset( $conds['discount_id'] )) {
			$this->db->where( 'discount_id', $conds['discount_id'] );
		}

		if ( isset( $conds['shop_id'] )) {
			$this->db->where( 'shop_id', $conds['shop_id'] );
		}



	}


	 public function get_discounts( $conds = array() )
     {
     	$this->db->where( 'shop_id', $conds['shop_id']);

     	$this->db->order_by('is_discount',DESC);
        return $this->db->get("rt_products");
     }
	 
}