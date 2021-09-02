<?php
namespace Jankx\MobileLayout\Abstracts;

use Jankx\MobileLayout\Interfaces\DetectorInterface;

abstract class Detector implements DetectorInterface
{
    public function getPriority()
    {
        return 10;
    }
}
