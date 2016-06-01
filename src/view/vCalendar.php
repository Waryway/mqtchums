<?php
namespace mqtchums\view;

use mqtchums\twig\TwigLoader;

class vCalendar implements \mqtchums\interfaces\iView
{
    use \mqtchums\traits\Page;

    public function render()
    {

        echo $this->loadTwig();
    }

    public function loadTwig()
    {
        $TwigLoader = new TwigLoader();


        return $TwigLoader->render('calendar.twig', ['none'=> 'none']);
    }
}

?>
