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
        }
    }
}
