<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use TheIconic\Tracking\GoogleAnalytics\Parameters\General\ProtocolVersion;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\TrackingId;
use TheIconic\Tracking\GoogleAnalytics\Parameters\User\ClientId;
use TheIconic\Tracking\GoogleAnalytics\Parameters\Hit\HitType;

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

    /**
     * @var Analytics
     */
    private $analyticsSsl;


    public function setUp()
    {
        $this->analytics = new Analytics();
        $this->analyticsSsl = new Analytics(true);
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
            ->setTrackingId('UA-26293424-11')
            ->setClientId('555')
            ->setDocumentPath('/');

        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\Analytics', $response);
    }

    public function testSetIndexedParameter()
    {
        $response = $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('UA-26563724-11')
            ->setClientId('555')
            ->setDocumentPath('/')
            ->setProductImpressionListName('list name', 1);

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
        $this->analytics->setProductActionToCheckout();
        $this->analytics->setProductActionToCheckoutOption();
        $this->analytics->setProductActionToPurchase();
        $this->analytics->setProductActionToAdd();
        $this->analytics->setProductActionToClick();
        $this->analytics->setProductActionToDetail();
        $this->analytics->setProductActionToRefund();
        $this->analytics->setProductActionToRemove();
    }

    public function testSetPromotionAction()
    {
        $this->analytics->setPromotionActionToClick();
        $this->analytics->setPromotionActionToView();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetInvalidProductAction()
    {
        $this->analytics->setProductActionToPurchae();
    }

    public function testSendSimpleHit()
    {
        $httpClient = $this->getMock('TheIconic\Tracking\GoogleAnalytics\Network\HttpClient', ['post']);

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('http://www.google-analytics.com/collect'),
                $this->isType('array'),
                $this->isType('array')
            );

        $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId('555')
            ->setClientId('666')
            ->setDocumentPath('\thepage');

        $this->analytics->setHttpClient($httpClient);

        $this->analytics->sendPageview();
    }

    public function testSendSimpleSslHit()
    {
        $httpClient = $this->getMock('TheIconic\Tracking\GoogleAnalytics\Network\HttpClient', ['post']);

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('https://ssl.google-analytics.com/collect'),
                $this->isType('array'),
                $this->isType('array')
            );

        $this->analyticsSsl
            ->setAsyncRequest(true)
            ->setProtocolVersion('1')
            ->setTrackingId('555')
            ->setClientId('666')
            ->setDocumentPath('\mypage');

        $this->analyticsSsl->setHttpClient($httpClient);

        $this->analyticsSsl->sendPageview();
    }

    public function testSendComplexHit()
    {
        $singleParameters = [
            'v' => (new ProtocolVersion())->setValue('1'),
            'tid' => (new TrackingId())->setValue('555'),
            'cid' => (new ClientId())->setValue('666'),
            't' => (new HitType())->setValue('pageview'),
        ];

        $httpClient = $this->getMock('TheIconic\Tracking\GoogleAnalytics\Network\HttpClient', ['post']);

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('http://www.google-analytics.com/collect'),
                $this->equalTo($singleParameters),
                $this->isType('array')
            );

        $this->analytics
            ->makeNonBlocking()
            ->setProtocolVersion('1')
            ->setTrackingId('555')
            ->setClientId('666');

        $this->analytics->setHttpClient($httpClient);

        $this->analytics->sendPageview();
    }

    /**
     * @expectedException \TheIconic\Tracking\GoogleAnalytics\Exception\InvalidPayloadDataException
     */
    public function testMinimumParametersForSendHit()
    {
        $this->analytics->sendPageview();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetInvalidSendHit()
    {
        $this->analytics->sendPageviw();
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
