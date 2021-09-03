<?php
namespace Jankx\MobileLayout;

use Jankx\MobileLayout\Frontend\Widgets;
use Jankx\MobileLayout\Detector;
use Jankx\MobileLayout\Frontend\Frontend;

if (!class_exists('LayoutManager')) {
    class LayoutManager
    {
        protected static $instance;

        protected $detector;
        protected $frontend;

        public static function instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct()
        {
            $this->defineConstants();
            $this->initFeatures();
        }

        private function define($name, $value)
        {
            if (defined($name)) {
                return;
            }
            define($name, $value);
        }

        public function defineConstants()
        {
            $this->define(
                'JANKX_MOBILE_LAYOUT_ROOT',
                dirname(__DIR__)
            );
        }

        public function initFeatures()
        {
            if (wp_is_request('admin')) {
                new Admin();
            }

            $widgets = new Widgets();
            add_action(
                'after_setup_theme',
                array($widgets, 'loadMobileWidgets')
            );

            // Detect the page is show mobile templates or is mobile template
            $this->detector = Detector::getInstance();
            add_action(
                'wp',
                array($this->detector, 'run')
            );

            add_action('wp', array($this, 'loadMobileFrontend'), 15);
        }

        public function loadMobileFrontend()
        {
            if ($this->detector->isMobile()) {
                $this->frontend = Frontend::getInstance();
                add_action('template_redirect', array($this->frontend, 'init'));
            }
        }
    }
}
