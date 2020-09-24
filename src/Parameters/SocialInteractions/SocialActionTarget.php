<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\SocialInteractions;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

/**
 * Class SocialActionTarget
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#st
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters\SocialInteractions
 */
class SocialActionTarget extends SingleParameter
{
    /**
     * @inheritDoc
     *
     * @var string
     */
    protected $name = 'st';
}
