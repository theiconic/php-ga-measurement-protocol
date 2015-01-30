<?php

namespace TheIconic\Tracking\GoogleAnalytics\Traits;

use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidIndexException;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidNameException;

/**
 * Class Indexable
 *
 * Contains logic for indexing a parameter string with a valid placeholder.
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Traits
 */
trait Indexable
{
    /**
     * Placeholder for the index.
     */
    private $indexPlaceholder = ':i:';

    /**
     * Maximum value index can take in GA.
     * @var int
     */
    private $maxIndex = 200;

    /**
     * Minimum value index can take in GA.
     * @var int
     */
    private $minIndex = 1;

    /**
     * Replaces a placeholder for the index passed.
     *
     * @param string $string
     * @param int $index
     * @return string
     * @throws \TheIconic\Tracking\GoogleAnalytics\Exception\InvalidIndexException
     * @throws \TheIconic\Tracking\GoogleAnalytics\Exception\InvalidNameException
     */
    protected function addIndex($string, $index)
    {
        if (empty($string)) {
            throw new InvalidNameException('Name attribute not defined for class ' . get_class($this));
        }

        if (strpos($string, $this->indexPlaceholder) !== false) {
            if (!is_numeric($index) || $index < $this->minIndex || $index > $this->maxIndex) {
                throw new InvalidIndexException(
                    'When setting parameter ' . get_class($this)
                    . ' a numeric index between 1 - 200 must be passed for the second argument'
                );
            }
        }

        return str_replace($this->indexPlaceholder, $index, $string);
    }
}
