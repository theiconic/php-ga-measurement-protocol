<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\Hit;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

class HitType extends SingleParameter
{
    const HIT_TYPE_PAGEVIEW = 'pageview';

    const HIT_TYPE_EVENT = 'event';

    const HIT_TYPE_SCREENVIEW = 'screenview';

    const HIT_TYPE_TRANSACTION = 'transaction';

    const HIT_TYPE_ITEM = 'item';

    const HIT_TYPE_SOCIAL = 'social';

    const HIT_TYPE_EXCEPTION = 'exception';

    const HIT_TYPE_TIMING = 'timing';

    protected $name = 't';
}
