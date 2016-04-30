<?php
namespace mqtchums;

// definitions must be placed in the src directory, not a subdirectory.
class Configuration
{
    public static $HTTP_COOKIE_DOMAIN = 'mqtchums.com';
    public static $HTTPS_COOKIE_DOMAIN = 'mqtchums.com';
    public static $HTTP_COOKIE_PATH = '/';
    public static $HTTPS_COOKIE_PATH = '/';

    /**
     * @return string, hard path to the website root.
     */
    public static function websiteRoot()
    {
        // lazy load the constant
        if (!defined('WEBSITE_ROOT')) {
            $cwd = getcwd();
            chdir(__DIR__);
            chdir('..' . DIRECTORY_SEPARATOR);
            /* Do not reference WEBSITE_ROOT directly. Call /mqtchums/Configuration::WebsiteRoot(); */
            define('WEBSITE_ROOT', getcwd());
            chdir($cwd);

        }

        return WEBSITE_ROOT;
    }

    public static function javascriptDirectory()
    {
        return self::websiteRoot() . DIRECTORY_SEPARATOR . 'javascript';
    }

    public static function cssDirectory()
    {
        return self::websiteRoot() . DIRECTORY_SEPARATOR . 'css';
    }


}

?>
