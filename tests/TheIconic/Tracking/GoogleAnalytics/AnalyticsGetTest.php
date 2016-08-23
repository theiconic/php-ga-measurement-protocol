<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use TheIconic\Tracking\GoogleAnalytics\Parameters\ContentGrouping\ContentGroup;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\Affiliation;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\CouponCode;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\Product;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\ProductAction;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\ProductCollection;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\Revenue;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\Shipping;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\Tax;
use TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\TransactionId;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\AnonymizeIp;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\CacheBuster;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\DataSource;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\ProtocolVersion;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\QueueTime;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\TrackingId;
use TheIconic\Tracking\GoogleAnalytics\Parameters\Hit\NonInteractionHit;
use TheIconic\Tracking\GoogleAnalytics\Parameters\Session\IpOverride;
use TheIconic\Tracking\GoogleAnalytics\Parameters\TrafficSources\GoogleDisplayAdsId;
use TheIconic\Tracking\GoogleAnalytics\Parameters\User\ClientId;
use TheIconic\Tracking\GoogleAnalytics\Parameters\Hit\HitType;

/**
 * Class AnalyticsGetTest
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class AnalyticsGetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Analytics
     */
    private $analytics;

    /**
     * @var Analytics
     */
    private $analyticsSsl;


    public function setUp()
    {
        $this->analytics = new Analytics();
        $this->analyticsSsl = new Analytics(true);
    }

    public function testGetParameter()
    {
        $Analytics = $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('UA-26293424-11')
            ->setClientId('555')
            ->setDocumentPath('/');

        $this->assertEquals('1', $Analytics->getProtocolVersion());
        $this->assertEquals('UA-26293424-11', $Analytics->getTrackingId());
        $this->assertEquals('555', $Analytics->getClientId());
        $this->assertEquals('/', $Analytics->getDocumentPath());
    }

    public function testGetIndexedParameter()
    {
        $Analytics = $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('UA-26563724-11')
            ->setClientId('555')
            ->setDocumentPath('/')
            ->setProductImpressionListName('list name', 1)
            ->setProductImpressionListName('list test', 2);

        $this->assertEquals('1', $Analytics->getProtocolVersion());
        $this->assertEquals('UA-26563724-11', $Analytics->getTrackingId());
        $this->assertEquals('555', $Analytics->getClientId());
        $this->assertEquals('/', $Analytics->getDocumentPath());
        $this->assertEquals('list name', $Analytics->getProductImpressionListName(1));
        $this->assertEquals('list test', $Analytics->getProductImpressionListName(2));
        $this->assertEquals(null, $Analytics->getProductImpressionListName(3));
    }

    public function testGetNullParameter()
    {
        $Analytics = $this->analytics;

        $this->assertEquals(null, $Analytics->getProtocolVersion());
        $this->assertEquals(null, $Analytics->getTrackingId());
        $this->assertEquals(null, $Analytics->getClientId());
        $this->assertEquals(null, $Analytics->getDocumentPath());
        $this->assertEquals(null, $Analytics->getProductImpressionListName(1));
        $this->assertEquals(null, $Analytics->getProductImpressionListName(2));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetInvalidParameter()
    {
        $this->analytics
            ->getNonExistant();
    }

    /**
     * @expectedException TheIconic\Tracking\GoogleAnalytics\Exception\InvalidIndexException
     */
    public function testGetInvalidIndexedParameter()
    {
        $Analytics = $this->analytics
            ->setProductImpressionListName('list name', 1)
            ->setProductImpressionListName('list test', 2);

        $Analytics->getProductImpressionListName();
    }

    public function testGetProductAction()
    {
        $Analytics = $this->analytics->setProductActionToCheckoutOption();
        $this->assertEquals("checkout_option", $Analytics->getProductAction());

        $Analytics = $this->analytics->setProductActionToPurchase();
        $this->assertEquals("purchase", $Analytics->getProductAction());

        $Analytics = $this->analytics->setProductActionToAdd();
        $this->assertEquals("add", $Analytics->getProductAction());

        $Analytics = $this->analytics->setProductActionToClick();
        $this->assertEquals("click", $Analytics->getProductAction());

        $Analytics = $this->analytics->setProductActionToDetail();
        $this->assertEquals("detail", $Analytics->getProductAction());

        $Analytics = $this->analytics->setProductActionToRefund();
        $this->assertEquals("refund", $Analytics->getProductAction());

        $Analytics = $this->analytics->setProductActionToRemove();
        $this->assertEquals("remove", $Analytics->getProductAction());


    }

    public function testGetPromotionAction()
    {
        $Analytics = $this->analytics->setPromotionActionToClick();

        $this->assertEquals("click", $Analytics->getPromotionAction());

    }

    public function testGetAddItem()
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

        $this->assertEquals('AAAA-6666', $response->getProduct()[0]['sku']);
        $this->assertEquals('AAAA-5555', $response->getProduct()[1]['sku']);
        $this->assertEquals('Test Product', $response->getProduct()[1]['name']);
        $this->assertEquals('Test Brand', $response->getProduct()[1]['brand']);
        $this->assertEquals('Test Category 1/Test Category 2', $response->getProduct()[1]['category']);
        $this->assertEquals('blue', $response->getProduct()[1]['variant']);
        $this->assertEquals(85.00, $response->getProduct()[1]['price']);
        $this->assertEquals(2, $response->getProduct()[1]['quantity']);
        $this->assertEquals('TEST', $response->getProduct()[1]['coupon_code']);
        $this->assertEquals(4, $response->getProduct()[1]['position']);
    }

    public function testGetNullItems()
    {
        $this->assertEquals(null, $this->analytics->getProduct());
    }




}
