<?php

namespace JorgeBorges\Google\Analytics\Parameters;

abstract class AbstractParameter
{
    protected $name = '';

    protected $value = null;

    public function __construct()
    {
        if (empty($this->name)) {
            throw new \Exception('For parameter classes $name member variable cannot be empty');
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
