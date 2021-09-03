<?php
namespace Jankx\MobileLayout\Component;

use Jankx\Component\Abstracts\Component;
use Jankx\MobileLayout\Interfaces\Component\BodyOpenComponent;
use Jankx\MobileLayout\Interfaces\Component\HasBodyClassComponent;
use Jankx\MobileLayout\Frontend\TemplateLoader;

class StaticBottomNav extends Component implements BodyOpenComponent, HasBodyClassComponent
{
    const COMPONENT_NAME = 'bottom_nav';

    public function getName()
    {
        return static::COMPONENT_NAME;
    }

    public function defaultProps()
    {
        return array(
            'buttons' => array(
                'home' => array(
                    'icon' => 'home',
                    'text' => __('Home', 'jankx_mobile'),
                    'link' => '',
                    'image' => '',
                    'callback' => '',
                ),
                'feeds' => array(
                    'icon' => 'feeds',
                    'text' => __('Feeds', 'jankx_mobile'),
                    'link' => '',
                    'image' => '',
                    'callback' => '',
                ),
                'notifications' => array(
                    'icon' => 'notifications',
                    'text' => __('Notifications', 'jankx_mobile'),
                    'link' => '',
                    'image' => '',
                    'callback' => '',
                ),
                'account' => array(
                    'icon' => 'account',
                    'text' => __('Home', 'jankx_mobile'),
                    'link' => '',
                    'image' => '',
                    'callback' => '',
                ),
            )
        );
    }

    public function render()
    {
        echo sprintf('<div %s>', jankx_generate_html_attributes(array(
            'class' => 'jankx-bottom-nav',
        )));
        TemplateLoader::render('bottom-nav', array(
            'buttons' => array_get($this->props, 'buttons'),
        ));
        echo '</div>';
    }

    public function getBodyClasses()
    {
        return array(
            'jankx-has-bottom-nav'
        );
    }
}
