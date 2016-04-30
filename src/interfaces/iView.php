<?php
namespace mqtchums\interfaces;

interface iView
{
    public function __construct();

    public function render();

    public function loadTwig();

}

?>
