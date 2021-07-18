<?php
namespace Jankx\MobileLayout;

use Jankx\MobileLayout\Admin\Widgets\WidgetManager;

class Admin
{
    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'load'));
    }

    public function load()
    {
        // Load widget manager
        $widget_manager = new WidgetManager();
        $widget_manager->manage();
    }
}
