<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Authentication
 */
class PS_Widget {

	// codeigniter instance
	protected $CI;

	// template path
	protected $template_path;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();

		// load authetication library
		$this->CI->load->library( "PS_Auth" );
		$this->CI->load->library( "PS_Dummy" );
	}