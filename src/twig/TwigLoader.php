<?php
namespace mqtchums\twig;

class TwigLoader extends \Twig_Environment
{
    public function __construct()
    {
        if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'cache'))
        {
            mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'cache');
        }

        $loader = new \Twig_Loader_Filesystem(__DIR__);
        parent::__construct($loader, [
            'cache' => __DIR__ . DIRECTORY_SEPARATOR . 'cache'
        ]);
    }
}
?>