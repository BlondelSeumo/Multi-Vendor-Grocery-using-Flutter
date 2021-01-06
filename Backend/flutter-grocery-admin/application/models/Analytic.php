<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Analytic
 */
class Analytic extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psw_touches', 'touch_id', 'tou' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// touch_id condition
		if ( isset( $conds['touch_id'] )) {
			$this->db->where( 'touch_id', $conds['touch_id'] );
		}

		// wallpaper_id condition
		if ( isset( $conds['wallpaper_id'] )) {
			$this->db->where( 'wallpaper_id', $conds['wallpaper_id'] );
		}
	}
}