<?php
namespace Jankx\MobileLayout;

class DebugMode
{
    public function isDebug()
    {
        if (!defined('WP_DEBUG') || !constant('WP_DEBUG')) {
            return false;
        }
        $isDebug = false;
        if (defined('JANKX_MOBILE_LAYOUT_DEBUG') && JANKX_MOBILE_LAYOUT_DEBUG) {
            $isDebug = true;
        } else {
            $isDebug = array_get($_GET, 'mode') === 'debug';
        }
        return apply_filters('jankx/layout/mobile/is/debug', $isDebug);
    }

    public function isPreview()
    {
        if (!$this->isDebug() || $mode === 'preview') {
            return true;
        }
        return false;
    }

    public function includeDebugTemplate($template)
    {
        if (!$this->isPreview()) {
            return sprintf(
                '%s/templates/debug.php',
                JANKX_MOBILE_LAYOUT_ROOT
            );
        }
        return $template;
    }

    public function debug()
    {
    }
}
