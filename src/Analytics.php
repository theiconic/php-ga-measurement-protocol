<?php

namespace JorgeBorges\Google\Analytics;

use JorgeBorges\Google\Analytics\Parameters\Hit\HitType;
use GuzzleHttp\Client as HttpClient;
use Symfony\Component\Finder\Finder;

/**
 * Class Analytics
 *
 * @method \JorgeBorges\Google\Analytics\Analytics setProtocolVersion($value)
 * @method \JorgeBorges\Google\Analytics\Analytics setTrackingId($value)
 * @method \JorgeBorges\Google\Analytics\Analytics setClientId($value)
 * @method \JorgeBorges\Google\Analytics\Analytics setDocumentPath($value)
 * @method \JorgeBorges\Google\Analytics\Analytics setDocumentHostName($value)
 * @method \JorgeBorges\Google\Analytics\Analytics setHitType($value)
 *
 * @package JorgeBorges\Google\Analytics
 */
class Analytics
{
    const ABSTRACT_SUBSTRING = 'Abstract';

    const PHP_EXTENSION = '.php';

    private $protocol = 'http';

    private $endpoint = '://www.google-analytics.com/collect';

    private $parameters = [];

    private $availableParameters;

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

    private function getAvailableParameters()
    {
        $parameterClassNames = [];

        $finder = new Finder();

        // Filter for only valid parser files, not MasterParser, Abstract class or Interface
        $filter = function (\SplFileInfo $file) {
            if (strpos($file, static::ABSTRACT_SUBSTRING) !== false) {
                return false;
            }
        };

        $finder->files()->filter($filter)->in(__DIR__ . '/Parameters');

        foreach ($finder as $file) {
            $categorisedParameter = str_replace(
                [static::PHP_EXTENSION, '/'],
                ['', '\\'],
                $file->getRelativePathname()
            );
            $categorisedParameterArray = explode('\\', $categorisedParameter);
            $parameterClassNames[$categorisedParameterArray[1]] = $categorisedParameter;
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

        $client = new HttpClient();

        $respose = $client->post(
            $this->getEndpoint(),
            [
                'body' => $this->getPostBody(),
            ]
        );


        return $respose->getReasonPhrase();
    }

    private function getPostBody()
    {
        $postData = [];

        foreach ($this->parameters as $parameterObj) {
            $postData[$parameterObj->getName()] = $parameterObj->getValue();
        }

        return $postData;
    }

    public function __call($methodName, array $methodArguments)
    {
        if (preg_match('/(set)(\w+)/', $methodName, $matches)) {

            $parameterClass = substr($methodName, 3);

            $fullParameterClass =
                '\\JorgeBorges\\Google\\Analytics\\Parameters\\' . $this->availableParameters[$parameterClass];

            $parameterObject = new $fullParameterClass();

            $parameterObject->setValue($methodArguments[0]);

            $this->parameters[$parameterObject->getName()] = $parameterObject;

            return $this;

/*            if (array_key_exists($matches[2], $this->getStructure()->getAttributeMap())) {
                $methodType = substr($methodName, 0, 3);

                if ($methodType === 'get') {
                    return $this->data[$this->getStructure()->getAttributeMap()[$matches[2]]['index']];
                } else {
                    $this->data[$this->getStructure()->getAttributeMap()[$matches[2]]['index']] = $methodArguments[0];
                }
            } else {
                throw new \BadMethodCallException('No key found in Attribute Mapper for the requested attribute');
            }*/
        }
    }
}
