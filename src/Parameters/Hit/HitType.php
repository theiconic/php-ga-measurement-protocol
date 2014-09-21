<?php

namespace JorgeBorges\Google\Analytics\Parameters\Hit;

use JorgeBorges\Google\Analytics\Parameters\AbstractParameter;

class HitType extends AbstractParameter
{
    const HIT_TYPE_PAGEVIEW = 'pageview';

    protected $name = 't';
}
