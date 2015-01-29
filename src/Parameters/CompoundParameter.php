<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

abstract class CompoundParameter
{
    protected $parameterNameMapper = [];

    protected $parameters = [];

    public function getParameters()
    {
        return $this->parameters;
    }

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
