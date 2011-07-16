<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Lang extends CI_Lang {

    function __construct() {
        
        parent::__construct();

        global $CFG;
        global $URI;
        global $RTR;

        $CFG->load('i18n');

        $this->languages = $CFG->item('languages');
        $this->special = $CFG->item('special');
        $this->current_lang = "";

        $segment = $URI->segment(1);

        if ( isset($this->languages[$segment]) ) {    // URI with language -> ok

            $language = $this->languages[$segment];
            $CFG->set_item('languages', $language);
            $this->current_lang = $segment;

            log_message('error','Via URL. Using: '. $language);

        } else if ( $this->is_special($segment) ) {

            $CFG->set_item('language', $this->languages[$this->default_lang()]);
            
            $this->current_lang = $this->default_lang();

        } else if( !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) { // Check HTTP_ACCEPT_LANGUAGE for browser info

            $accept_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            foreach ($accept_langs as $lang) {
                $lang = substr($lang, 0, 2);
                if(in_array($lang, array_keys($this->languages))) {
                    $CFG->set_item('languages', $this->languages[$lang]);
                    $this->current_lang = $lang;
                    break;
                }
            }
            log_message('error','Via HTTP_ACCEPT_LANGUAGE. Using: '. $this->languages[$lang]);

        } else { // set default language

            $CFG->set_item('language', $this->languages[$this->default_lang()]);
            $this->current_lang = $this->default_lang();

            log_message('error','Via HTTP_ACCEPT_LANGUAGE. Using: '. $this->languages[$this->default_lang()]);
        }
    }


    // get current language
    // ex: return 'en' if language in CI config is 'english'
    function lang() {

        $language = $this->current_lang;

        if ($language != "") {
            return $language;
        }

        return NULL;    // this should not happen
    }

    // get current language name
    // ex: return 'english' if lang = en
    function lang_long() {

        $language = $this->languages[$this->current_lang];

        if ($language != "") {
            return $language;
        }

        return NULL;    // this should not happen
    }

    function switch_uri($lang) {
        $CI =& get_instance();
        $uri = $CI->uri->uri_string();

        if ($uri != "") {
            $exploded = explode('/', $uri);

            // If we have an URI with a lang --> es/controller/method
            if($exploded[0] == $this->lang())
                $exploded[0] = $lang;

            // If we have an URI without lang --> /controller/method
            // "Default language"
            else if (strlen($exploded[0]) != 2)
                $exploded[0] = $lang . "/" . $exploded[0];

            $uri = implode('/',$exploded);
        } else {
            $uri = $lang;
        }

        return $uri;
    }
    // is there a language segment in this $uri?
    function has_language($uri) {
        log_message('error','Using has_language() with: '.$uri);

        $first_segment = NULL;

        $exploded = explode('/', $uri);
        if(isset($exploded[0])) {
            if($exploded[0] != '') {
                $first_segment = $exploded[0];
            } else if(isset($exploded[1]) && $exploded[1] != '') {
                $first_segment = $exploded[1];
            }
        }

        log_message('error','has_language returns: '.$first_segment);

        if($first_segment != NULL) {
            return isset($this->languages[$first_segment]);
        }

        return FALSE;
    }


    // default language: first element of $this->languages
    function default_lang() {
        foreach ($this->languages as $lang => $language) {
            return $lang;
        }
    }

    // add language segment to $uri (if appropriate)
    function localized($uri) {
        log_message('error','Calling localized()');

        if($this->has_language($uri) || preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri)) {
            log_message('error','localized() already has language');
        } else {
            log_message('error','localized() needs language');
            $uri = $this->lang() . '/' . $uri;
        }

        log_message('error','localized() returns: '.$uri);

        return $uri;
    }

    function is_special($uri) {
        $exploded = explode('/', $uri);

        if ( in_array( $exploded[0], $this->special ) ) {
            return TRUE;
        }

        if ( isset($this->languages[$uri]) ) {
            return TRUE;
        }

        return FALSE;
    }

}  