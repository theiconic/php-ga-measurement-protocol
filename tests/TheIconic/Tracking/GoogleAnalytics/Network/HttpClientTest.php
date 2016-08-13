<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use TheIconic\Tracking\GoogleAnalytics\Parameters\General\CacheBuster;
use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundParameterTestCollection;
use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameterIndexed;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var HttpClient
     */
    private $mockHttpClient;

    public function setUp()
    {
        $this->httpClient = new HttpClient();

        $mockResponse = $this->getMockBuilder('GuzzleHttp\Psr7\Response')
            ->setMethods(['getStatusCode'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockPromise = $this->getMockBuilder('GuzzleHttp\Promise\Promise')
            ->disableOriginalConstructor()
            ->getMock();

        $mockPromise->expects($this->exactly(3))
            ->method('wait')
            ->will($this->returnValue($mockResponse));

        $guzzleClient = $this->getMockBuilder('GuzzleHttp\Client')
            ->setMethods(['sendAsync'])
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->expects($this->atLeast(1))
            ->method('sendAsync')
            ->with($this->anything())
            ->will($this->returnValue($mockPromise));

        $this->httpClient->setClient($guzzleClient);

        $this->mockHttpClient = $this->getMockBuilder('TheIconic\Tracking\GoogleAnalytics\Network\HttpClient')
            ->setMethods(['getAnalyticsResponse'])
            ->getMock();

        $this->mockHttpClient->expects($this->atLeast(1))
            ->method('getAnalyticsResponse')
            ->will($this->returnArgument(1));

        $this->mockHttpClient->setClient($guzzleClient);
    }

    public function testPost()
    {
        $response = $this->mockHttpClient->post('http://test-collector.com/collect?v=1');
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $response);

        $responseAsync = $this->mockHttpClient->post('http://test-collector.com/collect?v=1', true);
        $this->assertInstanceOf('GuzzleHttp\Promise\PromiseInterface', $responseAsync);

        $response = $this->httpClient->post('http://test-collector.com/collect?v=1');

        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse', $response);

        // Promises should be unwrapped on the object destruction
        $this->httpClient = null;
        $this->mockHttpClient = null;
    }
}
