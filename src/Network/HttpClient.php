<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use Http\Client\HttpAsyncClient;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse;

/**
 * Class HttpClient
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class HttpClient
{
    /**
     * User agent for the client.
     */
    const PHP_GA_MEASUREMENT_PROTOCOL_USER_AGENT =
        'THE ICONIC GA Measurement Protocol PHP Client (https://github.com/theiconic/php-ga-measurement-protocol)';

    /**
     * HTTP client.
     *
     * @var HttpAsyncClient
     */
    private $client;

    /**
     * HTTP request factory.
     *
     * @var RequestFactory
     */
    private $requestFactory = null;

    /**
     * Holds the promises (async responses).
     *
     * @var Promise[]
     */
    private static $promises = [];

    /**
     * Sets HTTP client.
     *
     * @internal
     * @param HttpAsyncClient $client
     */
    public function setClient(HttpAsyncClient $client)
    {
        $this->client = $client;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return HttpAsyncClient
     *
     * @throws \Http\Discovery\Exception\NotFoundException
     */
    private function getClient()
    {
        if ($this->client === null) {
            // @codeCoverageIgnoreStart
            $this->setClient(HttpAsyncClientDiscovery::find());
        }
        // @codeCoverageIgnoreEnd

        return $this->client;
    }

    /**
     * Sets HTTP request factory.
     *
     * @param RequestFactory $factory
     *
     * @internal
     */
    public function setRequestFactory(RequestFactory $factory)
    {
        $this->requestFactory = $factory;
    }

    /**
     * Gets HTTP request factory for internal class use.
     *
     * @return RequestFactory
     *
     * @throws \Http\Discovery\Exception\NotFoundException
     */
    private function getRequestFactory()
    {
        if (null === $this->requestFactory) {
            $this->setRequestFactory(MessageFactoryDiscovery::find());
        }

        return $this->requestFactory;
    }

    /**
     * Sends request to Google Analytics.
     *
     * @internal
     * @param string $url
     * @param boolean $nonBlocking
     * @return AnalyticsResponse
     *
     * @throws \Exception If processing the request is impossible (eg. bad configuration).
     * @throws \Http\Discovery\Exception\NotFoundException
     */
    public function post($url, $nonBlocking = false)
    {
        $request = $this->getRequestFactory()->createRequest(
            'GET',
            $url,
            ['User-Agent' => self::PHP_GA_MEASUREMENT_PROTOCOL_USER_AGENT]
        );

        $response = $this->getClient()->sendAsyncRequest($request);

        if ($nonBlocking) {
            self::$promises[] = $response;
        } else {
            $response = $response->wait();
        }

        return $this->getAnalyticsResponse($request, $response);
    }

    /**
     * Creates an analytics response object.
     *
     * @param RequestInterface $request
     * @param ResponseInterface|Promise $response
     * @return AnalyticsResponse
     */
    protected function getAnalyticsResponse(RequestInterface $request, $response)
    {
        return new AnalyticsResponse($request, $response);
    }
}
