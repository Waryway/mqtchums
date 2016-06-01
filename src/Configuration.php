<?php
namespace mqtchums;

$iniConfiguration = \parse_ini_file(__DIR__.DIRECTORY_SEPARATOR.'protected.ini');
foreach($iniConfiguration as $arg => $value)
{
    if(!defined($arg)) {define($arg, $value);}
}


// definitions must be placed in the src directory, not a subdirectory.
class Configuration
{

    public static $DB_SERVER = DB_SERVER;
    public static $DB_DATABASE = DB_DATABASE;
    public static $DB_SERVER_USERNAME = DB_SERVER_USERNAME;
    public static $DB_SERVER_PASSWORD = DB_SERVER_PASSWORD;
    
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
