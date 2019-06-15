<?php
namespace mqtchums\view;

use mqtchums\twig\TwigLoader;

class vLogin implements \mqtchums\interfaces\iView
{
    use \mqtchums\traits\Page;

    private $isRestRequest = false;
    private $args = [];

    public function __construct(array $args)
    {



        if(isset($args['rest']))
        {
            $this->isRestRequest = true;
        }
        $this->args = $args;
    }

    public function render()
    {
        if(!$this->isRestRequest) {
            echo $this->loadTwig();
            print_r($_POST);
        }
        else
        {
            print_r($this->args);
        }

    }

    public function loadTwig()
    {
        $TwigLoader = new TwigLoader();

        return $TwigLoader->render('login.twig', []);
    }
}

?>
