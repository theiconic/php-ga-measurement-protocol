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
     * Indicates if a single parameter has index (Eg. cm1, cm2, ... etc)
     *
     * @var bool
     */
    protected $isIndexed = false;

    /**
     * Constructor. Validates that the child class has declared a non empty name for the parameter
     * and valid index for indexed parameters.
     *
     * @throws InvalidSingleParameterException
     *
     * @param int $index
     */
    public function __construct($index = null)
    {
        if (empty($this->name)) {
            throw new InvalidSingleParameterException('Name attribute not defined for class ' . get_class($this));
        }

        if ($this->isIndexed && strpos($this->name, self::INDEX_PLACEHOLDER) === false) {
            throw new InvalidSingleParameterException(
                'Parameter class ' . get_class($this)  . ' is indexed, you must specify where the index goes with '
                . self::INDEX_PLACEHOLDER
            );
        }

        if ($this->isIndexed && $index === null) {
            throw new InvalidSingleParameterException(
                'Parameter class ' . get_class($this)  . ' is indexed, pass index in second argument when setting value'
            );
        }

        if ($index !== null) {
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
