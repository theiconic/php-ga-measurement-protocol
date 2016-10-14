<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use GuzzleHttp\Psr7\Uri;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class AnalyticsResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnalyticsResponse
     */
    private $analyticsResponse;

    /**
     * @var AnalyticsResponse
     */
    private $analyticsResponseAsync;

    /**
     * @var AnalyticsResponse
     */
    private $analyticsDebugResponse;

    /**
     * @var RequestInterface
     */
    private $mockRequest;

    public function setUp()
    {
        $mockResponse = $this->getMockForAbstractClass(ResponseInterface::class);

        $mockResponse->expects(static::atLeast(1))
            ->method('getStatusCode')
            ->will(static::returnValue('200'));

        $invalidBodyMock = $this->getMockForAbstractClass(StreamInterface::class);

        $invalidBodyMock->expects(static::any())
            ->method('getContents')
            ->willReturn('asldkjaslkdjsadlkj');

        $mockResponse->expects(static::any())
            ->method('getBody')
            ->willReturn($invalidBodyMock);

        $this->mockRequest = $this->getMockForAbstractClass(RequestInterface::class);

        $this->mockRequest->expects(static::atLeast(1))
            ->method('getUri')
            ->willReturn(new Uri('http://test-collector/hello'));

        $this->analyticsResponse = new AnalyticsResponse($this->mockRequest, $mockResponse);


        $mockResponseAsync = $this->getMockForAbstractClass(Promise::class);

        $this->analyticsResponseAsync = new AnalyticsResponse($this->mockRequest, $mockResponseAsync);


        $mockDebugResponse = $this->getMockForAbstractClass(ResponseInterface::class);

        $mockDebugResponse->expects(static::atLeast(1))
            ->method('getStatusCode')
            ->willReturn(200);

        $bodyMock = $this->getMockForAbstractClass(StreamInterface::class);

        $bodyMock->expects(static::atLeast(1))
            ->method('__toString')
            ->willReturn('{"salutation":"hello world"}');

        $mockDebugResponse->expects(static::atLeast(1))
            ->method('getBody')
            ->willReturn($bodyMock);

        $this->analyticsDebugResponse = new AnalyticsResponse($this->mockRequest, $mockDebugResponse);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithWrongResponseValue()
    {
        new AnalyticsResponse($this->mockRequest, new \stdClass());
    }

    public function testStatusCode()
    {
        static::assertEquals(200, $this->analyticsResponse->getHttpStatusCode());
        static::assertNull($this->analyticsResponseAsync->getHttpStatusCode());
    }

    public function testGetUrl()
    {
        static::assertEquals('http://test-collector/hello', $this->analyticsResponse->getRequestUrl());
        static::assertEquals('http://test-collector/hello', $this->analyticsResponseAsync->getRequestUrl());
    }

    public function testDebugResponse()
    {
        static::assertEquals(['salutation' => 'hello world'], $this->analyticsDebugResponse->getDebugResponse());
        static::assertEquals([], $this->analyticsResponse->getDebugResponse());
    }
}
