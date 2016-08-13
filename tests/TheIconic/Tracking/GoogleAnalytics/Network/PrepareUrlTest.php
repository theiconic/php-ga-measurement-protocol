<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use TheIconic\Tracking\GoogleAnalytics\Network\PrepareUrl;
use TheIconic\Tracking\GoogleAnalytics\Parameters\General\CacheBuster;
use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundParameterTestCollection;
use TheIconic\Tracking\GoogleAnalytics\Tests\CompoundTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameter;
use TheIconic\Tracking\GoogleAnalytics\Tests\SingleTestParameterIndexed;

class PrepareUrlTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $prepareUrl = new PrepareUrl;

        $singleParameter = new SingleTestParameter();
        $singleParameter->setValue('foo');
        $singleParameterIdx = new SingleTestParameterIndexed(4);
        $singleParameterIdx->setValue(9);
        $cacheBuster = new CacheBuster();
        $cacheBuster->setValue('123');
        $singles = [$singleParameter, $cacheBuster, $singleParameterIdx];

        $compoundCollection = new CompoundParameterTestCollection(6);
        $compoundParameter = new CompoundTestParameter(['sku' => 555, 'name' => 'cathy']);
        $compoundCollection->add($compoundParameter);
        $compoundParameter2 = new CompoundTestParameter(['sku' => 666, 'name' => 'isa']);
        $compoundCollection->add($compoundParameter2);
        $compounds = [$compoundCollection];

        $url = $prepareUrl->build('http://test-collector.com', $singles, $compounds);

        $payload = $prepareUrl->getPayloadParameters();

        $expect = [
            'test' => 'foo',
            'testi4' => 9,
            'cp6t1id' => 555,
            'cp6t1nm' => 'cathy',
            'cp6t2id' => 666,
            'cp6t2nm' => 'isa',
            'z' => '123'
        ];

        $this->assertEquals($expect, $payload);

        // assets cache buster is last element
        $count = 1;
        foreach ($payload as $key => $value) {
            if ($count === 7) {
                $this->assertEquals('z', $key);
                $this->assertEquals('123', $value);
            }

            $count++;
        }
    }

}