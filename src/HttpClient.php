<?php

namespace JorgeBorges\Google\Analytics;

use GuzzleHttp\Client;

class HttpClient
{
    private $client;

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if ($this->client === null) {
            // @codeCoverageIgnoreStart
            $this->setClient(new Client());
        }
        // @codeCoverageIgnoreEnd

        return $this->client;
    }

    public function post($url, $parameters)
    {
        $respose = $this->getClient()->post($url, ['body' => $this->getPostBody($parameters)]);

        return $respose->getStatusCode();
    }

    private function getPostBody($parameters)
    {
        $postData = [];

        foreach ($parameters as $parameterObj) {
            $postData[$parameterObj->getName()] = $parameterObj->getValue();
        }

        return $postData;
    }
}
