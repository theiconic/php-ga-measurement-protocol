<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use TheIconic\Tracking\GoogleAnalytics\Parameters\Hit\HitType;

use Symfony\Component\Finder\Finder;

/**
 * Class Analytics
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProtocolVersion($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTrackingId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setClientId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentPath($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentHostName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTransactionId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setAffiliation($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setRevenue($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTax($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setShipping($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCouponCode($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setHitType($value)
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class Analytics
{
    private $protocol = 'http';

    private $endpoint = '://www.google-analytics.com/collect';

    private $parameters = [];

    private $availableParameters;

    private $httpClient;

    public function __construct($isSsl = false)
    {
        if (!is_bool($isSsl)) {
            throw new \Exception('First constructor argument "isSSL" must be boolean');
        }

        if ($isSsl) {
            $this->protocol .= 's';
        }

        $this->availableParameters = $this->getAvailableParameters();
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return HttpClient
     */
    private function getHttpClient()
    {
        if ($this->httpClient === null) {
            // @codeCoverageIgnoreStart
            $this->setHttpClient(new HttpClient());
        }
        // @codeCoverageIgnoreEnd

        return $this->httpClient;
    }

    private function getAvailableParameters()
    {
        $parameterClassNames = [];

        $finder = new Finder();

        $finder->files()->in(__DIR__ . '/Parameters');

        foreach ($finder as $file) {
            $categorisedParameter = str_replace(
                ['.php', '/'],
                ['', '\\'],
                $file->getRelativePathname()
            );
            $categorisedParameterArray = explode('\\', $categorisedParameter);

            $validCategorisedParameterCount = 2;
            if (count($categorisedParameterArray) >= $validCategorisedParameterCount) {
                $parameterClassNames[$categorisedParameterArray[1]] = $categorisedParameter;
            }
        }

        return $parameterClassNames;
    }

    private function getEndpoint()
    {
        return $this->protocol . $this->endpoint;
    }

    public function sendPageview()
    {
        $this->setHitType(HitType::HIT_TYPE_PAGEVIEW);

        return $this->getHttpClient()->post($this->getEndpoint(), $this->parameters);
    }

    public function __call($methodName, array $methodArguments)
    {
        if (preg_match('/(set)(\w+)/', $methodName, $matches)) {

            $parameterClass = substr($methodName, 3);

            $fullParameterClass =
                '\\TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\' . $this->availableParameters[$parameterClass];

            $parameterObject = new $fullParameterClass();

            $parameterObject->setValue($methodArguments[0]);

            $this->parameters[$parameterObject->getName()] = $parameterObject;

            return $this;
        }
    }
}
