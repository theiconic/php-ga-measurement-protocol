<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;
use TheIconic\Tracking\GoogleAnalytics\Parameters\CompoundParameterCollection;
use TheIconic\Tracking\GoogleAnalytics\Network\HttpClient;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidPayloadDataException;
use Symfony\Component\Finder\Finder;

/**
 * Class Analytics
 *
 * General
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProtocolVersion($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTrackingId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setAnonymizeIp($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setQueueTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCacheBuster($value)
 *
 * User
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setClientId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserId($value)
 *
 * Session
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSessionControl($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setIpOverride($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserAgentOverride($value)
 *
 * Traffic Sources
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentReferrer($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCampaignName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCampaignSource($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCampaignMedium($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCampaignKeyword($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCampaignContent($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCampaignId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setGoogleAdwordsId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setGoogleDisplayAdsId($value)
 *
 * System Info
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setScreenResolution($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setViewportSize($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentEncoding($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setScreenColors($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserLanguage($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setJavaEnabled($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setFlashVersion($value)
 *
 * Hit
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setHitType($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setNonInteractionHit($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendPageview()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendScreenview()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendTransaction()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendItem()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendSocial()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendException()
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendTiming()
 *
 * Content Information
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentLocationUrl($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentHostName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentPath($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDocumentTitle($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setScreenName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setLinkId($value)
 *
 * App Tracking
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setApplicationName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setApplicationId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setApplicationVersion($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setApplicationInstallerId($value)
 *
 * Event Tracking
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventCategory($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventAction($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventLabel($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setEventValue($value)
 *
 * E-commerce
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setItemName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setItemPrice($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setItemQuantity($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setItemCode($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setItemCategory($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCurrencyCode($value)
 *
 * Enhanced E-Commerce
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTransactionId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setAffiliation($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setRevenue($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTax($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setShipping($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCouponCode($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCheckoutStep($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCheckoutStepOption($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics addProduct(array $productData)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductAction($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToDetail()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToClick()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToAdd()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToRemove()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToCheckout()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToCheckoutOption()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToPurchase()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionToRefund()
 *
 * Social Interactions
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSocialNetwork($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSocialAction($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSocialActionTarget($value)
 *
 * Timing
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserTiminCategory($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserTimingVariableName($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserTimingTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserTimingLabel($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setPageLoadTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDnsTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setPageDownloadTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setRedirectResponseTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTcpConnectTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setServerResponseTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDomInteractiveTime($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setContentLoadTime($value)
 *
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

        $hitConstant = $this->getParameterClassConstant(
            'TheIconic\Tracking\GoogleAnalytics\Parameters\Hit\HitType::HIT_TYPE_' . $hitType,
            'Hit type ' . $hitType . ' is not defined, check spelling'
        );

        $this->setHitType($hitConstant);

        if (!$this->hasMinimumRequiredParameters()) {
            throw new InvalidPayloadDataException();
        }

        return $this->getHttpClient()->post(
            $this->getEndpoint(),
            $this->singleParameters,
            $this->compoundParametersCollections
        );
    }

    private function hasMinimumRequiredParameters()
    {
        $minimumRequiredParameters = [
            'v' => false,
            'tid' => false,
            'cid' => false,
            't' => false,
        ];

        foreach ($minimumRequiredParameters as $parameterName => $isParamPresent) {
            if (in_array($parameterName, array_keys($this->singleParameters))) {
                $minimumRequiredParameters[$parameterName] = true;
            }
        }

        return !in_array(false, $minimumRequiredParameters, true);
    }

    private function setProductActionTo($methodName)
    {
        $action = strtoupper(substr($methodName, 18));

        $actionConstant = $this->getParameterClassConstant(
            'TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\ProductAction::PRODUCT_ACTION_' . $action,
            'Product action ' . $action . ' does not exist, check spelling'
        );

        $this->setProductAction($actionConstant);

        return $this;
    }

    private function getParameterClassConstant($constant, $exceptionMsg)
    {
        if (defined($constant)) {
            return constant($constant);
        } else {
            throw new \BadMethodCallException($exceptionMsg);
        }
    }

    private function setParameter($methodName, array $methodArguments)
    {
        $parameterClass = substr($methodName, 3);

        $fullParameterClass = $this->getFullParameterClass($parameterClass, $methodName);

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

        $fullParameterClass = $this->getFullParameterClass($parameterClass, $methodName);

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

    private function getFullParameterClass($parameterClass, $methodName)
    {
        if (empty($this->availableParameters[$parameterClass])) {
            throw new \BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
        } else {
            return '\\TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\' . $this->availableParameters[$parameterClass];
        }
    }

    public function __call($methodName, array $methodArguments)
    {
        if (preg_match('/^(setProductActionTo)(\w+)/', $methodName, $matches)) {
            return $this->setProductActionTo($methodName);
        }

        if (preg_match('/^(set)(\w+)/', $methodName, $matches)) {
            return $this->setParameter($methodName, $methodArguments);
        }

        if (preg_match('/^(add)(\w+)/', $methodName, $matches)) {
            return $this->addItem($methodName, $methodArguments);
        }

        if (preg_match('/^(send)(\w+)/', $methodName, $matches)) {
            return $this->sendHit($methodName);
        }

        throw new \BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
    }
}
