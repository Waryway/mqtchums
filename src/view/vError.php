<?php
namespace mqtchums\view;

use mqtchums\twig\TwigLoader;

class vError implements \mqtchums\interfaces\iView
{
    public function __construct(array $args)
    {

    }

    public function render()
    {
        echo $this->loadTwig();
    }

    public function loadTwig()
    {
        $TwigLoader = new TwigLoader();

        return $TwigLoader->render('error.twig', array('the' => 'variables', 'go' => 'here'));

    }
}

?>
