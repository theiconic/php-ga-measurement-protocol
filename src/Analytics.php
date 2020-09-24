<?php

namespace TheIconic\Tracking\GoogleAnalytics;

use BadMethodCallException;
use TheIconic\Tracking\GoogleAnalytics\Exception\EnqueueUrlsOverflowException;
use TheIconic\Tracking\GoogleAnalytics\Exception\InvalidPayloadDataException;
use TheIconic\Tracking\GoogleAnalytics\Network\HttpClient;
use TheIconic\Tracking\GoogleAnalytics\Network\PrepareUrl;
use TheIconic\Tracking\GoogleAnalytics\Parameters\CompoundParameterCollection;
use TheIconic\Tracking\GoogleAnalytics\Parameters\SingleParameter;

/**
 * Class Analytics
 *
 * The main interface for the clients, it relies heavily in magic methods exposing
 * an interface with method tags.
 *
 * ==== SETTERS ====
 * General
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProtocolVersion($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setTrackingId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setAnonymizeIp($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setDataSource($value)
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
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setGeographicalOverride($value)
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
 * @method \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse sendEvent()
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
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductActionList($value)
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
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setProductImpressionListName($value, $index)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics addProductImpression(array $productData, $index)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics addPromotion(array $promotionData)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setPromotionAction($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setPromotionActionToClick()
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setPromotionActionToView()
 *
 * Social Interactions
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSocialNetwork($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSocialAction($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setSocialActionTarget($value)
 *
 * Timing
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setUserTimingCategory($value)
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
 * Exceptions
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setExceptionDescription($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setIsExceptionFatal($value)
 *
 * Custom Dimension / Metrics
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCustomDimension($value, $index)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setCustomMetric($value, $index)
 *
 * Content Grouping
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setContentGroup($value, $index)
 *
 * Content Experiments
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setExperimentId($value)
 * @method \TheIconic\Tracking\GoogleAnalytics\Analytics setExperimentVariant($value)
 *
 * ==== GETTERS ====
 * General
 * @method string|int|null getProtocolVersion()
 * @method string|int|null getTrackingId()
 * @method string|int|null getAnonymizeIp()
 * @method string|int|null getDataSource()
 * @method string|int|null getQueueTime()
 * @method string|int|null getCacheBuster()
 *
 * User
 * @method string|int|null getClientId()
 * @method string|int|null getUserId()
 *
 * Session
 * @method string|int|null getSessionControl()
 * @method string|int|null getIpOverride()
 * @method string|int|null getUserAgentOverride()
 * @method string|int|null getGeographicalOverride()
 *
 * Traffic Sources
 * @method string|int|null getDocumentReferrer()
 * @method string|int|null getCampaignName()
 * @method string|int|null getCampaignSource()
 * @method string|int|null getCampaignMedium()
 * @method string|int|null getCampaignKeyword()
 * @method string|int|null getCampaignContent()
 * @method string|int|null getCampaignId()
 * @method string|int|null getGoogleAdwordsId()
 * @method string|int|null getGoogleDisplayAdsId()
 *
 * System Info
 * @method string|int|null getScreenResolution()
 * @method string|int|null getViewportSize()
 * @method string|int|null getDocumentEncoding()
 * @method string|int|null getScreenColors()
 * @method string|int|null getUserLanguage()
 * @method string|int|null getJavaEnabled()
 * @method string|int|null getFlashVersion()
 *
 * Hit
 * @method string|int|null getHitType()
 * @method string|int|null getNonInteractionHit()
 *
 * Content Information
 * @method string|int|null getDocumentLocationUrl()
 * @method string|int|null getDocumentHostName()
 * @method string|int|null getDocumentPath()
 * @method string|int|null getDocumentTitle()
 * @method string|int|null getScreenName()
 * @method string|int|null getLinkId()
 *
 * App Tracking
 * @method string|int|null getApplicationName()
 * @method string|int|null getApplicationId()
 * @method string|int|null getApplicationVersion()
 * @method string|int|null getApplicationInstallerId()
 *
 * Event Tracking
 * @method string|int|null getEventCategory()
 * @method string|int|null getEventAction()
 * @method string|int|null getEventLabel()
 * @method string|int|null getEventValue()
 *
 * E-commerce
 * @method string|int|null getItemName()
 * @method string|int|null getItemPrice()
 * @method string|int|null getItemQuantity()
 * @method string|int|null getItemCode()
 * @method string|int|null getItemCategory()
 * @method string|int|null getCurrencyCode()
 *
 * Enhanced E-Commerce
 * @method string|int|null getTransactionId()
 * @method string|int|null getAffiliation()
 * @method string|int|null getRevenue()
 * @method string|int|null getTax()
 * @method string|int|null getShipping()
 * @method string|int|null getCouponCode()
 * @method string|int|null getProductActionList()
 * @method string|int|null getCheckoutStep()
 * @method string|int|null getCheckoutStepOption()
 * @method string|int|null getProduct()
 * @method string|int|null getProductAction()
 * @method string|int|null getProductActionToDetail()
 * @method string|int|null getProductActionToClick()
 * @method string|int|null getProductActionToAdd()
 * @method string|int|null getProductActionToRemove()
 * @method string|int|null getProductActionToCheckout()
 * @method string|int|null getProductActionToCheckoutOption()
 * @method string|int|null getProductActionToPurchase()
 * @method string|int|null getProductActionToRefund()
 * @method string|int|null getProductImpressionListName($index)
 * @method string|int|null getProductImpression($listIndex)
 * @method string|int|null getPromotion()
 * @method string|int|null getPromotionAction()
 * @method string|int|null getPromotionActionToClick()
 * @method string|int|null getPromotionActionToView()
 *
 * Social Interactions
 * @method string|int|null getSocialNetwork()
 * @method string|int|null getSocialAction()
 * @method string|int|null getSocialActionTarget()
 *
 * Timing
 * @method string|int|null getUserTimingCategory()
 * @method string|int|null getUserTimingVariableName()
 * @method string|int|null getUserTimingTime()
 * @method string|int|null getUserTimingLabel()
 * @method string|int|null getPageLoadTime()
 * @method string|int|null getDnsTime()
 * @method string|int|null getPageDownloadTime()
 * @method string|int|null getRedirectResponseTime()
 * @method string|int|null getTcpConnectTime()
 * @method string|int|null getServerResponseTime()
 * @method string|int|null getDomInteractiveTime()
 * @method string|int|null getContentLoadTime()
 *
 * Exceptions
 * @method string|int|null getExceptionDescription()
 * @method string|int|null getIsExceptionFatal()
 *
 * Custom Dimension / Metrics
 * @method string|int|null getCustomDimension($index)
 * @method string|int|null getCustomMetric($index)
 *
 * Content Grouping
 * @method string|int|null getContentGroup($index)
 *
 * Content Experiments
 * @method string|int|null getExperimentId()
 * @method string|int|null getExperimentVariant()
 *
 * @package TheIconic\Tracking\GoogleAnalytics
 */
