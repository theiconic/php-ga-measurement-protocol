<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidSingleParameterException;

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
     * Placeholder for the index.
     */
    const INDEX_PLACEHOLDER = ':i:';

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
     * @throws InvalidSingleParameterException
     *
     * @param $index
     */
    public function __construct($index = '')
    {
        if (empty($this->name)) {
            throw new InvalidSingleParameterException('Name attribute not defined for class ' . get_class($this));
        }

        if (strpos($this->name, self::INDEX_PLACEHOLDER) !== false) {
            if ($index === '') {
                throw new InvalidSingleParameterException(
                    'Parameter class ' . get_class($this)
                    . ' is indexed, pass index in second argument when setting value'
                );
            }

            $this->name = str_replace(self::INDEX_PLACEHOLDER, $index, $this->name);
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
