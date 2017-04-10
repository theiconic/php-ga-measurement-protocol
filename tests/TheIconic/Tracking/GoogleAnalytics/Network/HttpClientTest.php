<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use Http\Mock\Client;
use TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    public function testPost()
    {
        $client = new HttpClient();

        $mockClient = new Client();

        $client->setClient($mockClient);

        $response = $client->post('http://example.com/foo');
        static::assertInstanceOf(AnalyticsResponse::class, $response);
        static::assertEquals('http://example.com/foo', $response->getRequestUrl());

        $response = $client->post('http://example.com/bar', true);
        static::assertInstanceOf(AnalyticsResponse::class, $response);
        static::assertEquals('http://example.com/bar', $response->getRequestUrl());
    }
}