class Analytics
{
    /**
     * URI scheme for the GA API.
     *
     * @var string
     */
    protected $uriScheme = 'http';

    /**
     * Indicates if the request to GA will be asynchronous (non-blocking).
     *
     * @var boolean
     */
    protected $isAsyncRequest = false;

    /**
     * Endpoint to connect to when sending data to GA.
     *
     * @var string
     */
    protected $endpoint = '://www.google-analytics.com/collect';

    /**
     * Endpoint to connect to when validating hits.
     * @link https://developers.google.com/analytics/devguides/collection/protocol/v1/validating-hits
     *
     * @var string
     */
    protected $debugEndpoint = '://www.google-analytics.com/debug/collect';

    /**
     * Endpoint to connect to when sending batch data to GA.
     *
     * @var string
     */
    protected $batchEndpoint = '://www.google-analytics.com/batch';
     

    /**
     * Indicates if the request is in debug mode(validating hits).
     *
     * @var boolean
     */
    protected $isDebug = false;

    /**
     * Holds the single parameters added to the hit.
     *
     * @var SingleParameter[]
     */
    protected $singleParameters = [];

    /**
     * Holds the compound parameters collections added to the hit.
     *
     * @var  CompoundParameterCollection[]
     */
    protected $compoundParametersCollections = [];

