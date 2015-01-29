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
     * Value for product action detail.
     */
    const PRODUCT_ACTION_DETAIL = 'detail';

    /**
     * Value for product action click.
     */
    const PRODUCT_ACTION_CLICK = 'click';

    /**
     * Value for product action add.
     */
    const PRODUCT_ACTION_ADD = 'add';

    /**
     * Value for product action remove.
     */
    const PRODUCT_ACTION_REMOVE = 'remove';

    /**
     * Value for product action checkout.
     */
    const PRODUCT_ACTION_CHECKOUT = 'checkout';

    /**
     * Value for product action checkout option.
     */
    const PRODUCT_ACTION_CHECKOUTOPTION = 'checkout_option';

    /**
     * Value for product action purchase.
     */
    const PRODUCT_ACTION_PURCHASE = 'purchase';

    /**
     * Value for product action refund.
     */
    const PRODUCT_ACTION_REFUND = 'refund';

    /**
     * @inheritDoc
     *
     * @var string
     */
    protected $name = 'pa';
}
