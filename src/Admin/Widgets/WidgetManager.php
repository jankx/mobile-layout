<?php
namespace Jankx\MobileLayout\Admin\Widgets;

class WidgetManager
{
    public function load()
    {
        add_action('current_screen', array($this, 'add_link_enable_mobile_widgets'));
    }

    public function add_link_enable_mobile_widgets($screen)
    {
    }
}
