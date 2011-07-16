<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Router_Hook
{

    /*
    | Set custom routing based on your i18n configuration
    */
    
    function get_routes()
    {
        global $I18N_ROUTES;

        // I can't access config because Classes are not loaded yet. I have to require the config file.
        // It's not pretty, but works.
        require_once(APPPATH."config/i18n.php");

        $this->languages = $config['languages'];

        foreach ($this->languages as $key => $language) {
            $routes["^".$key."/(.+)$"] = "$1";
            $routes["^".$key."$"] = &$route['default_controller'];
        }

        $I18N_ROUTES = $routes;
    }
}

/* End of file Router_Hook.php */
/* Location: ./application/hooks/Router_Hook.php */