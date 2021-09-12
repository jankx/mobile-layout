<?php
namespace Jankx\MobileLayout;

use Jankx\MobileLayout\Detector\GetRequestDetector;
use Jankx\MobileLayout\Detector\CookieDetector;
use Jankx\MobileLayout\Interfaces\DetectorInterface;
use Jankx\MobileLayout\DebugMode;

class Detector
{
    private static $instance;

    protected $isMobile;
    protected $detectors;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        if (did_action('init')) {
            $this->loadDetectors();
        } else {
            add_filter('init', array($this, 'loadDetectors'));
        }
    }

    public function loadDetectors()
    {
        $classes = apply_filters('jankx/layout/mobile/detectors/classes', array(
            'cookie' => CookieDetector::class,
            'get_request' => GetRequestDetector::class,
        ));
        $detectors = array();
        foreach ($classes as $detector_cls) {
            if (!class_exists($detector_cls)) {
                continue;
            }
            $detector = new $detector_cls();
            if (is_a($detector, DetectorInterface::class)) {
                array_push($detectors, $detector);
            }
        }

        usort($detectors, function ($a, $b) {
            return $a->getPriority() - $b->getPriority();
        });

        return $this->detectors = apply_filters(
            'jankx/layout/mobile/detectors',
            $detectors,
            $classes
        );
    }

    public function isMobile()
    {
        return boolval($this->isMobile);
    }

    public function getStatus()
    {
        foreach ($this->detectors as $detector) {
            if (($device = $detector->detect())) {
                return $device;
            }
        }
        return false;
    }

    public function run()
    {
        if (empty($this->detectors)) {
            return;
        }

        switch($this->isMobile = $this->getStatus()) {
            case 'm':
                add_filter('jankx/device/is_mobile/pre', '__return_true');
                add_filter('jankx/device/is_mobile/template', '__return_true');
                break;
        }

        $debug = new DebugMode();
        if ($this->isMobile && $debug->isDebug()) {
            add_filter('template_include', array($debug, 'includeDebugTemplate'), 555);
        }
    }
}
