<?php

namespace WillyMaciel\Sankhya\Traits;

use \DOMDocument;

/**
 * Cria corpo de requisição em XML
 */
trait XmlRequest
{
    protected $xmlRequest;

    public function makeServiceRequest(string $serviceName, $data)
    {
        $this->xmlRequest = new \DOMDocument('1.0', 'ISO-8859-1');

        //serviceRequest
        $serviceRequest = $this->xmlRequest->createElement('serviceRequest');
        $serviceRequest->setAttribute('serviceName', $serviceName);
        $this->xmlRequest->appendChild($serviceRequest);

        //requestBody
        $requestBody = $this->xmlRequest->createElement('requestBody');
        $serviceRequest->appendChild($requestBody);

        //Se data é array, cria elementos do XML automaticamente
        if(is_array($data))
        {
            foreach ($data as $key => $value)
            {
                $this->createElement($key, $value, $requestBody);
            }
        }
        else
        {
            //Se data é um XML, cria Elemento XML para dar append no requestBody
            $doc = new DOMDocument();
            $doc->loadXML($data);
            $doc = $this->xmlRequest->importNode($doc->documentElement, true);
            $requestBody->appendChild($doc);
        }

        return $this->xmlRequest->saveXML();
    }

    private function createElement($name, $value, $parentNode)
    {
        if(!is_array($value))
        {
            $el = $this->xmlRequest->createElement(strtoupper($name), $value);
            $parentNode->appendChild($el);
        }
        else
        {
            //Se valores do array são sequenciais
            //não cria novo elemento pai, usa o ultimo pai
            if($this->isArraySequential($value))
            {
                $el = $parentNode;
            }
            else
            {
                $el = $this->xmlRequest->createElement(strtolower($name));
                $parentNode->appendChild($el);
            }

            foreach ($value as $childKey => $childValue)
            {
                $childName = (is_numeric($childKey)) ? $name : $childKey;

                $this->createElement($childName, $childValue, $el);
            }
        }
    }

    private function isArraySequential($array)
    {
        return (array_keys($array) !== range(0, count($array) - 1)) ? false : true;
    }
}
