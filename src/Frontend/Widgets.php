<?php
namespace Jankx\MobileLayout\Frontend;

use Jankx\MobileLayout\Admin\Widgets\WidgetManager;

class Widgets
{
    public function loadMobileWidgets()
    {
        if (wp_is_request('frontend') && jankx_is_mobile()) {
            add_filter('pre_option_sidebars_widgets', array($this, 'load'), 10, 3);
        }

        if (is_admin()) {
            add_action('current_screen', array($this, 'admin_load'));
        }
    }

    public function admin_load($screen)
    {
        if ($screen->id !== 'widgets' || !isset($_GET['jankx-widgets-mode'], $_GET['_wpnonce'])) {
            return;
        }
        if (trim($_GET['jankx-widgets-mode']) === 'mobile' && wp_verify_nonce($_GET['_wpnonce'], WidgetManager::NONCE_MODE_KEY)) {
            add_filter('pre_option_sidebars_widgets', array($this, 'load'), 10, 3);
        }
    }

    public function load($pre, $option, $default)
    {
        return get_option(
            'jankx_mobile_sidebars_widgets',
            $pre
        );
    }
}
