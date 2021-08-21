<?php
namespace Jankx\MobileLayout\Admin\Widgets;

use Jankx;

class WidgetManager
{
    const NONCE_KEY = 'jankx_change_mobile_widgets_status';
    const NONCE_MODE_KEY = 'jankx_widgets_mode';

    public function manage()
    {
        add_action('current_screen', array($this, 'add_link_enable_mobile_widgets'));
        add_filter('pre_update_option_sidebars_widgets', array($this, 'save_mobile_widgets'), 10, 3);
    }

    public function add_link_enable_mobile_widgets($screen)
    {
        if ($screen->id === 'widgets') {
            if (isset($_GET['jankx-mobile-widgets']) && isset($_GET['_wpnonce'])) {
                $status = trim($_GET['jankx-mobile-widgets']);
                $nonce = trim($_GET['_wpnonce']);

                if (in_array($status, array('enable', 'disable')) && wp_verify_nonce($nonce, static::NONCE_KEY)) {
                    update_option(
                        sprintf('jankx_mobile_widgets_%s_status', Jankx::templateStylesheet()),
                        $status,
                        true
                    );
                }
            }

            add_action('all_admin_notices', array($this, 'start_monitor_buffers'), 1000);
            add_action('widgets_admin_page', array($this, 'add_enable_mobile_widgets_link'), -5);
        }
    }

    public function start_monitor_buffers()
    {
        ob_start();
    }

    public function get_mobile_widget_links($status)
    {
        $nonce = wp_create_nonce(static::NONCE_KEY);

        return sprintf(
            '<a href="%1$s" title="%2$s">%2$s</a>',
            admin_url(sprintf(
                'widgets.php?jankx-mobile-widgets=%s&_wpnonce=%s',
                $status === 'enable' ? 'disable' : 'enable',
                $nonce
            )),
            $status === 'enable'
                ? __('Disable mobile widgets', 'jankx_mobile')
                : __('Enable mobile widgets', 'jankx_mobile')
        );
    }

    protected function get_mobile_widet_mode($status)
    {
        if ($status === 'disable') {
            return '';
        }
        $mode = array_get($_GET, 'jankx-widgets-mode', 'desktop');
        if (!wp_verify_nonce(array_get($_GET, '_wpnonce'), static::NONCE_MODE_KEY)) {
            $mode = 'desktop';
        }

        return sprintf(
            '<a href="%s?jankx-widgets-mode=%s&_wpnonce=%s" class="page-title-action">%s</a>',
            admin_url('widgets.php'),
            $mode !== 'desktop' ? 'desktop' : 'mobile',
            wp_create_nonce(static::NONCE_MODE_KEY),
            $mode === 'desktop'
                ? __('Mobile Widgets', 'jankx_mobile')
                : __('Desktop Widgets', 'jankx_mobile')
        );
    }

    public function add_enable_mobile_widgets_link()
    {
        $html = ob_get_clean();
        $mobile_widget_status = get_option(
            sprintf('jankx_mobile_widgets_%s_status', Jankx::templateStylesheet()),
            'disable'
        );

        $detect_string = '<div class="widget-access-link">';
        $mobile_widget_links = $this->get_mobile_widget_links($mobile_widget_status);
        $widgets_mode = $this->get_mobile_widet_mode($mobile_widget_status);

        echo str_replace(
            $detect_string,
            $widgets_mode . $detect_string . $mobile_widget_links,
            $html
        );
    }

    public function save_mobile_widgets($value, $old_value, $option)
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            return $value;
        }
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        if (strpos($referer['path'], '/wp-admin/widgets.php') === false) {
            return $value;
        }

        parse_str($referer['query'], $queries);
        if (!isset($queries['jankx-widgets-mode'], $queries['_wpnonce'])) {
            return $value;
        }

        // Verify nonce to ensure user update widget via WordPress admin
        if ($queries['jankx-widgets-mode'] !== 'mobile' || !wp_verify_nonce(trim($queries['_wpnonce']), static::NONCE_MODE_KEY)) {
            return $value;
        }

        // Save mobile widgets
        update_option('jankx_mobile_sidebars_widgets', $value);

        return $old_value;
    }
}
