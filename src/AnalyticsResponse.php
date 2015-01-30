<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class AnalyticsResponse
 *
 * Represents the response got from GA.
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class AnalyticsResponse
{
    /**
     * HTTP status code for the response.
     *
     * @var string
     */
    protected $httpStatusCode;

    /**
     * Request URI that was used to send the hit.
     *
     * @var string
     */
    protected $requestUrl;

    /**
     * Gets the relevant data from the Guzzle clients.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->httpStatusCode = $response->getStatusCode();

        $this->requestUrl = $request->getUrl();
    }

    /**
     * Gets the HTTP status code.
     *
     * @return string
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the request URI used to get the response.
     *
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }
}
