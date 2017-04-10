<?php

namespace TheIconic\Tracking\GoogleAnalytics;

/**
 * Interface AnalyticsResponseInterface
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
interface AnalyticsResponseInterface
{
    /**
     * Gets the HTTP status code.
     *
     * @api
     * @return null|int
     */
    public function getHttpStatusCode();

    /**
     * Gets the request URI used to get the response.
     *
     * @api
     * @return string
     */
    public function getRequestUrl();

    /**
     * Gets the debug response.
     *
     * @api
     * @return array
     */
    public function getDebugResponse();
}
