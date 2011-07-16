# CodeIgniter 2 Internationalization (i18n) Library

Originally by [Jérôme Jaglale](http://maestric.com/doc/php/codeigniter_i18n).
Also based on [cimet](http://codeigniter.com/forums/member/76624/) ideas.

## Installation and configuration

Just copy the files to your /application folder. Set available languages on /application/config/i18n.php

## Usage

Each method is documented.

Get the current language:
    $this->lang->lang();

Switch to another language:
    anchor($this->lang->switch_uri('es'),'Display current page in Spanish');


## Auto guessing language

When there's no language set on the URL, we'll try to autoguess user's language.
On each request, the browser send info on their language preferences. The library checks that info ($_SERVER['HTTP_ACCEPT_LANGUAGE']) and tries to guess which language to use.