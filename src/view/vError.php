<?php
namespace mqtchums\view;

use mqtchums\twig\TwigLoader;

class vError implements \mqtchums\interfaces\iView
{
    public function __construct()
    {

    }

    public function Render()
    {
        echo $this->LoadTwig();
    }

    public function LoadTwig()
    {
        $TwigLoader = new TwigLoader();

        return $TwigLoader->render('error.twig', array('the' => 'variables', 'go' => 'here'));

    }
}
?>