<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidCompoundParameterException;

/**
 * Class CompoundParameter
 *
 * @package TheIconic\Tracking\GoogleAnalytics\Parameters
 */
abstract class CompoundParameter
{
    /**
     * @var array
     */
    protected $parameterNameMapper = [];

    /**
     * @var array
     */
    protected $requiredParameters = [];

    /**
     * @var array
     */
    protected $parameters = [];


    public function __construct(array $compoundData)
    {
        foreach ($this->requiredParameters as $requiredParameter) {
            if (!array_key_exists($requiredParameter, $compoundData)) {
                throw new InvalidCompoundParameterException(
                    $requiredParameter . ' is required for ' . get_class($this)
                );
            }
        }

        $this->saveCompoundParameterData($compoundData);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $compoundData
     * @throws \InvalidArgumentException
     */
    protected function saveCompoundParameterData(array $compoundData)
    {
        foreach ($compoundData as $name => $value) {
            $matchExists = false;
            foreach ($this->parameterNameMapper as $regex => $parameterName) {
                if (preg_match($regex, $name, $matches) === 1) {
                    $parameterLastIndex = '';

                    if (isset($matches[1])) {
                        $parameterLastIndex = $matches[1];
                    }

                    $matchExists = true;
                    $this->parameters[$parameterName . $parameterLastIndex] = $value;

                    break;
                }
            }

            if (!$matchExists) {
                throw new \InvalidArgumentException("Unknown parameter $name for " . get_class($this) . ' data');
            }
        }
    }
}
