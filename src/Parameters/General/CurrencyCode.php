<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\General;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

/**
 * Class CurrencyCode
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#cu
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters\General
 */
class CurrencyCode extends SingleParameter
{
    /**
     * @inheritDoc
     *
     * @var string
     */
    protected $name = 'cu';
}
