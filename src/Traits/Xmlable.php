<?php

namespace WillyMaciel\Sankhya\Traits;

use \DOMDocument;

/**
 *
 */
trait Xmlable
{
    public function toXml($data, $serviceName)
    {
        $xml = new DOMDocument('1.0', 'ISO-8859-15');

        //serviceRequest
        $serviceRequest = $xml->createElement('serviceRequest');
        $serviceRequest->setAttribute('serviceName', $serviceName);
        $xml->appendChild($serviceRequest);

        //requestBody
        $requestBody = $xml->createElement('requestBody');
        $serviceRequest->appendChild($requestBody);

        foreach ($data as $key => $value)
        {
            $el = $xml->createElement(strtoupper($key), $value);
            $requestBody->appendChild($el);
        }

        return $xml->saveXML();
    }
}
