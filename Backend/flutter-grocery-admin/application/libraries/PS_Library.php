<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Helper Library
 * 1) pagination
 * 2) search term handler
 */
class PS_Library {

	// codeigniter instance
	protected $CI;

	/**
	 * constructs required libraries
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();
	}
}