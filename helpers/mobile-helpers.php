<?php
function jankx_debug_mobile_template_enabled($is_mobile)
{
    if (!defined('JANKX_DEBUG_MOBILE_LAYOUT')) {
        return $is_mobile;
    }

    return (boolean) JANKX_DEBUG_MOBILE_LAYOUT;
}
add_filter('jankx_is_mobile_template', 'jankx_debug_mobile_template_enabled');
