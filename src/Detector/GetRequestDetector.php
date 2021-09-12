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

        if (in_array($_GET['view'], array('m', 'd', 't'))) {
            return $_GET['view'];
        }

        return 'd';
    }
}
