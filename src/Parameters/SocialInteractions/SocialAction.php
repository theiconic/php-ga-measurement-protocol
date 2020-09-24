<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\SocialInteractions;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

/**
 * Class SocialAction
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#sa
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters\SocialInteractions
 */
class SocialAction extends SingleParameter
{
    /**
     * @inheritDoc
     *
     * @var string
     */
    protected $name = 'sa';
}
