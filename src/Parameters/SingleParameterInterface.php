<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

/**
 * Interface SingleParameterInterface
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters
 */
interface SingleParameterInterface
{
    /**
     * Gets the name for the parameter.
     *
     * @internal
     * @return string
     */
    public function getName();

    /**
     * Sets a value for the parameter.
     *
     * @internal
     * @param $value
     * @return $this
     */
    public function setValue($value);

    /**
     * Gets the value for the parameter.
     *
     * @internal
     * @return mixed
     */
    public function getValue();
}
