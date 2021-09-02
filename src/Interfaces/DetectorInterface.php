<?php
namespace Jankx\MobileLayout\Interfaces;

interface DetectorInterface
{
    public function getPriority();

    public function detect();
}
