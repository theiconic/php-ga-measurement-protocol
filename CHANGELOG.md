## Version 2
### 2.9.0 (2020-09-25)
 * Adding batch hit feature, by @alberto-bottarini and @jorgeborges

### 2.8.0 (2020-09-10)
 * Adding optional Guzzle 7 dependency, by @irazasyed
 
### 2.7.2 (2020-05-31)
 * Fixing social parameters that were not inheriting the correct class, by @alberto-bottarini

### 2.7.1 (2017-06-30)
 * Fixing class_exists bug when getting parameters, by @peterjaap

### 2.7.0 (2017-05-13)
 * Adding timeout option, by @venyii

### 2.6.0 (2017-04-10)
 * Adding Disabling library feature, by @edim24

### 2.5.1 (2017-03-20)
 * Fixing required params for all hits, either Client ID or User ID

### 2.5.0 (2017-03-20)
 * Fixing required params for Products, by @rhrebecek
 * Making Analytics class completely extensible

### 2.4.1 (2017-01-19)
 * Fixing URL encoding for Japanese characters by using RFC3986, by @ryo88c

### 2.4.0 (2017-10-14)
 * Adding get params methods by @Nightbr

### 2.3.0 (2016-08-20)
 * Adding getting URL method by @stefanzweifel

### 2.2.0 (2016-07-31)
 * Adding Debug feature for validating hits, in part contributed by @amit0rana (I had to fix the unit tests)
 * Removing dependency to Symfony Finder, now the lib is much faster since it doesn't read from disk
 * Fixing typo for setUserTimingCategory (a method to allow backward compatibility was added, it will be removed in V3)
 * Fixing issue #21 for cache buster param

### 2.1.0 (2015-07-19)
 * Updating dependencies
 * Adding Content Grouping support by @lombo

### 2.0.0 (2015-07-03)
 * Upgrading to Guzzle 6
 * Removing support for PHP 5.4 (use version 1 for that)

## Version 1
### 1.2.0 (2015-07-19)
 * Updating dependencies
 * Adding Content Grouping support by @lombo

### 1.1.5 (2015-07-03)
 * Updating dependencies
 * Creating separate branches to maintain v1 and v2 apart

### 1.1.4 (2015-04-18)
 * Updating dependencies
 * Including Yii 2 integration by @baibaratsky
 * Placing project in CI with PHP 5.6 and 7

### 1.1.3 (2015-03-17)
 * Updating dependencies
 * Using caret for declaring dependencies in Composer, as per author's recommendation

### 1.1.2 (2015-03-07)
 * Creating setAsyncRequest(boolean $isAsyncRequest) method to be used instead of makeNonBlocking(). Its more flexible.
 * makeNonBlocking() is now deprecated, use setAsyncRequest() instead. To be removed in next major release.

### 1.1.1 (2015-02-26)
 * Changing HTTPS endpoint to official one in Google documentation
 * Adding Data Source parameter
 * Adding Geographical Override parameter

### 1.1.0 (2015-02-25)
 * Adding the capability of sending hits to GA in an asynchronous way (non-blocking)

### 1.0.1 (2015-02-03)
 * Minor bug fixes

### 1.0.0 (2015-01-30)

 * First stable release
 * Full implementation of GA measurement protocol (AFAIK, feel free to open issue/pull request)
 * 100% code coverage for unit tests
 * Only missing documentation and integration tests to be added in next minor release

### 0.1.1 (2014-10-01)

  * Fixing bug where ecommerce transaction was not collected because data was being sent as POST body instead
  of URL query parameters

### 0.1.0 (2014-09-25)

  * Added send pageview and event
  * All required parameters for pageview and events implemented
  * Alpha testing of transaction tracking with Enhanced Ecommerce

### 0.1-alpha.0 (2014-09-24)

  * Initial release
