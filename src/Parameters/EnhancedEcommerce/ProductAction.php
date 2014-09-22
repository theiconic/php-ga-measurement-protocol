<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

class ProductAction extends SingleParameter
{
    const PRODUCT_ACTION_DETAIL = 'detail';

    const PRODUCT_ACTION_CLICK = 'click';

    const PRODUCT_ACTION_ADD = 'add';

    const PRODUCT_ACTION_REMOVE = 'remove';

    const PRODUCT_ACTION_CHECKOUT = 'checkout';

    const PRODUCT_ACTION_CHECKOUT_OPTION = 'checkout_option';

    const PRODUCT_ACTION_PURCHASE = 'purchase';

    const PRODUCT_ACTION_REFUND = 'refund';

    protected $name = 'pa';
}