    /**
     * Holds the HTTP client used to connect to GA.
     *
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Indicates if the request to GA will be executed (by default) or not.
     *
     * @var boolean
     */
    protected $isDisabled = false;

    /**
     * @var array
     */
    protected $enqueuedUrls = [];

    /**
     * @var array
     */
    protected $options = [];
    
    /**
     * Initializes to a list of all the available parameters to be sent in a hit.
     *
     * @var array
     */
    protected $availableParameters = [
        'ApplicationId' => 'AppTracking\\ApplicationId',
        'ApplicationInstallerId' => 'AppTracking\\ApplicationInstallerId',
        'ApplicationName' => 'AppTracking\\ApplicationName',
        'ApplicationVersion' => 'AppTracking\\ApplicationVersion',
        'ExperimentId' => 'ContentExperiments\\ExperimentId',
        'ExperimentVariant' => 'ContentExperiments\\ExperimentVariant',
        'ContentGroup' => 'ContentGrouping\\ContentGroup',
        'DocumentHostName' => 'ContentInformation\\DocumentHostName',
        'DocumentLocationUrl' => 'ContentInformation\\DocumentLocationUrl',
        'DocumentPath' => 'ContentInformation\\DocumentPath',
        'DocumentTitle' => 'ContentInformation\\DocumentTitle',
        'LinkId' => 'ContentInformation\\LinkId',
        'ScreenName' => 'ContentInformation\\ScreenName',
        'CustomDimension' => 'CustomDimensionsMetrics\\CustomDimension',
        'CustomMetric' => 'CustomDimensionsMetrics\\CustomMetric',
        'CurrencyCode' => 'Ecommerce\\CurrencyCode',
        'ItemCategory' => 'Ecommerce\\ItemCategory',
        'ItemCode' => 'Ecommerce\\ItemCode',
        'ItemName' => 'Ecommerce\\ItemName',
        'ItemPrice' => 'Ecommerce\\ItemPrice',
        'ItemQuantity' => 'Ecommerce\\ItemQuantity',
        'Affiliation' => 'EnhancedEcommerce\\Affiliation',
        'CheckoutStep' => 'EnhancedEcommerce\\CheckoutStep',
        'CheckoutStepOption' => 'EnhancedEcommerce\\CheckoutStepOption',
        'CouponCode' => 'EnhancedEcommerce\\CouponCode',
        'Product' => 'EnhancedEcommerce\\Product',
        'ProductAction' => 'EnhancedEcommerce\\ProductAction',
        'ProductActionList' => 'EnhancedEcommerce\\ProductActionList',
        'ProductCollection' => 'EnhancedEcommerce\\ProductCollection',
        'ProductImpression' => 'EnhancedEcommerce\\ProductImpression',
        'ProductImpressionCollection' => 'EnhancedEcommerce\\ProductImpressionCollection',
        'ProductImpressionListName' => 'EnhancedEcommerce\\ProductImpressionListName',
        'Promotion' => 'EnhancedEcommerce\\Promotion',
        'PromotionAction' => 'EnhancedEcommerce\\PromotionAction',
        'PromotionCollection' => 'EnhancedEcommerce\\PromotionCollection',
        'Revenue' => 'EnhancedEcommerce\\Revenue',
        'Shipping' => 'EnhancedEcommerce\\Shipping',
        'Tax' => 'EnhancedEcommerce\\Tax',
        'TransactionId' => 'EnhancedEcommerce\\TransactionId',
        'EventAction' => 'Event\\EventAction',
        'EventCategory' => 'Event\\EventCategory',
        'EventLabel' => 'Event\\EventLabel',
        'EventValue' => 'Event\\EventValue',
        'ExceptionDescription' => 'Exceptions\\ExceptionDescription',
        'IsExceptionFatal' => 'Exceptions\\IsExceptionFatal',
        'AnonymizeIp' => 'General\\AnonymizeIp',
        'CacheBuster' => 'General\\CacheBuster',
        'DataSource' => 'General\\DataSource',
        'ProtocolVersion' => 'General\\ProtocolVersion',
        'QueueTime' => 'General\\QueueTime',
        'TrackingId' => 'General\\TrackingId',
        'HitType' => 'Hit\\HitType',
        'NonInteractionHit' => 'Hit\\NonInteractionHit',
        'GeographicalOverride' => 'Session\\GeographicalOverride',
        'IpOverride' => 'Session\\IpOverride',
        'SessionControl' => 'Session\\SessionControl',
        'UserAgentOverride' => 'Session\\UserAgentOverride',
        'SocialAction' => 'SocialInteractions\\SocialAction',
        'SocialActionTarget' => 'SocialInteractions\\SocialActionTarget',
        'SocialNetwork' => 'SocialInteractions\\SocialNetwork',
        'DocumentEncoding' => 'SystemInfo\\DocumentEncoding',
        'FlashVersion' => 'SystemInfo\\FlashVersion',
        'JavaEnabled' => 'SystemInfo\\JavaEnabled',
        'ScreenColors' => 'SystemInfo\\ScreenColors',
        'ScreenResolution' => 'SystemInfo\\ScreenResolution',
        'UserLanguage' => 'SystemInfo\\UserLanguage',
        'ViewportSize' => 'SystemInfo\\ViewportSize',
        'ContentLoadTime' => 'Timing\\ContentLoadTime',
        'DnsTime' => 'Timing\\DnsTime',
        'DomInteractiveTime' => 'Timing\\DomInteractiveTime',
        'PageDownloadTime' => 'Timing\\PageDownloadTime',
        'PageLoadTime' => 'Timing\\PageLoadTime',
        'RedirectResponseTime' => 'Timing\\RedirectResponseTime',
        'ServerResponseTime' => 'Timing\\ServerResponseTime',
        'TcpConnectTime' => 'Timing\\TcpConnectTime',
        'UserTimingCategory' => 'Timing\\UserTimingCategory',
        'UserTimingLabel' => 'Timing\\UserTimingLabel',
        'UserTimingTime' => 'Timing\\UserTimingTime',
        'UserTimingVariableName' => 'Timing\\UserTimingVariableName',
        'CampaignContent' => 'TrafficSources\\CampaignContent',
        'CampaignId' => 'TrafficSources\\CampaignId',
        'CampaignKeyword' => 'TrafficSources\\CampaignKeyword',
        'CampaignMedium' => 'TrafficSources\\CampaignMedium',
        'CampaignName' => 'TrafficSources\\CampaignName',
        'CampaignSource' => 'TrafficSources\\CampaignSource',
        'DocumentReferrer' => 'TrafficSources\\DocumentReferrer',
        'GoogleAdwordsId' => 'TrafficSources\\GoogleAdwordsId',
        'GoogleDisplayAdsId' => 'TrafficSources\\GoogleDisplayAdsId',
        'ClientId' => 'User\\ClientId',
        'UserId' => 'User\\UserId',
    ];

