<?php

namespace mqtchums\traits;

use mqtchums\Configuration;

trait Page
{
    /**
     * @var \mqtchums\singleton\Session
     */
    private $Session;

    public function __construct()
    {
        /** @var $this ->Session \mqtchums\singleton\Session */
        $this->Session = \mqtchums\singleton\Session::inst();
        $this->Session->Start();

        if (!file_exists(Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'jquery.min.js')) {
            copy(Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'jquery' . DIRECTORY_SEPARATOR . 'jquery.min.js',
                Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'jquery.min.js');
        }
        if (!file_exists(Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.min.css')) {
            copy(Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'twbs' . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'bootstrap.min.css',
                Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.min.css');
        }
        if (!file_exists(Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.min.js')) {
            copy(Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'twbs' . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'bootstrap.min.js',
                Configuration::websiteRoot() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.min.js');
        }
    }

}

?>
