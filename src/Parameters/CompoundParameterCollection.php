<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Traits\Indexable;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidCompoundParameterException;
use IteratorAggregate;

abstract class CompoundParameterCollection implements IteratorAggregate
{
    use Indexable;

    protected $collectionPrefix = '';

    protected $items = [];

    public function __construct($index = '')
    {
        if (empty($this->collectionPrefix)) {
            throw new InvalidCompoundParameterException(
                'Collection prefix attribute not defined for class ' . get_class($this)
            );
        }

        $this->collectionPrefix = $this->addIndex($this->collectionPrefix, $index);
    }

    public function add(CompoundParameter $compoundParameter)
    {
        $this->items[] = $compoundParameter;
    }

    public function getParametersArray()
    {
        $parameters = [];

        foreach ($this as $number => $compoundParameter) {
            $currentParameters = [];

            foreach ($compoundParameter->getParameters() as $name => $value) {
                $currentParameters[$this->collectionPrefix . ($number + 1) . $name] = $value;
            }

            $parameters = array_merge($parameters, $currentParameters);
        }

        return $parameters;
    }

    /**
     * Returns the iterable array.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}
