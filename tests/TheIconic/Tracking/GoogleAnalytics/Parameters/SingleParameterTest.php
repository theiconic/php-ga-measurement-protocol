<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\InvalidSingleTestParameter;

class SingleParameterTest extends \PHPUnit_Framework_TestCase
{
    private $mockSingleParameter;

    public function setUp()
    {
        $this->mockSingleParameter = new SingleTestParameter();
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
        $this->assertEquals('test', $this->mockSingleParameter->getName());
    }
}
