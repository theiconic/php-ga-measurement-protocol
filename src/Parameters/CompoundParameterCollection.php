<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use IteratorAggregate;

abstract class CompoundParameterCollection implements IteratorAggregate
{
    protected $collectionPrefix = '';

    protected $items = [];

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
