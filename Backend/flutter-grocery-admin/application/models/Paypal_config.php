<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for paypal config table
 */
class Paypal_config extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'core_paypal_config', 'id', 'paypal' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// price condition
		if ( isset( $conds['price'] )) {
			$this->db->where( 'price', $conds['price'] );
		}

		// currency_code condition
		if ( isset( $conds['currency_code'] )) {
			$this->db->where( 'currency_code', $conds['currency_code'] );
		}

		// api_username condition
		if ( isset( $conds['api_username'] )) {
			$this->db->where( 'api_username', $conds['api_username'] );
		}

		// api_password condition
		if ( isset( $conds['api_password'] )) {
			$this->db->where( 'api_password', $conds['api_password'] );
		}

		// api_signature condition
		if ( isset( $conds['api_signature'] )) {
			$this->db->where( 'api_signature', $conds['api_signature'] );
		}

		// application_id condition
		if ( isset( $conds['application_id'] )) {
			$this->db->where( 'application_id', $conds['application_id'] );
		}

		// developer_email_account condition
		if ( isset( $conds['developer_email_account'] )) {
			$this->db->where( 'developer_email_account', $conds['developer_email_account'] );
		}

		// sandbox condition
		if ( isset( $conds['sandbox'] )) {
			$this->db->where( 'sandbox', $conds['sandbox'] );
		}

		// api_version condition
		if ( isset( $conds['api_version'] )) {
			$this->db->where( 'api_version', $conds['api_version'] );
		}


	}

	function is_paypal_enable()
	{
		$query = $this->db->get_where( $this->table_name, array( 'status' => 1 ));
		return ( $query->num_rows() > 0 );
	}

	function save(  &$data, $id = false )
	{
		return $this->db->update( $this->table_name, $data );
	}

	function get()
	{
		$query = $this->db->get_where( $this->table_name, array( 'status' => 1 ));
		return $query->row();
	}

	function get_paypal_config()
	{
		$query = $this->db->get_where( $this->table_name );
		return $query->row();
	}

}