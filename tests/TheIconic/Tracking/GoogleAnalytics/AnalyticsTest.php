<?php

namespace TheIconic\Tracking\GoogleAnalytics;

/**
 * Class AnalyticsTest
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class AnalyticsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Analytics
     */
    private $analytics;


    public function setUp()
    {
        $this->analytics = new Analytics();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidClassInitialization()
    {
        (new Analytics('1'));
    }

    public function testHttpsEndpoint()
    {
        $sslAnalytics = new Analytics(true);
        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\Analytics', $sslAnalytics);
    }

    public function testSetParameter()
    {
        $response = $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('UA-26293724-11')
            ->setClientId('555')
            ->setDocumentPath('/');

        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\Analytics', $response);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidParameterValue()
    {
        $this->analytics
            ->setProtocolVersion();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetInvalidParameter()
    {
        $this->analytics
            ->setNonExistant('1');
    }

    public function testAddItem()
    {
        $productData = [
            'sku' => 'AAAA-6666',
            'name' => 'Test Product 2',
            'brand' => 'Test Brand 2',
            'category' => 'Test Category 3/Test Category 4',
            'variant' => 'yellow',
            'price' => 50.00,
            'quantity' => 1,
            'coupon_code' => 'TEST 2',
            'position' => 2
        ];

        $this->analytics->addProduct($productData);

        $productData = [
            'sku' => 'AAAA-5555',
            'name' => 'Test Product',
            'brand' => 'Test Brand',
            'category' => 'Test Category 1/Test Category 2',
            'variant' => 'blue',
            'price' => 85.00,
            'quantity' => 2,
            'coupon_code' => 'TEST',
            'position' => 4
        ];

        $response = $this->analytics->addProduct($productData);

        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\Analytics', $response);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testAddNonExistant()
    {
        $this->analytics
            ->addNonExistant('1');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidAddValue()
    {
        $this->analytics
            ->addProduct();
    }

    public function testSetProductAction()
    {
        $this->analytics->setProductActionToPurchase();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetInvalidProductAction()
    {
        $this->analytics->setProductActionToPurchae();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testInvalidMethodCall()
    {
        $this->analytics
            ->iDontExists();
    }
}