    /**
     * When passed with an argument of TRUE, it will send the hit using HTTPS instead of plain HTTP.
     * It parses the available parameters.
     *
     * @param bool $isSsl
     * @param bool $isDisabled
     * @param array $options
     * @throws \InvalidArgumentException
     */
    public function __construct($isSsl = false, $isDisabled = false, array $options = [])
    {
        if (!is_bool($isSsl)) {
            throw new \InvalidArgumentException('First constructor argument "isSSL" must be boolean');
        }

        if (!is_bool($isDisabled)) {
            throw new \InvalidArgumentException('Second constructor argument "isDisabled" must be boolean');
        }

        if ($isSsl) {
            $this->uriScheme .= 's';
            $this->endpoint = str_replace('www', 'ssl', $this->endpoint);
        }

        $this->isDisabled = $isDisabled;
        $this->options = $options;
    }

    /**
     * Sets a request to be either synchronous or asynchronous (non-blocking).
     *
     * @api
     * @param boolean $isAsyncRequest
     * @return $this
     */
    public function setAsyncRequest($isAsyncRequest)
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Makes the request to GA asynchronous (non-blocking).
     *
     * @deprecated Use setAsyncRequest(boolean $isAsyncRequest) instead. To be removed in next major version.
     *
     * @return $this
     */
    public function makeNonBlocking()
    {
        $this->isAsyncRequest = true;

        return $this;
    }

