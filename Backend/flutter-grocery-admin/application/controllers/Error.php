<?php

class Error extends Controller {

   function error_404()

   {

       $this->output->set_status_header('404');

       echo "404 - not found";

   }

}