<?php
namespace Jankx\MobileLayout;

class Switcher
{
    public function switchLayout()
    {
        if (isset($_GET['view']) && in_array($_GET['view'], array('m', 'd'))) {
            add_filter('jankx/device/is_mobile/pre', '__return_true');
            add_filter('jankx/device/is_mobile/template', '__return_true');
        }
    }
}
