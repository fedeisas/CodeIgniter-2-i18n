<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {

        parent::__construct();

        // Set the current language on runtime
        $this->config->set_item('language',$this->lang->lang_long());
        
    }
}