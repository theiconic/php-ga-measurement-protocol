<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\Hit;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

class HitType extends SingleParameter
{
    const HIT_TYPE_PAGEVIEW = 'pageview';

    protected $name = 't';
}
