<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Traits\Indexable;

/**
 * Class SingleParameter
 *
 * A parameter is composed of a name and a value.
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters
 */
abstract class SingleParameter
{
    use Indexable;

    /**
     * Name for a parameter in GA Measurement Protocol.
     * Its sent as the name for a query parameter in the HTTP request.
     *
     * @var string
     */
    protected $name = '';

    /**
     * Value for the parameter.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Constructor. Validates that the child class has declared a non empty name for the parameter
     * and valid index for indexed parameters.
     *
     * @param $index
     */
    public function __construct($index = '')
    {
        $this->name = $this->addIndex($this->name, $index);
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
