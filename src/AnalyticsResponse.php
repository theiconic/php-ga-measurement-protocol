<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AnalyticsResponse
 *
 * Represents the response got from GA.
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class AnalyticsResponse implements AnalyticsResponseInterface
{
    /**
     * HTTP status code for the response.
     *
     * @var null|int
     */
    protected $httpStatusCode;

    /**
     * Request URI that was used to send the hit.
     *
     * @var string
     */
    protected $requestUrl;

    /**
     * Response body.
     *
     * @var string
     */
    protected $responseBody;

    /**
     * Gets the relevant data from the Guzzle clients.
     *
     * @param RequestInterface $request
     * @param ResponseInterface|Promise $response
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __construct(RequestInterface $request, $response)
    {
        if ($response instanceof ResponseInterface) {
            $this->httpStatusCode = $response->getStatusCode();
            $this->responseBody = (string) $response->getBody();
        } elseif ($response instanceof Promise) {
            $this->httpStatusCode = null;
            $this->responseBody = null;
        } else {
            throw new \InvalidArgumentException(
                sprintf(
                    'Second constructor argument "response" must be instance of %s or %s',
                    RequestInterface::class,
                    Promise::class
                )
            );
        }

        $this->requestUrl = (string) $request->getUri();
    }

    /**
     * Gets the HTTP status code.
     * It return NULL if the request was asynchronous since we are not waiting for the response.
     *
     * @api
     * @return null|int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the request URI used to get the response.
     *
     * @api
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * Gets the debug response. Returns empty array if no response found.
     *
     * @api
     * @return array
     */
    public function getDebugResponse()
    {
        $debugResponse = [];

        if (!empty($this->responseBody)) {
            $debugResponse = json_decode($this->responseBody, true);
            $debugResponse = (is_array($debugResponse)) ? $debugResponse : [];
        }

        return $debugResponse;
    }
}
