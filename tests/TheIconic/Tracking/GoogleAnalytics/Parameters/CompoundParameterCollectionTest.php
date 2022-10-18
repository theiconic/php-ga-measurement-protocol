<?php

namespace TheIconic\Tracking\GoogleAnalytics\Parameters;

use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundParameterTestCollection;
use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\InvalidCompoundParameterTestCollection;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidNameException;
use PHPUnit\Framework\TestCase;

class CompoundParameterCollectionTest extends TestCase
{
    /**
     *
     * @var CompoundParameterCollection;
     */
    protected $testCollection;

    public function setUp(): void
    {
        $this->testCollection = new CompoundParameterTestCollection(7);
    }

    public function testInvalidCompoundParameterCollection()
    {
        $this->expectException(InvalidNameException::class);
        (new InvalidCompoundParameterTestCollection());
    }

    public function testAddItem()
    {
        $item = new CompoundTestParameter(['sku' => 555, 'name' => 'yey']);

        $this->testCollection->add($item);

        foreach ($this->testCollection as $compoundParameter) {
            $expect = [
                'id' => 555,
                'nm' => 'yey',
            ];

            $this->assertEquals($expect, $compoundParameter->getParameters());
        }

        $item = new CompoundTestParameter(['sku' => 777, 'name' => 'cathy']);

        $this->testCollection->add($item);

        $parameters = $this->testCollection->getParametersArray();

        $expect = [
            'cp7t1id' => 555,
            'cp7t1nm' => 'yey',
            'cp7t2id' => 777,
            'cp7t2nm' => 'cathy',
        ];

        $this->assertEquals($expect, $parameters);
    }
}
