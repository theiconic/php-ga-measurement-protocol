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
     * Minimum value index can take in GA.
     *
     * @return int
     */
    protected function minIndex(): int
    {
        return 1;
    }

    /**
     * Maximum value index can take in GA.
     *
     * @return int
     */
    protected function maxIndex(): int
    {
        return 200;
    }

    /**
     * Replaces a placeholder for the index passed.
     *
     * @param string $string
     * @param string $index
     * @return string
     * @throws InvalidIndexException
     * @throws InvalidNameException
     */
    protected function addIndex(string $string, string $index): string
    {
        if (empty($string)) {
            throw new InvalidNameException('Name attribute not defined for class ' . get_class($this));
        }

        if (strpos($string, $this->indexPlaceholder) !== false) {
            if (!is_numeric($index) || $index < $this->minIndex() || $index > $this->maxIndex()) {
                throw new InvalidIndexException(
                    'When setting parameter ' . get_class($this)
                    . ' a numeric index between 1 - 200 must be passed for the second argument'
                );
            }
        }

        return str_replace($this->indexPlaceholder, $index, $string);
    }
}
