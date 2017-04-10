<?php

namespace TheIconic\Tracking\GoogleAnalytics;

/**
 * Represents the null-response object
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class NullAnalyticsResponse implements AnalyticsResponseInterface
{
    /**
     * It returns NULL as it is null-object.
     *
     * @api
     * @return null
     */
    public function getHttpStatusCode()
    {
        return null;
    }

    /**
     * It returns NULL as it is null-object.
     *
     * @api
     * @return string
     */
    public function getRequestUrl()
    {
        return '';
    }

    /**
     * Returns empty array as it is null-object.
     *
     * @api
     * @return array
     */
    public function getDebugResponse()
    {
        return [];
    }
}
