<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\Timing;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

/**
 * Class UserTimingCategory
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#utc
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters\Timing
 */
class UserTimingCategory extends SingleParameter
{
    /**
     * @inheritDoc
     *
     * @var string
     */
    protected $name = 'utc';
}
