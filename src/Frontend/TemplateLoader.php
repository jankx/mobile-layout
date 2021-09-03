<?php
namespace Jankx\MobileLayout\Frontend;

use Jankx;
use Jankx\Template\Template;
use Jankx\TemplateLoader as CoreTemplateLoader;

class TemplateLoader
{
    protected static $engine;
    protected static $coreEngine;

    public static function createEngine()
    {
        if (is_null(static::$engine)) {
            static::$engine = Template::createEngine(
                'jankx_mobile',
                sprintf('%s/mobile', apply_filters('jankx/theme/template/directory', 'templates')),
                sprintf('%s/templates', constant('JANKX_MOBILE_LAYOUT_ROOT')),
                Jankx::getActiveTemplateEngine()
            );
        }
    }

    protected function renderByCore($templates, $data = array(), $echo = true)
    {
        if (is_null(static::$coreEngine)) {
            static::$coreEngine = CoreTemplateLoader::getTemplateEngine();
        }
        return static::$coreEngine->render($templates, $data, $echo);
    }

    public static function render($templates, $data = array(), $echo = true)
    {
        return static::$engine->render(
            $templates,
            $data,
            $echo
        );
    }
}
