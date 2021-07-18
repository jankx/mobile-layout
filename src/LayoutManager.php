<?php
namespace Jankx\MobileLayout;

use Jankx\MobileLayout\Frontend\Widgets;

if (!class_exists('LayoutManager')) {
    class LayoutManager
    {
        protected static $instance;

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
            $this->loadHelpers();
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

        public function loadHelpers()
        {
            require_once JANKX_MOBILE_LAYOUT_ROOT . '/helpers/mobile-helpers.php';
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

            // Load Jankx switcher via action hook
            $swicher = new Switcher();
            add_action(
                'after_setup_theme',
                array($swicher, 'switchLayout')
            );
        }
    }
}
