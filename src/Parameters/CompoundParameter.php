<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

abstract class CompoundParameter
{
    protected $parameterNameMapper = [];

    protected $parameters = [];

    protected function saveCompoundParameterData(array $productData)
    {
        foreach ($productData as $name => $value) {
            $matchExists = false;
            foreach ($this->parameterNameMapper as $regex => $parameterName) {
                if (preg_match($regex, $name) === 1) {
                    $matchExists = true;
                    $this->parameters[$parameterName] = $value;
                    break;
                }
            }

            if (!$matchExists) {
                throw new \InvalidArgumentException("Unknown parameter $name for " . get_class($this) . ' data');
            }
        }
    }
}