    /**
     * Sets the HttpClient.
     *
     * @internal
     * @param HttpClient $httpClient
     * @return $this
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Gets the HttpClient.
     *
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        if ($this->httpClient === null) {
            // @codeCoverageIgnoreStart
            $this->setHttpClient(new HttpClient());
        }
        // @codeCoverageIgnoreEnd

        return $this->httpClient;
    }

    /**
     * Gets the full endpoint to GA.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return ($this->isDebug) ? $this->uriScheme . $this->debugEndpoint : $this->uriScheme . $this->endpoint;
    }

    /**
     * Gets the full batch endpoint to GA.
     *
     * @return string
     */
    protected function getBatchEndpoint()
    {
        return $this->uriScheme . $this->batchEndpoint;
    }

    /**
     * Sets debug mode to true or false.
     *
     * @api
     * @param bool $value
     * @return \TheIconic\Tracking\GoogleAnalytics\Analytics
     */
    public function setDebug($value)
    {
        $this->isDebug = $value;

        return $this;
    }

    /**
     * Sends a hit to GA. The hit will contain in the payload all the parameters added before.
     *
     * @param $methodName
     * @return AnalyticsResponseInterface
     * @throws Exception\InvalidPayloadDataException
     */
    protected function sendHit($methodName)
    {
        $hitType = strtoupper(substr($methodName, 4));

        $this->setAndValidateHit($hitType);

        if ($this->isDisabled) {
            return new NullAnalyticsResponse();
        }

        return $this->getHttpClient()->post($this->getUrl(), $this->getHttpClientOptions());
    }

    /**
     * Enqueue a hit to GA. The hit will contain in the payload all the parameters added before.
     *
     * @param $methodName
     * @return $this
     * @throws Exception\InvalidPayloadDataException
     */
    protected function enqueueHit($methodName)
    {

        if(count($this->enqueuedUrls) == 20) {
            throw new EnqueueUrlsOverflowException();
        }

        $hitType = strtoupper(substr($methodName, 7));

        $this->setAndValidateHit($hitType);
        $this->enqueuedUrls[] = $this->getUrl(true);

        return $this;
    }

    /**
     * Validate and set hitType
     *
     * @param $methodName
     * @return void
     * @throws Exception\InvalidPayloadDataException
     */
    protected function setAndValidateHit($hitType)
    {
        
        $hitConstant = $this->getParameterClassConstant(
            'TheIconic\Tracking\GoogleAnalytics\Parameters\Hit\HitType::HIT_TYPE_' . $hitType,
            'Hit type ' . $hitType . ' is not defined, check spelling'
        );

        $this->setHitType($hitConstant);

        if (!$this->hasMinimumRequiredParameters()) {
            throw new InvalidPayloadDataException();
        }
    }

    /**
     * Sends enqueued hits to GA. These hits will contain in the payload all the parameters added before.
     *
     * @return AnalyticsResponseInterface
     */
    public function sendEnqueuedHits()
    {
        if ($this->isDisabled) {
            return new NullAnalyticsResponse();
        }

        $response = $this->getHttpClient()->batch($this->getBatchEndpoint(), $this->enqueuedUrls, $this->getHttpClientOptions());

        $this->emptyQueue();

        return $response;
    }

