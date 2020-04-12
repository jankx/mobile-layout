<?php
namespace Jankx\Mobile\Layout;

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
            $this->define('JANKX_MOBILE_LAYOUT_ROOT', dirname(JANKX_MOBILE_TEMPLATE_LOADER));
        }

        public function loadHelpers()
        {
            require_once JANKX_MOBILE_LAYOUT_ROOT . '/helpers/mobile-helpers.php';
        }
    }
}
