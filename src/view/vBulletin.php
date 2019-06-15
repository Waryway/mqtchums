<?php
namespace mqtchums\view;

use mqtchums\twig\TwigLoader;

class vBulletin implements \mqtchums\interfaces\iView
{
    use \mqtchums\traits\Page;

    public function render()
    {   
        echo $this->loadTwig();
    }

    public function loadTwig()
    {
        $TwigLoader = new TwigLoader();
       
        return $TwigLoader->render('bulletin.twig', []);
    }
}

?>
