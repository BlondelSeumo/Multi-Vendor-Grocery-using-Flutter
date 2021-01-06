<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for category table
 */
class Transactionheader extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'rt_transactions_header', 'id', 'trans_hdr_' );
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

		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		if ( isset( $conds['contact_name'] )) {
			$this->db->where( 'contact_name', $conds['contact_name'] );
		}

		if ( isset( $conds['contact_phone'] )) {
			$this->db->where( 'contact_phone', $conds['contact_phone'] );
		}

		// status id condition
		if ( isset( $conds['trans_status_id'] )) {
			
			if ($conds['trans_status_id'] != "") {
				if($conds['trans_status_id'] != '0'){
					$this->db->where( 'trans_status_id', $conds['trans_status_id'] );	
				}

			}			
		}

	
		if ( isset( $conds['searchterm'] ) || isset( $conds['date'] )) {

			$dates = $conds['date'];
			if ($dates != "") {
				$vardate = explode('-',$dates,2);

				$temp_mindate = $vardate[0];
				$temp_maxdate = $vardate[1];		

				$temp_startdate = new DateTime($temp_mindate);
				$mindate = $temp_startdate->format('Y-m-d');

				$temp_enddate = new DateTime($temp_maxdate);
				$maxdate = $temp_enddate->format('Y-m-d');
			} else {
				$mindate = "";
			 	$maxdate = "";
			}
			
			if ($conds['searchterm'] == "" && $mindate != "" && $maxdate != "") {
				//got 2dates
				if ($mindate == $maxdate ) {

					$this->db->where("added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(added_date) >=', $mindate );
   					$this->db->where( 'date(added_date) <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'contact_name', $conds['searchterm'] );
				$this->db->or_like( 'trans_code', $conds['searchterm'] );
				$this->db->group_end();
			} else if ($conds['searchterm'] != "" && $mindate != "" && $maxdate != "") {
				if ($mindate == $maxdate ) {

					$this->db->where("added_date BETWEEN DATE('".$mindate."' - INTERVAL 1 DAY) AND DATE('". $maxdate."' + INTERVAL 1 DAY)");

				} else {

					$today_date = date('Y-m-d');
					if($today_date == $maxdate) {
						$current_time = date('H:i:s');
						$maxdate = $maxdate . " ". $current_time;
					}

					$this->db->where( 'date(added_date) >=', $mindate );
   					$this->db->where( 'date(added_date) <=', $maxdate );

				}
				$this->db->group_start();
				$this->db->like( 'contact_name', $conds['searchterm'] );
				$this->db->or_like( 'trans_code', $conds['searchterm'] );
				$this->db->group_end();
			} else {
				//only name 
				$this->db->group_start();
				$this->db->like( 'contact_name', $conds['searchterm'] );
				$this->db->or_like( 'trans_code', $conds['searchterm'] );
				$this->db->group_end();
				
			}
			 
			 
	    }

		$this->db->order_by( 'added_date', 'desc' );

	}

	
}