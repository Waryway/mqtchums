<?php
namespace mqtchums\interfaces;
interface iView
{
    public function __construct();

    public function Render();

    public function LoadTwig();

}
?>