    /**
     * Build the options array for the http client based on the Analytics object options.
     *
     * @return array
     */
    protected function getHttpClientOptions()
    {
        $options = ['async' => $this->isAsyncRequest];

        if (isset($this->options['timeout'])) {
            $options['timeout'] = $this->options['timeout'];
        }

        return $options;
    }

    /**
     * Build and returns URL used to send to Google Analytics.
     *
     * @api
     * @return string
     */
    public function getUrl($onlyQuery = false)
    {
        $prepareUrl = new PrepareUrl;

        return $prepareUrl->build(
            $this->getEndpoint(),
            $this->singleParameters,
            $this->compoundParametersCollections,
            $onlyQuery
        );
    }

    /**
     * Validates the minimum required parameters for every GA hit are being sent.
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     *
     * @return bool
     */
    protected function hasMinimumRequiredParameters()
    {
        $minimumRequiredParameters = [
            'v' => false,
            'tid' => false,
            'cid' => false,
            'uid' => false,
            't' => false,
        ];

        foreach ($minimumRequiredParameters as $parameterName => $isParamPresent) {
            if (array_key_exists($parameterName, $this->singleParameters)) {
                $minimumRequiredParameters[$parameterName] = true;
            }
        }

        if (!$minimumRequiredParameters['cid'] && $minimumRequiredParameters['uid']) {
            $minimumRequiredParameters['cid'] = true;
        }

        if (!$minimumRequiredParameters['uid'] && $minimumRequiredParameters['cid']) {
            $minimumRequiredParameters['uid'] = true;
        }

        return !in_array(false, $minimumRequiredParameters, true);
    }

    /**
     * Sets a parameter action to the value specified by the method call.
     *
     * @param $parameter
     * @param $action
     * @return $this
     */
    protected function setParameterActionTo($parameter, $action)
    {
        $actionConstant = $this->getParameterClassConstant(
            'TheIconic\Tracking\GoogleAnalytics\Parameters\EnhancedEcommerce\\'
            . $parameter . 'Action::ACTION_' . strtoupper($action),
            $parameter . ' action ' . $action . ' does not exist, check spelling'
        );

        $function = 'set' . $parameter . 'Action';

        $this->$function($actionConstant);

        return $this;
    }

    /**
     * Gets a contant from a class dynamically.
     *
     * @param $constant
     * @param $exceptionMsg
     * @return mixed
     * @throws BadMethodCallException
     */
    protected function getParameterClassConstant($constant, $exceptionMsg)
    {
        if (defined($constant)) {
            return constant($constant);
        } else {
            throw new BadMethodCallException($exceptionMsg);
        }
    }

    /**
     * Sets the value for a parameter.
     *
     * @param $methodName
     * @param array $methodArguments
     * @return $this
     * @throws \InvalidArgumentException
     */
    protected function setParameter($methodName, array $methodArguments)
    {
        $parameterClass = substr($methodName, 3);

        $fullParameterClass = $this->getFullParameterClass($parameterClass, $methodName);

        $parameterIndex = $this->getIndexFromArguments($methodArguments);

        /** @var SingleParameter $parameterObject */
        $parameterObject = new $fullParameterClass($parameterIndex);

        if (!isset($methodArguments[0])) {
            throw new \InvalidArgumentException(
                'For Analytics object, you must specify a value to be set for ' . $methodName
            );
        } else {
            $parameterObject->setValue($methodArguments[0]);
        }

        $this->singleParameters[$parameterObject->getName()] = $parameterObject;

        return $this;
    }

    /**
     * Adds an item to a compund parameter collection.
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     *
     * @param $methodName
     * @param array $methodArguments
     * @return $this
     * @throws \InvalidArgumentException
     */
    protected function addItem($methodName, array $methodArguments)
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

        $collectionIndex = $this->getIndexFromArguments($methodArguments);

