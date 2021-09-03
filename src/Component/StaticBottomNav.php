<?php
namespace Jankx\MobileLayout\Component;

use Jankx\Component\Abstracts\Component;
use Jankx\MobileLayout\Interfaces\Component\BodyOpenComponent;

class StaticBottomNav extends Component implements BodyOpenComponent
{
    const COMPONENT_NAME = 'bottom_nav';

    public function getName()
    {
        return static::COMPONENT_NAME;
    }

    public function render()
    {
    }
}
