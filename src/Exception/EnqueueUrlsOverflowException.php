<?php

namespace TheIconic\Tracking\GoogleAnalytics\Exception;

/**
 * Class InvalidPayloadDataException
 *
 * Thrown when a hit is tried to be sent and the minimum requirements for parameters are not met.
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Exception
 */
class EnqueueUrlsOverflowException extends \OverflowException
{
    /**
     * @var string
     */
    protected $message = 'A maximum of 20 hits can be specified per request.';
}
