<?php
namespace Jankx\MobileLayout\Detector;

use Jankx\MobileLayout\Abstracts\Detector;

class GetRequestDetector extends Detector
{
    public function detect()
    {
        if (!isset($_GET['view'])) {
            return false;
        }
        return $_GET['view'] === 'm';
    }
}
