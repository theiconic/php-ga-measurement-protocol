<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\Hit;

use TheIconic\Tracking\GoogleAnalytics\Parameters\AbstractParameter;

class HitType extends AbstractParameter
{
    const HIT_TYPE_PAGEVIEW = 'pageview';

    protected $name = 't';
}
