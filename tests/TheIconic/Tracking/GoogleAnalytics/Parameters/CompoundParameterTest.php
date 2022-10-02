<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidCompoundParameterException;
use PHPUnit\Framework\TestCase;

class CompoundParameterTest extends TestCase
{
    /**
     * @var CompoundParameter
     */
    private $compoundParameter;

    public function setUp(): void
    {
        $this->compoundParameter = new CompoundTestParameter(['sku' => 5, 'name' => 'hello', 'dimension_3' => 'yep']);
    }

    public function testCompoundParameter()
    {
        $expect = [
            'id' => 5,
            'nm' => 'hello',
            'd3' => 'yep',
        ];

        $this->assertEquals($expect, $this->compoundParameter->getParameters());
    }

    public function testRequiredCompundParameter()
    {
        $this->expectException(InvalidCompoundParameterException::class);
        (new CompoundTestParameter(['sku' => 5]));
    }

    public function testInvalidDataCompundParameter()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new CompoundTestParameter(['sku' => 5, 'name' => 'hello', 'dimensions_3' => 'yep']));
    }
}
