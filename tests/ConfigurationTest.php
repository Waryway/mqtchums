<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 4/2/2016
 * Time: 11:51 AMPHPUnit_Framework_TestCase
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{

    public function testWebsiteRoot()
    {
        $root = \mqtchums\Configuration::websiteRoot();
        $this->assertEquals(WEBSITE_ROOT, $root, 'The constant must match the definition');
    }

    public function testJavascriptDirectory()
    {
        $javascriptDirectory = \mqtchums\Configuration::javascriptDirectory();
        $this->assertEquals(WEBSITE_ROOT . DIRECTORY_SEPARATOR . 'javascript', $javascriptDirectory, 'If we ever change the javascript directory, we need to know...');
    }

    public function testCssDirectory()
    {
        $javascriptDirectory = \mqtchums\Configuration::cssDirectory();
        $this->assertEquals(WEBSITE_ROOT . DIRECTORY_SEPARATOR . 'css', $javascriptDirectory, 'If we ever change the css directory, we need to know...');
    }

//        $reflection = new \ReflectionObject($Index);
//        $method = $reflection->getMethod('RenderBodyContent');
//        $method->setAccessible(true);
//
//        $result = $method->invokeArgs($Index, []);
//        $this->assertEquals('Welcome to MQTCHUMS.org!', $result,
//            'Expecting a static string response, it should match a static string.');
//
//
//        $output = $this->getActualOutput();
//        $this->assertContains('Welcome to MQTCHUMS.org!', $output,
//            'expecting the static string to make it to the screen!');
//        $this->assertContains('<title>MQTCHUMS</title>', $output, 'Validating the title of the website');

}
