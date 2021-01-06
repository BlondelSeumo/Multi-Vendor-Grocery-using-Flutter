<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for product table
 */
class Popularproduct extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_products', 'id', 'popularprd' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// default where clause
		if ( !isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'status', 1 );
		}
		
		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}

		// shop id condition
		if ( isset( $conds['shop_id'] )) {
				
				$this->db->where( 'shop_id', $conds['shop_id'] );	

		}

		// category id condition
		if ( isset( $conds['cat_id'] )) {
			if ($conds['cat_id'] != "" ) {
				if ($conds['cat_id'] != 0) {
					$this->db->where( 'cat_id', $conds['cat_id'] );	
				}
				
			}
		}

		//  sub category id condition 
		if ( isset( $conds['sub_cat_id'] )) {
			if ($conds['sub_cat_id'] != "" ) {
				if ($conds['sub_cat_id'] != 0) {
					$this->db->where( 'sub_cat_id', $conds['sub_cat_id'] );
				}
				
			}
			
		}


		// product_name condition
		if ( isset( $conds['prdname'] )) {
			$this->db->where( 'name', $conds['prdname'] );
		}

		
		// product description condition
		if ( isset( $conds['desc'] )) {
			$this->db->where( 'description', $conds['desc'] );
		}

		

		// product keywords
		if ( isset( $conds['key_tag'] )) {
			$this->db->where( 'keywords_tag', $conds['key_tag'] );
		}

		

		// product highlight information condition
		if ( isset( $conds['high_info'] )) {
			$this->db->where( 'highlight_information', $conds['high_infor'] );
		}

		
		// product code
		if ( isset( $conds['code'] )){
			$this->db->where( 'code', $conds['code'] );
		}

		// product price
		if ( isset( $conds['price'] )) {
			$this->db->where( 'price', $conds['price'] );
		}

		// feature products
		if ( $this->is_filter_feature( $conds )) {
			$this->db->where( 'is_featured', '1' );	
		}
		
		// discount products
		if ( $this->is_filter_discount( $conds )) {
			$this->db->where( 'is_discount', '1' );	
		}

		// search_term
		if ( isset( $conds['search_term'] )) {

				$this->db->like( 'name', $conds['searchterm'] );
		}

		
		$this->db->order_by( 'added_date', 'desc' );
	}

	/**
	 * Determines if filter feature.
	 *
	 * @return     boolean  True if filter feature, False otherwise.
	 */
	function is_filter_feature( $conds )
	{
		return ( isset( $conds['feature'] ) && $conds['feature'] == 1 );
	}

	/**
	 * Determines if filter discount.
	 *
	 * @return     boolean  True if filter discount, False otherwise.
	 */
	function is_filter_discount( $conds )
	{
		return ( isset( $conds['discount'] ) && $conds['discount'] == 1 );
	}

}