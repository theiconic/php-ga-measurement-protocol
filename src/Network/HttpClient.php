<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * Timeout in seconds for the request connection and actual request execution.
     * Using the same value you can find in Google's PHP Client.
     */
    const REQUEST_TIMEOUT_SECONDS = 100;

    /**
     * HTTP client.
     *
     * @var Client
     */
    private $client;

    /**
     * Holds the promises (async responses).
     *
     * @var PromiseInterface[]
     */
    private static $promises = [];

    /**
     * We have to unwrap and send all promises at the end before analytics objects is destroyed.
     */
    public function __destruct()
    {
        Promise\unwrap(self::$promises);
    }

    /**
     * Sets HTTP client.
     *
     * @internal
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return Client
     */
    private function getClient()
    {
        if ($this->client === null) {
            // @codeCoverageIgnoreStart
            $this->setClient(new Client());
        }
        // @codeCoverageIgnoreEnd

        return $this->client;
    }

    /**
     * Sends request to Google Analytics.
     *
     * @internal
     * @param string $url
     * @param array $options
     * @return AnalyticsResponse
     */
    public function post($url, array $options = [])
    {
        $request = new Request(
            'GET',
            $url,
            ['User-Agent' => self::PHP_GA_MEASUREMENT_PROTOCOL_USER_AGENT]
        );

        return $this->sendRequest($request, $options);
    }

    /**
     * Sends batch request to Google Analytics.
     *
     * @internal
     * @param string $url
     * @param array $batchUrls
     * @param array $options
     * @return AnalyticsResponse
     */
    public function batch($url, array $batchUrls, array $options = [])
    {
        $body = implode(PHP_EOL, $batchUrls);

        $request = new Request(
            'POST',
            $url,
            ['User-Agent' => self::PHP_GA_MEASUREMENT_PROTOCOL_USER_AGENT],
            $body
        );

        return $this->sendRequest($request, $options);
    }

    private function sendRequest(Request $request, array $options = [])
    {
        $opts = $this->parseOptions($options);
        $response = $this->getClient()->sendAsync($request, [
            'synchronous' => !$opts['async'],
            'timeout' => $opts['timeout'],
            'connect_timeout' => $opts['timeout'],
        ]);

        if ($opts['async']) {
            self::$promises[] = $response;
        } else {
            $response = $response->wait();
        }

        return $this->getAnalyticsResponse($request, $response);
    }

    /**
     * Parse the given options and fill missing fields with default values.
     *
     * @param array $options
     * @return array
     */
    private function parseOptions(array $options)
    {
        $defaultOptions = [
            'timeout' => static::REQUEST_TIMEOUT_SECONDS,
            'async' => false,
        ];

        $opts = [];
        foreach ($defaultOptions as $option => $value) {
            $opts[$option] = isset($options[$option]) ? $options[$option] : $defaultOptions[$option];
        }

        if (!is_int($opts['timeout']) || $opts['timeout'] <= 0) {
            throw new \UnexpectedValueException('The timeout must be an integer with a value greater than 0');
        }

        if (!is_bool($opts['async'])) {
            throw new \UnexpectedValueException('The async option must be boolean');
        }

        return $opts;
    }

    /**
     * Creates an analytics response object.
     *
     * @param RequestInterface $request
     * @param ResponseInterface|PromiseInterface $response
     * @return AnalyticsResponse
     */
    protected function getAnalyticsResponse(RequestInterface $request, $response)
    {
        return new AnalyticsResponse($request, $response);
    }
}
