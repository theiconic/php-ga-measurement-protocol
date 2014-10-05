<?php

namespace TheIconic\Tracking\GoogleAnalytics\Exception;

/**
 * Class InvalidSingleParameterException
 *
 * Thrown when an invalid single parameter is tried to be instantiated.
 * To be considered valid, a single parameter must have a name attribute.
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Exception
 */
class InvalidSingleParameterException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'For parameter classes $name member variable cannot be empty';
}
