<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameterIndexed;
use TheIconic\Tracking\GoogleAnalytics\Tests\InvalidSingleTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidNameException;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidIndexException;
use PHPUnit\Framework\TestCase;

class SingleParameterTest extends TestCase
{
    /**
     * @var SingleParameter
     */
    private $stubSingleParameter;

    /**
     * @var SingleParameter
     */
    private $stubSingleParameterIndexed;

    public function setUp(): void
    {
        $this->stubSingleParameter = new SingleTestParameter();
        $this->stubSingleParameterIndexed = new SingleTestParameterIndexed(2);
    }

    public function testInvalidSingleParameter()
    {
        $this->expectException(InvalidNameException::class);
        (new InvalidSingleTestParameter);
    }

    public function testInvalidSingleParameterIndexed()
    {
        $this->expectException(InvalidIndexException::class);
        (new SingleTestParameterIndexed());
    }

    public function testGetName()
    {
        $this->assertEquals('test', $this->stubSingleParameter->getName());
    }

    public function testGetNameIndexed()
    {
        $this->assertEquals('testi2', $this->stubSingleParameterIndexed->getName());
    }

    public function testValue()
    {
        $this->stubSingleParameter->setValue(10);

        $this->assertEquals(10, $this->stubSingleParameter->getValue());
    }
}