        $parameterIndex = $parameterClass . $collectionIndex;
        if (isset($this->compoundParametersCollections[$parameterIndex])) {
            $this->compoundParametersCollections[$parameterIndex]->add($parameterObject);
        } else {
            $fullParameterCollectionClass = $fullParameterClass . 'Collection';

            /** @var CompoundParameterCollection $parameterObjectCollection */
            $parameterObjectCollection = new $fullParameterCollectionClass($collectionIndex);

            $parameterObjectCollection->add($parameterObject);

            $this->compoundParametersCollections[$parameterIndex] = $parameterObjectCollection;
        }

        return $this;
    }

    /**
     * Gets the value for a parameter.
     *
     * @SuppressWarnings(PHPMD.LongVariable)
     *
     * @param $methodName
     * @param array $methodArguments
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function getParameter($methodName, array $methodArguments)
    {
        $parameterClass = substr($methodName, 3);

        $fullParameterClass = $this->getFullParameterClass($parameterClass, $methodName);

        // Handle index arguments
        $parameterIndex = '';
        if (isset($methodArguments[0]) && is_numeric($methodArguments[0])) {
            $parameterIndex = $methodArguments[0];
        }

        // Handle compoundParametersCollections
        if (isset($this->compoundParametersCollections[$parameterClass . $parameterIndex])) {
            // If compoundParametersCollections contains our Objects, return them well-formatted
            return $this->compoundParametersCollections[$parameterClass . $parameterIndex]->getReadableItems();
        } else {
            $fullParameterCollectionClass = $fullParameterClass . 'Collection';

            // Test if the class Collection exist
            if (class_exists($fullParameterCollectionClass, false)) {
                return null;
            }
            // If not, it's a SingleParameter Object, continue the magic
        }

        /** @var SingleParameter $parameterObject */
        $parameterObject = new $fullParameterClass($parameterIndex);

        if (!array_key_exists($parameterObject->getName(), $this->singleParameters)) {
            return null;
        }

        $currentParameterObject = $this->singleParameters[$parameterObject->getName()];

        return $currentParameterObject->getValue();

    }

    /**
     * Gets the index value from the arguments.
     *
     * @param $methodArguments
     * @return string
     */
    protected function getIndexFromArguments($methodArguments)
    {
        $index = '';
        if (isset($methodArguments[1]) && is_numeric($methodArguments[1])) {
            $index = $methodArguments[1];
        }

        return $index;
    }

    /**
     * Gets the fully qualified name for a parameter.
     *
     * @param $parameterClass
     * @param $methodName
     * @return string
     * @throws BadMethodCallException
     */
    protected function getFullParameterClass($parameterClass, $methodName)
    {
        if (empty($this->availableParameters[$parameterClass])) {
            throw new BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
        }

        return '\\TheIconic\\Tracking\\GoogleAnalytics\\Parameters\\' . $this->availableParameters[$parameterClass];
    }

    /**
     * Empty batch queue
     *
     * @return $this
     */
    public function emptyQueue()
    {
        $this->enqueuedUrls = [];

        return $this;
    }

    /**
     * Routes the method call to the adequate protected method.
     *
     * @param $methodName
     * @param array $methodArguments
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($methodName, array $methodArguments)
    {
        $methodName = $this->fixTypos($methodName);

        if (preg_match('/^set(Product|Promotion)ActionTo(\w+)/', $methodName, $matches)) {
            return $this->setParameterActionTo($matches[1], $matches[2]);
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

        if (preg_match('/^(enqueue)(\w+)/', $methodName, $matches)) {
            return $this->enqueueHit($methodName);
        }

        // Get Parameters
        if (preg_match('/^(get)(\w+)/', $methodName, $matches)) {
            return $this->getParameter($methodName, $methodArguments);
        }

        throw new BadMethodCallException('Method ' . $methodName . ' not defined for Analytics class');
    }

    /**
     * Fix typos that went into releases, this way we ensure we don't break scripts in production.
     *
     * @param string $methodName
     * @return string
     */
    protected function fixTypos($methodName)
    {
        // @TODO deprecated in v2, to be removed in v3
        if ($methodName === 'setUserTiminCategory') {
            $methodName = 'setUserTimingCategory';
        }

        return $methodName;
    }
}
