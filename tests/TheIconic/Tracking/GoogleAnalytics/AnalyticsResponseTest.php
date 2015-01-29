<?php

namespace TheIconic\Tracking\GoogleAnalytics;

class AnalyticsResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnalyticsResponse
     */
    private $analyticsResponse;

    public function setUp()
    {
        $mockResponse = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->setMethods(['getStatusCode'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse->expects($this->atLeast(1))
            ->method('getStatusCode')
            ->will($this->returnValue('200'));

        $mockRequest = $this->getMockBuilder('GuzzleHttp\Message\Request')
            ->setMethods(['getUrl'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockRequest->expects($this->atLeast(1))
            ->method('getUrl')
            ->will($this->returnValue('http://test-collector/hello'));

        $this->analyticsResponse = new AnalyticsResponse($mockRequest, $mockResponse);
    }

    public function testStatusCode()
    {
        $this->assertEquals('200', $this->analyticsResponse->getHttpStatusCode());
    }

    public function testGetUrl()
    {
        $this->assertEquals('http://test-collector/hello', $this->analyticsResponse->getRequestUrl());
    }
}
