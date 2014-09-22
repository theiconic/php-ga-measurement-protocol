<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use IteratorAggregate;
use Countable;

abstract class CompoundParameterCollection implements IteratorAggregate, Countable
{
    protected $collectionPrefix = '';

    protected $items = [];

    public function add(CompoundParameter $compoundParameter)
    {
        $this->items[] = $compoundParameter;
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

    /**
     * Returns the number of compound parameters in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
