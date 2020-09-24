<?php

namespace TheIconic\Tracking\GoogleAnalytics\Network;

use TheIconic\Tracking\GoogleAnalytics\Parameters\General\CacheBuster;
use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;
use TheIconic\Tracking\GoogleAnalytics\Parameters\CompoundParameterCollection;

/**
 * Class PrepareUrl
 *
 * Builds the URL.
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class PrepareUrl
{
    /**
     * @var array
     */
    private $payloadParameters;

    /**
     * @var string
     */
    private $cacheBuster = '';

    /**
     * Build URL which is sent to Google Analytics
     *
     * @internal
     * @param string $url
     * @param SingleParameter[] $singleParameters
     * @param CompoundParameterCollection[] $compoundParameters
     * @return string
     */
    public function build($url, array $singleParameters, array $compoundParameters, $onlyQuery = false)
    {
        $singlesPost = $this->getSingleParametersPayload($singleParameters);

        $compoundsPost = $this->getCompoundParametersPayload($compoundParameters);

        $this->payloadParameters = array_merge($singlesPost, $compoundsPost);

        if (!empty($this->cacheBuster)) {
            $this->payloadParameters['z'] = $this->cacheBuster;
        }
        $query = http_build_query($this->payloadParameters, null, ini_get('arg_separator.output'), PHP_QUERY_RFC3986);
        return $onlyQuery ? $query : ($url . '?' . $query);
    }

    /**
     * @internal
     * @return array
     */
    public function getPayloadParameters()
    {
        return $this->payloadParameters;
    }

    /**
     * Prepares all the Single Parameters to be sent to GA.
     *
     * @param SingleParameter[] $singleParameters
     * @return array
     */
    private function getSingleParametersPayload(array $singleParameters)
    {
        $postData = [];
        $cacheBuster = new CacheBuster();

        foreach ($singleParameters as $parameterObj) {
            if ($parameterObj->getName() === $cacheBuster->getName()) {
                $this->cacheBuster = $parameterObj->getValue();
                continue;
            }

            $postData[$parameterObj->getName()] = $parameterObj->getValue();
        }

        return $postData;
    }

    /**
     * Prepares compound parameters inside collections to be sent to GA.
     *
     * @param CompoundParameterCollection[] $compoundParameters
     * @return array
     */
    private function getCompoundParametersPayload(array $compoundParameters)
    {
        $postData = [];

        foreach ($compoundParameters as $compoundCollection) {
            $parameterArray = $compoundCollection->getParametersArray();
            $postData = array_merge($postData, $parameterArray);
        }

        return $postData;
    }
}
