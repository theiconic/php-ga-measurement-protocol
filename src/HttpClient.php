<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;
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

    public function post($url, array $singleParameters, array $compoundParameters)
    {
        $singlesPost = $this->getSingleParametersPostBody($singleParameters);

        $compoundsPost = $this->getCompoundParametersPostBody($compoundParameters);

        $finalParameters = array_merge($singlesPost, $compoundsPost);

        $respose = $this->getClient()->post($url, ['body' => $finalParameters]);

        return $respose->getStatusCode();
    }

    private function getSingleParametersPostBody(array $singleParameters)
    {
        $postData = [];

        /** @var SingleParameter $parameterObj */
        foreach ($singleParameters as $parameterObj) {
            $postData[$parameterObj->getName()] = $parameterObj->getValue();
        }

        return $postData;
    }

    private function getCompoundParametersPostBody(array $compoundParameters)
    {
        $postData = [];

        foreach ($compoundParameters as $compoundCollection) {
            $parameterArray = $compoundCollection->getParametersArray();
            $postData = array_merge($postData, $parameterArray);
        }

        return $postData;
    }
}
