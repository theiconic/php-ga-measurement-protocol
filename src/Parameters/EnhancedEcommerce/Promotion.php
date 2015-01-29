<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce;

use TheIconic\Tracking\GoogleAnalytics\Parameters\CompoundParameter;

/**
 * Class Promotion
 *
 * Represents the promotion to be added to the google analytics hit.
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#enhanced-ecomm
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce
 */
class Promotion extends CompoundParameter
{
    /**
     * Key/value pair associative array that maches promotion fields with google analytics parameter name.
     *
     * @var array
     */
    protected $parameterNameMapper = [
        '/^id$/' => 'id',
        '/^name$/' => 'nm',
        '/^creative$/' => 'cr',
        '/^position$/' => 'ps',
    ];

    /**
     * Validates the promotion. ID and name are required.
     * Translates and saves the promotion fields to be sent later in case they are valid.
     *
     * @throws \InvalidArgumentException
     *
     * @param array $promotionData
     */
    public function __construct(array $promotionData)
    {
        if (empty($promotionData['id']) && empty($promotionData['name'])) {
            throw new \InvalidArgumentException('Either SKU or Name must be set for a product');
        }

        $this->saveCompoundParameterData($promotionData);
    }
}
