<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\InvalidSingleTestParameter;

class SingleParameterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SingleParameter
     */
    private $stubSingleParameter;

    public function setUp()
    {
        $this->stubSingleParameter = new SingleTestParameter();
    }

    /**
     * @expectedException \TheIconic\Tracking\GoogleAnalytics\Exception\InvalidSingleParameterException
     */
    public function testInvalidSingleParameter()
    {
        (new InvalidSingleTestParameter);
    }

    public function testGetName()
    {
        $this->assertEquals('test', $this->stubSingleParameter->getName());
    }

    public function testValue()
    {
        $this->stubSingleParameter->setValue(10);

        $this->assertEquals(10, $this->stubSingleParameter->getValue());
    }
}
