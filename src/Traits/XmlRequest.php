<?php

namespace WillyMaciel\Sankhya\Traits;

/**
 * Cria corpo de requisição em XML
 */
trait XmlRequest
{
    protected $xmlRequest;

    public function makeServiceRequest($serviceName, $data)
    {
        dump($data);
        $this->xmlRequest = new \DOMDocument('1.0', 'ISO-8859-15');

        //serviceRequest
        $serviceRequest = $this->xmlRequest->createElement('serviceRequest');
        $serviceRequest->setAttribute('serviceName', $serviceName);
        $this->xmlRequest->appendChild($serviceRequest);

        //requestBody
        $requestBody = $this->xmlRequest->createElement('requestBody');
        $serviceRequest->appendChild($requestBody);

        foreach ($data as $key => $value)
        {
            $this->createElement($key, $value, $requestBody);
        }

        return $this->xmlRequest->saveXML();
    }

    private function createElement($name, $value, $parentNode)
    {
        //Se node é array cria elementos recursivamente
        if(is_array($value))
        {
            dump('CREATEELEMENT', $name, $value, $parentNode);
            if(is_numeric($name))
            {
                $name = 'item';
            }
            $el = $this->xmlRequest->createElement(strtoupper($name));
            $parentNode->appendChild($el);

            foreach ($value as $childKey => $childValue)
            {
                $this->createElement($childKey, $childValue, $el);
            }
        }
        else
        {
            $el = $this->xmlRequest->createElement(strtoupper($name), $value);
            $parentNode->appendChild($el);
        }
    }
}
