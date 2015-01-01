<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class AnalyticsResponse
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class AnalyticsResponse
{
    /**
     * @var string
     */
    protected $httpStatusCode;

    /**
     * @var string
     */
    protected $requestUrl;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->httpStatusCode = $response->getStatusCode();

        $this->requestUrl = $request->getUrl();
    }

    /**
     * @return string
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }
}
