<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

/**
 * Class ProductAction
 *
 * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#pa
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce
 */
class ProductAction extends SingleParameter
{
    /**
     *
     */
    const PRODUCT_ACTION_DETAIL = 'detail';

    /**
     *
     */
    const PRODUCT_ACTION_CLICK = 'click';

    /**
     *
     */
    const PRODUCT_ACTION_ADD = 'add';

    /**
     *
     */
    const PRODUCT_ACTION_REMOVE = 'remove';

    /**
     *
     */
    const PRODUCT_ACTION_CHECKOUT = 'checkout';

    /**
     *
     */
    const PRODUCT_ACTION_CHECKOUTOPTION = 'checkout_option';

    /**
     *
     */
    const PRODUCT_ACTION_PURCHASE = 'purchase';

    /**
     *
     */
    const PRODUCT_ACTION_REFUND = 'refund';

    /**
     * @inheritDoc
     *
     * @var string
     */
    protected $name = 'pa';
}
