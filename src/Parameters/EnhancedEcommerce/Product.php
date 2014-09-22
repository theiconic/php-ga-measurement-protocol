<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce;

use TheIconic\Tracking\GoogleAnalytics\Parameters\CompoundParameter;

class Product extends CompoundParameter
{
    protected $parameterNameMapper = [
        '/^sku$/' => 'id',
        '/^name$/' => 'nm',
        '/^brand$/' => 'br',
        '/^category$/' => 'ca',
        '/^variant$/' => 'va',
        '/^price$/' => 'pr',
        '/^coupon_code$/' => 'cc',
        '/^position$/' => 'ps',
        '/^quantity$/' => 'qt',
        '/^custom_dimension_\d{1,3}$/' => 'cd',
        '^custom_metric_\d{1,3}$' => 'cm',
    ];

    public function __construct(array $productData)
    {
        if (empty($productData['sku']) && empty($productData['name'])) {
            throw new \InvalidArgumentException('Either SKU or Name must be set for a product');
        }

        $this->saveCompoundParameterData($productData);
    }
}
