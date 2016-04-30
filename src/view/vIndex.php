<?php
namespace mqtchums\view;

use mqtchums\twig\TwigLoader;

class vIndex implements \mqtchums\interfaces\iView
{
    use \mqtchums\traits\Page;

    public function Render()
    {
        echo $this->LoadTwig();
    }

    public function LoadTwig()
    {
        $TwigLoader = new TwigLoader();

        return $TwigLoader->render('index.twig', array('the' => 'variables', 'go' => 'here'));
    }
}

?>
