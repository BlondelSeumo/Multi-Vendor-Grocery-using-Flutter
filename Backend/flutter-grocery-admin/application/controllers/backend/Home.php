<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends BE_Controller {

	function __construct()
	{
		parent::__construct( NO_AUTH_CONTROL, 'BACKEND_HOMEPAGE' );
	}

	function index()
	{
		$this->load_template( 'home' );
	}

	function page( $id )
	{
		echo "I am {$id} page from backend";
	}

	function detail( $id, $detail_id )
	{
		echo "I am {$detail_id} from {$id} page from backend";
	}

	function show_flash()
	{
		$this->set_flash_msg( 'success', 'Success!' );
		redirect( $this->site_url('flash'));
	}

	function flash()
	{
		$this->load->view('bs/flash_msg');
	}
}