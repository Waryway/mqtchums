<?php
namespace mqtchums\interfaces;

interface iView
{
    public function __construct(array $args);

    public function render();

    public function loadTwig();

}

?>
