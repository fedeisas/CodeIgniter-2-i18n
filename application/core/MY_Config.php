<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Codeigniter 2 Internationalization (i18n) Library MY_Config
*/

class MY_Config extends CI_Config {

    function __construct()
    {
        parent::__construct();
    }

    function site_url($uri = '')
    {
        if (is_array($uri))
        {
            $uri = implode('/', $uri);
        }

        if (class_exists('CI_Controller'))
        {
            $uri = get_instance()->lang->localized($uri);
        }

        return parent::site_url($uri);
    }

}
