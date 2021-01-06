<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fileupload extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function upload()
    {
     	$this->load->library("UploadHandler");
    }
}
?>