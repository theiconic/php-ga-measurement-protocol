<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

/**
 * Class SingleParameter
 *
 * A parameter is composed of a name and a value.
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters
 */
abstract class SingleParameter
{
    /**
     * Name for a parameter in GA Measurement Protocol.
     * Gets send as the name for a query parameter in the HTTP request.
     *
     * @var string
     */
    protected $name = '';

    /**
     * Value for the parameter.
     *
     * @var mixed
     */
    protected $value = null;

    /**
     * Constructor. Validates that the child class has declared a non empty name for the parameter.
     */
    public function __construct()
    {
        if (empty($this->name)) {
            throw new \Exception('For parameter classes $name member variable cannot be empty');
        }
    }

    /**
     * Gets the name for the parameter.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a value for the parameter.
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Gets the value for the parameter.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
