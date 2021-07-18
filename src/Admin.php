<?php
namespace Jankx\MobileLayout;

class Admin
{
    public function __construct()
    {
        add_action('current_screen', array($this, 'add_link_enable_mobile_widgets'));
    }

    public function add_link_enable_mobile_widgets($screen)
    {
    }
}
