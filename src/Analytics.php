<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;
use TheIconic\Tracking\GoogleAnalytics\Parameters\CompoundParameterCollection;
use TheIconic\Tracking\GoogleAnalytics\Network\HttpClient;
use Symfony\Component\Finder\Finder;

/**
 * Class Analytics
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProtocolVersion($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTrackingId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setAnonymizeIp($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setQueueTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCacheBuster($value)
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setClientId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserId($value)
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSessionControl($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setIpOverride($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserAgentOverride($value)
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentPath($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentHostName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTransactionId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setAffiliation($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setRevenue($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTax($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setShipping($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCouponCode($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics addProduct(array $productData)
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventCategory($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventAction($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventLabel($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventValue($value)
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToDetail()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToClick()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToAdd()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToRemove()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToCheckout()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToCheckoutOption()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToPurchase()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToRefund()
 *
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendPageview()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendEvent()
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class Analytics
{
    private $uriScheme = 'http';

    private $endpoint = '://www.google-analytics.com/collect';

    /**
     * @var SingleParameter[]
     */
    private $singleParameters = [];

    /**
     * @var  CompoundParameterCollection[]
     */
    private $compoundParametersCollections = [];

    private $availableParameters;

    private $httpClient;

    public function __construct($isSsl = false)
    {
        if (!is_bool($isSsl)) {
            throw new \InvalidArgumentException('First constructor argument "isSSL" must be boolean');
        }

        if ($isSsl) {
            $this->uriScheme .= 's';
        }

        $this->availableParameters = $this->getAvailableParameters();
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
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
        return $this->uriScheme . $this->endpoint;
    }

    private function sendHit($methodName)
    {
        $hitType = strtoupper(substr($methodName, 4));
        $actionConstant =
            constant("TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\Hit\\HitType::HIT_TYPE_$hitType");
        $this->setHitType($actionConstant);

        return $this->getHttpClient()->post(
            $this->getEndpoint(),
            $this->singleParameters,
            $this->compoundParametersCollections
        );
    }

    private function setProductActionTo($methodName)
    {
        $action = strtoupper(substr($methodName, 18));

        if (defined("TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\EnhancedEcommerce\\ProductAction::PRODUCT_ACTION_$action")) {
            $actionConstant =
                constant(
                    "TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\EnhancedEcommerce\\ProductAction::PRODUCT_ACTION_$action"
                );
        } else {
            throw new \BadMethodCallException('Product action ' . $action . ' does not exist, check spelling');
        }


        $this->setProductAction($actionConstant);

        return $this;
    }

    private function setParameter($methodName, array $methodArguments)
    {
        $parameterClass = substr($methodName, 3);

        if (empty($this->availableParameters[$parameterClass])) {
            throw new \BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
        } else {
            $fullParameterClass =
                '\\TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\' . $this->availableParameters[$parameterClass];
        }

        /** @var SingleParameter $parameterObject */
        $parameterObject = new $fullParameterClass();

        if (!isset($methodArguments[0])) {
            throw new \InvalidArgumentException('You must specify a value to be set for ' . $methodName);
        } else {
            $parameterObject->setValue($methodArguments[0]);
        }

        $this->singleParameters[$parameterObject->getName()] = $parameterObject;

        return $this;
    }

    private function addItem($methodName, array $methodArguments)
    {
        $parameterClass = substr($methodName, 3);

        if (empty($this->availableParameters[$parameterClass])) {
            throw new \BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
        } else {
            $fullParameterClass =
                '\\TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\' . $this->availableParameters[$parameterClass];
        }

        if (!isset($methodArguments[0])) {
            throw new \InvalidArgumentException(
                'You must specify a ' . $parameterClass . ' to be add for ' . $methodName
            );
        } else {
            $parameterObject = new $fullParameterClass($methodArguments[0]);
        }

        if (isset($this->compoundParametersCollections[$parameterClass])) {
            $this->compoundParametersCollections[$parameterClass]->add($parameterObject);
        } else {
            $fullParameterCollectionClass = $fullParameterClass . 'Collection';

            /** @var CompoundParameterCollection $parameterObjectCollection */
            $parameterObjectCollection = new $fullParameterCollectionClass();

            $parameterObjectCollection->add($parameterObject);

            $this->compoundParametersCollections[$parameterClass] = $parameterObjectCollection;
        }

        return $this;
    }

    public function __call($methodName, array $methodArguments)
    {
        if (preg_match('/^(send)(\w+)/', $methodName, $matches)) {
            return $this->sendHit($methodName);
        }

        if (preg_match('/^(setProductActionTo)(\w+)/', $methodName, $matches)) {
            return $this->setProductActionTo($methodName);
        }

        if (preg_match('/^(set)(\w+)/', $methodName, $matches)) {
            return $this->setParameter($methodName, $methodArguments);
        }

        if (preg_match('/^(add)(\w+)/', $methodName, $matches)) {
            return $this->addItem($methodName, $methodArguments);
        }

        throw new \BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
    }
}
