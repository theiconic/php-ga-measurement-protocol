Google Analytics Measurement Protocol library for PHP
===========================
[![Build Status](https://travis-ci.org/theiconic/php-ga-measurement-protocol.svg?branch=v1.1.1)](https://travis-ci.org/theiconic/php-ga-measurement-protocol) [![Coverage Status](https://img.shields.io/coveralls/theiconic/php-ga-measurement-protocol.svg)](https://coveralls.io/r/theiconic/php-ga-measurement-protocol?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/theiconic/php-ga-measurement-protocol/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/theiconic/php-ga-measurement-protocol/?branch=master) [![Latest Stable Version](https://poser.pugx.org/theiconic/php-ga-measurement-protocol/v/stable.svg)](https://packagist.org/packages/theiconic/php-ga-measurement-protocol) [![Total Downloads](https://poser.pugx.org/theiconic/php-ga-measurement-protocol/downloads.svg)](https://packagist.org/packages/theiconic/php-ga-measurement-protocol) [![License](https://poser.pugx.org/theiconic/php-ga-measurement-protocol/license.svg)](https://packagist.org/packages/theiconic/php-ga-measurement-protocol) [![Documentation Status](https://readthedocs.org/projects/php-ga-measurement-protocol/badge/?version=latest)](http://php-ga-measurement-protocol.readthedocs.org/en/latest/)

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

## Installation

Use Composer to install this package.

```json
{
    "require": {
        "theiconic/php-ga-measurement-protocol": "~1.1"
    }
}
```

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
The hit should have arrived to the GA property UA-26293728-11. You can verify this in your Real Time dashboard.

The library is 100% done, full documentation is a work in progress, but basically all parameters can be set the same way.

```php
// Look at the parameter names in Google official docs at
// https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
$analytics->set<ParameterName>('my_value');
```

## Use Cases
### Asynchronous Requests (Non-Blocking)
```php
// When building the Analytics hit, just make a call to the makeNonBlocking method
// now sending the hit won't block the execution of the script
$analytics->makeNonBlocking();
```
This means that we are sending the request and not waiting for a response. The AnalyticsResponse object that you will get back has NULL for HTTP status code.
### Order Tracking with Enhanced E-commerce

```php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

$analytics = new Analytics();

// Build the order data programmatically, including each order product in the payload
// First, general and required hit data
$analytics->setProtocolVersion('1')
    ->setTrackingId('UA-26293624-12')
    ->setClientId('12345678')
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

## Contributors

* Jorge A. Borges - Lead Developer ([http://jorgeborges.me](http://jorgeborges.me))
* Juan Falcón - [arcticfalcon](https://github.com/arcticfalcon)

## License

THE ICONIC Google Analytics Measurement Protocol library for PHP is released under the MIT License.
