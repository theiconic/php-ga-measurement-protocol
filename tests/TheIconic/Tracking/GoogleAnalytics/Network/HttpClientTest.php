<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use Psr\Http\Message\RequestInterface;

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
    }

    /**
     * @dataProvider dataProviderInvalidOptions
     *
     * @param array $options
     * @param $exceptionMessage
     */
    public function testPostValidatesOptions(array $options, $exceptionMessage)
    {
        $guzzleClient = $this->getMockBuilder('GuzzleHttp\Client')
            ->setMethods(['sendAsync'])
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->expects($this->never())->method('sendAsync');
        $this->httpClient->setClient($guzzleClient);

        $this->setExpectedException(\UnexpectedValueException::class, $exceptionMessage);

        $this->httpClient->post('http://test-collector.com/collect?v=1', $options);
    }

    public static function dataProviderInvalidOptions()
    {
        $timeoutExc = 'The timeout must be an integer with a value greater than 0';
        $asyncExc = 'The async option must be boolean';

        return [
            [['timeout' => 'no'], $timeoutExc],
            [['timeout' => -1], $timeoutExc],
            [['timeout' => true], $timeoutExc],
            [['async' => 'false'], $asyncExc],
            [['async' => 1], $asyncExc],
        ];
    }

    public function testPost()
    {
        $mockResponse = $this->getMockBuilder('GuzzleHttp\Psr7\Response')
            ->setMethods(['getStatusCode'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockPromise = $this->getMockBuilder('GuzzleHttp\Promise\Promise')
            ->disableOriginalConstructor()
            ->getMock();

        $mockPromise->expects($this->exactly(4))
            ->method('wait')
            ->will($this->returnValue($mockResponse));

        $guzzleClient = $this->getMockBuilder('GuzzleHttp\Client')
            ->setMethods(['sendAsync'])
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->expects($this->atLeast(1))
            ->method('sendAsync')
            ->withConsecutive(
                [
                    $this->isInstanceOf(RequestInterface::class),
                    [
                        'synchronous' => true,
                        'timeout' => 100,
                        'connect_timeout' => 100,
                    ],
                ],
                [
                    $this->isInstanceOf(RequestInterface::class),
                    [
                        'synchronous' => false,
                        'timeout' => 30,
                        'connect_timeout' => 30,
                    ],
                ],
                [
                    $this->isInstanceOf(RequestInterface::class),
                    [
                        'synchronous' => true,
                        'timeout' => 3,
                        'connect_timeout' => 3,
                    ],
                ]
            )
            ->will($this->returnValue($mockPromise));

        $this->httpClient->setClient($guzzleClient);

        $this->mockHttpClient = $this->getMockBuilder('TheIconic\Tracking\GoogleAnalytics\Network\HttpClient')
            ->setMethods(['getAnalyticsResponse'])
            ->getMock();

        $this->mockHttpClient->expects($this->atLeast(1))
            ->method('getAnalyticsResponse')
            ->will($this->returnArgument(1));

        $this->mockHttpClient->setClient($guzzleClient);

        $response = $this->mockHttpClient->post('http://test-collector.com/collect?v=1');
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $response);

        $responseAsync = $this->mockHttpClient->post(
            'http://test-collector.com/collect?v=1',
            ['async' => true, 'timeout' => 30]
        );
        $this->assertInstanceOf('GuzzleHttp\Promise\PromiseInterface', $responseAsync);

        $response = $this->httpClient->post('http://test-collector.com/collect?v=1', ['timeout' => 3]);

        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse', $response);

        $response = $this->httpClient->batch('http://test-collector.com/collect?v=1', [], ['timeout' => 3]);

        $this->assertInstanceOf('TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse', $response);

        // Promises should be unwrapped on the object destruction
        $this->httpClient = null;
        $this->mockHttpClient = null;
    }
}
