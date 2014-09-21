<?php

namespace JorgeBorges\Google\Analytics;

class AnalyticsTest extends \PHPUnit_Framework_TestCase
{
    public function testSimplePageview()
    {
        $analytics = new Analytics();

        $result = $analytics->setProtocolVersion('1')
            ->setTrackingId('UA-26293724-11')
            ->setClientId('555')
            ->setDocumentPath('/')
            ->sendPageview();

        $this->assertEquals('200', $result);
    }
}
