Google Analytics Measurement Protocol library for PHP
===========================
[![Build Status](https://travis-ci.org/theiconic/php-ga-measurement-protocol.svg?branch=v2.3.0)](https://travis-ci.org/theiconic/php-ga-measurement-protocol) [![Coverage Status](https://coveralls.io/repos/theiconic/php-ga-measurement-protocol/badge.svg?branch=master&service=github)](https://coveralls.io/github/theiconic/php-ga-measurement-protocol?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/theiconic/php-ga-measurement-protocol/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/theiconic/php-ga-measurement-protocol/?branch=master) [![Latest Stable Version](https://poser.pugx.org/theiconic/php-ga-measurement-protocol/v/stable)](https://packagist.org/packages/theiconic/php-ga-measurement-protocol) [![Total Downloads](https://poser.pugx.org/theiconic/php-ga-measurement-protocol/downloads)](https://packagist.org/packages/theiconic/php-ga-measurement-protocol) [![License](https://poser.pugx.org/theiconic/php-ga-measurement-protocol/license)](https://packagist.org/packages/theiconic/php-ga-measurement-protocol) [![Documentation Status](https://readthedocs.org/projects/php-ga-measurement-protocol/badge/?version=latest)](http://php-ga-measurement-protocol.readthedocs.org/en/latest/)

## Description

Send data to Google Analytics from the server using PHP. This library fully implements GA measurement protocol so its possible to send any data that you would usually do from analytics.js on the client side. You can send data regarding the following parameters categories [(Full List)](https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters):
* General
* User
* Session
* Traffic Sources
* System Info
* Hit
* Content Information
* App Tracking
* Event Tracking
* E-Commerce
* Enhanced E-Commerce
* Social Interactions
* Timing
* Exceptions
* Custom Dimensions / Metrics
* Content Experiments
* Content Grouping

## Installation

Use Composer to install this package.

If you are using ```PHP 5.5 or above``` and ```Guzzle 6``` then:

```json
{
    "require": {
        "theiconic/php-ga-measurement-protocol": "^2.0"
    }
}
```

Or if you are using ```PHP 5.4 or above``` and ```Guzzle 5``` then:

```json
{
    "require": {
        "theiconic/php-ga-measurement-protocol": "^1.1"
    }
}
```

Take notice v1 won't receive more updates, you are encourage to update to v2.

## Integrations
You can use this package on its own, or use a convenient framework integration:
* Laravel 4/5 - https://github.com/irazasyed/laravel-gamp
* Yii 2 - https://github.com/baibaratsky/yii2-ga-measurement-protocol
* Symfony2 - https://github.com/fourlabsldn/GampBundle

Feel free to create an integration with your favourite framework, let us know so we list it here.

## Usage
The required parameters for all hits are Protocol Version, Tracking ID and Client ID. Some optional ones like IP Override are recommended if you don't want all hits to seem like coming from your servers.
```php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

// Instantiate the Analytics object
// optionally pass TRUE in the constructor if you want to connect using HTTPS
$analytics = new Analytics(true);

// Build the GA hit using the Analytics class methods
// they should Autocomplete if you use a PHP IDE
$analytics
    ->setProtocolVersion('1')
    ->setTrackingId('UA-26293728-11')
    ->setClientId('12345678')
    ->setDocumentPath('/mypage')
    ->setIpOverride("202.126.106.175");

// When you finish bulding the payload send a hit (such as an pageview or event)
$analytics->sendPageview();
```
The hit should have arrived to the GA property UA-26293728-11. You can verify this in your Real Time dashboard. Take notice, if you need GA reports to tie this event with previous user actions you must get and set the ClientId to be same as the GA Cookie. Read ([here](https://developers.google.com/analytics/devguides/collection/analyticsjs/cookies-user-id#getting_the_client_id_from_the_cookie)).

The library is 100% done, full documentation is a work in progress, but basically all parameters can be set the same way.

```php
// Look at the parameter names in Google official docs at
// https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
$analytics->set<ParameterName>('my_value');
```

```php
// Get any parameter by its name
// Look at the parameter names in Google official docs at
// https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
$analytics->get<ParameterName>();
```

All methods for setting parameters should **Autocomplete** if you use an IDE such as PHPStorm, which makes building the Analytics object very easy.

## Use Cases
### Asynchronous Requests (Non-Blocking)
By default, sending a hit to GA will be a synchronous request, and block the execution of the script until it gets a response from the server or timeouts after 100 secs (throwing a Guzzle exception). However, an asynchronous non-blocking request can be sent by calling setAsyncRequest(true) before sending the hit:
```php
// When building the Analytics hit, just make a call to the setAsyncRequest method passing true
// now sending the hit won't block the execution of the script
$analytics
    ->setAsyncRequest(true)
    ->sendPageview();
```
This means that we are sending the request and not waiting for a response. The AnalyticsResponse object that you will get back has NULL for HTTP status code.
### Order Tracking with Enhanced E-commerce

```php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

$analytics = new Analytics();

// Build the order data programmatically, including each order product in the payload
// Take notice, if you want GA reports to tie this event with previous user actions
// you must get and set the same ClientId from the GA Cookie
// First, general and required hit data
$analytics->setProtocolVersion('1')
    ->setTrackingId('UA-26293624-12')
    ->setClientId('2133506694.1448249699')
    ->setUserId('123');

// Then, include the transaction data
$analytics->setTransactionId('7778922')
    ->setAffiliation('THE ICONIC')
    ->setRevenue(250.0)
    ->setTax(25.0)
    ->setShipping(15.0)
    ->setCouponCode('MY_COUPON');

// Include a product, only required fields are SKU and Name
$productData1 = [
    'sku' => 'AAAA-6666',
    'name' => 'Test Product 2',
    'brand' => 'Test Brand 2',
    'category' => 'Test Category 3/Test Category 4',
    'variant' => 'yellow',
    'price' => 50.00,
    'quantity' => 1,
    'coupon_code' => 'TEST 2',
    'position' => 2
];

$analytics->addProduct($productData1);

// You can include as many products as you need this way
$productData2 = [
    'sku' => 'AAAA-5555',
    'name' => 'Test Product',
    'brand' => 'Test Brand',
    'category' => 'Test Category 1/Test Category 2',
    'variant' => 'blue',
    'price' => 85.00,
    'quantity' => 2,
    'coupon_code' => 'TEST',
    'position' => 4
];

$analytics->addProduct($productData2);

// Don't forget to set the product action, in this case to PURCHASE
$analytics->setProductActionToPurchase();

// Finally, you must send a hit, in this case we send an Event
$analytics->setEventCategory('Checkout')
    ->setEventAction('Purchase')
    ->sendEvent();
```

### Validating Hits

From Google Developer Guide:

> The Google Analytics Measurement Protocol does not return HTTP error codes, even if a Measurement Protocol hit is malformed or missing required parameters. To ensure that your hits are correctly formatted and contain all required parameters, you can test them against the validation server before deploying them to production.

To send a validation hit, turn on debug mode like this

```php
// Make sure AsyncRequest is set to false (it defaults to false)
$response = $analytics
              ->setDebug(true)
              ->sendPageview();

$debugResponse = $response->getDebugResponse();

// The debug response is an associative array, you could use print_r to view its contents
print_r($debugResponse);
```

GA actually returns a JSON that is parsed into an associative array. Read ([here](https://developers.google.com/analytics/devguides/collection/protocol/v1/validating-hits)) to understand how to interpret response.

## Contributors

* Jorge A. Borges - Lead Developer ([http://jorgeborges.me](http://jorgeborges.me))
* Juan Falcón - [arcticfalcon](https://github.com/arcticfalcon)
* Syed Irfaq R. - [irazasyed](https://github.com/irazasyed)
* Andrei Baibaratsky - [baibaratsky](https://github.com/baibaratsky)
* Martín Palombo - [lombo](https://github.com/lombo)
* Amit Rana - [amit0rana](https://github.com/amit0rana)
* Stefan Zweifel - [stefanzweifel](https://github.com/stefanzweifel)
* Titouan BENOIT - [nightbr](https://github.com/Nightbr)

## License

THE ICONIC Google Analytics Measurement Protocol library for PHP is released under the MIT License.
