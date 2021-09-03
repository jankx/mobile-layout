<?php
namespace Jankx\MobileLayout\Frontend;

use Jankx\Component\Constracts\Component;
use Jankx\MobileLayout\Component\StaticBottomNav;
use Jankx\MobileLayout\Interfaces\Component\BodyOpenComponent;
use Jankx\MobileLayout\Interfaces\Component\HasBodyClassComponent;
use Jankx\MobileLayout\Frontend\TemplateLoader;

class Frontend
{
    protected static $instance;

    protected $components;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        TemplateLoader::createEngine();
    }

    protected function getMobileComponents()
    {
        $mobileComponents = array(
            'bottom_nav' => StaticBottomNav::class,
        );
        return apply_filters('jankx/layout/mobile/components', $mobileComponents);
    }

    protected function loadComponent($component)
    {
        $component->parseProps(
            apply_filters("jankx/layout/mobile/component/{$component->getName()}/props", array())
        );

        if (is_a($component, BodyOpenComponent::class)) {
            add_action('wp_body_open', array($component, 'render'));
        }
        if (is_a($component, HasBodyClassComponent::class)) {
            $newClasses = $component->getBodyClasses();
            if ($newClasses) {
                if (!is_array($newClasses)) {
                    $newClasses = array($newClasses);
                }
                add_filter('body_class', function ($classes) use ($newClasses) {
                    return array_merge($classes, $newClasses);
                });
            }
        }
    }

    public function init()
    {
        $components = $this->getMobileComponents();
        foreach ($components as $component_cls) {
            if (!class_exists($component_cls)) {
                error_log(sprintf('Component "%s" is invalid', $component_cls));
                continue;
            }
            $component = new $component_cls();
            $this->components[$component->getName()] = $component;

            $this->loadComponent($component);
        }
    }

    public static function getComponentByName($componentName)
    {
        $instance = static::getInstance();
        if (isset($instance->components[$componentName])) {
            return $instance->components[$componentName];
        }
    }
}
