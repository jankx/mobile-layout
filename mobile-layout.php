<?php
/**
 * Plugin Name: Jankx Mobile Layout
 * Plugin URI: https://puleeno.com
 * Author: Puleeno Nguyen
 * Author URI: https://puleeno.com
 * Version: 1.0.0
 * Description: Create mobile
 */

use Jankx\Mobile\Layout\LayoutManager;

define('JANKX_MOBILE_TEMPLATE_LOADER', __FILE__);

if (! class_exists(LayoutManager::class)) {
    $composer = sprintf('%s/vendor/autoload.php');
    if (! file_exists($composer)) {
        return;
    }
    require_once $composer;
}
if (! function_exists('jankx_mobile_layout')) {
    function jankx_mobile_layout()
    {
        return LayoutManager::instance();
    }
}

$GLOBALS['jankx_mobile'] = jankx_mobile_layout();
