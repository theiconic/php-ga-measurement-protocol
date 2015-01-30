<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Traits\Indexable;
use IteratorAggregate;

abstract class CompoundParameterCollection implements IteratorAggregate
{
    use Indexable;

    protected $name = '';

    protected $items = [];

    public function __construct($index = '')
    {
        $this->name = $this->addIndex($this->name, $index);
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
                $currentParameters[$this->name . ($number + 1) . $name] = $value;
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
