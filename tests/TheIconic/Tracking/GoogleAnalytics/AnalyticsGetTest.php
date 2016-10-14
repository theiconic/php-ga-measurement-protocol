<?php

namespace TheIconic\Tracking\GoogleAnalytics;

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
        $analytics = $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('UA-26293424-11')
            ->setClientId('555')
            ->setDocumentPath('/');

        $this->assertEquals('1', $analytics->getProtocolVersion());
        $this->assertEquals('UA-26293424-11', $analytics->getTrackingId());
        $this->assertEquals('555', $analytics->getClientId());
        $this->assertEquals('/', $analytics->getDocumentPath());
    }

    public function testGetIndexedParameter()
    {
        $analytics = $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('UA-26563724-11')
            ->setClientId('555')
            ->setDocumentPath('/')
            ->setProductImpressionListName('list name', 1)
            ->setProductImpressionListName('list test', 2);

        $this->assertEquals('1', $analytics->getProtocolVersion());
        $this->assertEquals('UA-26563724-11', $analytics->getTrackingId());
        $this->assertEquals('555', $analytics->getClientId());
        $this->assertEquals('/', $analytics->getDocumentPath());
        $this->assertEquals('list name', $analytics->getProductImpressionListName(1));
        $this->assertEquals('list test', $analytics->getProductImpressionListName(2));
        $this->assertEquals(null, $analytics->getProductImpressionListName(3));
    }

    public function testGetNullParameter()
    {
        $analytics = $this->analytics;

        $this->assertEquals(null, $analytics->getProtocolVersion());
        $this->assertEquals(null, $analytics->getTrackingId());
        $this->assertEquals(null, $analytics->getClientId());
        $this->assertEquals(null, $analytics->getDocumentPath());
        $this->assertEquals(null, $analytics->getProductImpressionListName(1));
        $this->assertEquals(null, $analytics->getProductImpressionListName(2));
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
     * @expectedException \TheIconic\Tracking\GoogleAnalytics\Exception\InvalidIndexException
     */
    public function testGetInvalidIndexedParameter()
    {
        $analytics = $this->analytics
            ->setProductImpressionListName('list name', 1)
            ->setProductImpressionListName('list test', 2);

        $analytics->getProductImpressionListName();
    }

    public function testGetProductAction()
    {
        $analytics = $this->analytics->setProductActionToCheckoutOption();
        $this->assertEquals("checkout_option", $analytics->getProductAction());

        $analytics = $this->analytics->setProductActionToPurchase();
        $this->assertEquals("purchase", $analytics->getProductAction());

        $analytics = $this->analytics->setProductActionToAdd();
        $this->assertEquals("add", $analytics->getProductAction());

        $analytics = $this->analytics->setProductActionToClick();
        $this->assertEquals("click", $analytics->getProductAction());

        $analytics = $this->analytics->setProductActionToDetail();
        $this->assertEquals("detail", $analytics->getProductAction());

        $analytics = $this->analytics->setProductActionToRefund();
        $this->assertEquals("refund", $analytics->getProductAction());

        $analytics = $this->analytics->setProductActionToRemove();
        $this->assertEquals("remove", $analytics->getProductAction());
    }

    public function testGetPromotionAction()
    {
        $analytics = $this->analytics->setPromotionActionToClick();

        $this->assertEquals("click", $analytics->getPromotionAction());
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
            'position' => 4
        ];

        $this->analytics->setProductImpressionListName('List_1', 1);

        $this->analytics->addProductImpression($productData, 1);

        $this->assertEquals('AAAA-6666', $this->analytics->getProduct()[0]['sku']);
        $this->assertEquals('AAAA-5555', $this->analytics->getProductImpression(1)[0]['sku']);
        $this->assertEquals('List_1', $this->analytics->getProductImpressionListName(1));
    }

    public function testGetNullItems()
    {
        $this->assertEquals(null, $this->analytics->getProduct());
    }
}
