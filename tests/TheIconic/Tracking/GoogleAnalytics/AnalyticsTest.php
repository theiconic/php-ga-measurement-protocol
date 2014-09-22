<?php

namespace TheIconic\Tracking\GoogleAnalytics;

class AnalyticsTest extends \PHPUnit_Framework_TestCase
{
    public function testSimplePageview()
    {
        $analytics = new Analytics();

        $result = $analytics->setProtocolVersion('1')
            ->setTrackingId('UA-26293724-11')
            ->setClientId('555')
            ->setDocumentPath('/')
            ->sendPageview();

        $this->assertEquals('200', $result);
    }

/*    public function testPurchaseTracking()
    {
        $analytics = new Analytics();

        $analytics->setProtocolVersion('1')
            ->setTrackingId('UA-26293724-11')
            ->setClientId('555')
            ->setUserId('666')
            ->setDocumentHostName('alice.core.au')
            ->setDocumentPath('/')
            ->setTransactionId('12345')
            ->setAffiliation('THE ICONIC')
            ->setRevenue(100.50)
            ->setTax(10.0)
            ->setShipping(15.5)
            ->setCouponCode('TEST');

        $productData = [
            'sku' => 'AAAA-5555',
            'name' => 'Test Product',
            'brand' => 'Test Brand',
            'category' => 'Test Category 1/Test Category 2',
            'variant' => 'blue',
            'price' => 85,
            'quantity' => 2,
            'coupon_code' => 'TEST',
            'position' => 4
        ];

        $product = new Parameters\EnhancedEcommerce\Product($productData);

        $analytics->addProduct($product)
            ->setProductActionPurchase();

        $analytics->setEventCategory('')

        $this->assertEquals('200', $result);
    }*/
}
