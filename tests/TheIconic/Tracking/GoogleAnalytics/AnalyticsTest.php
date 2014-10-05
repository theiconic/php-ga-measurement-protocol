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
}
