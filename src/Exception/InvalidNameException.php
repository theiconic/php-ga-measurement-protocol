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
class InvalidNameException extends \Exception
{
}
