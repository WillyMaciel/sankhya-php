<?php

//Transaforma xml em Objeto, convertendo
//propriedade @attributes em propriedades com própria key
function simpleXmlToObject($xmlString)
{
    $simpleXml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);

    $object = json_decode(json_encode($simpleXml));

    if(isset($object->{'@attributes'}))
    {
        foreach ($object->{'@attributes'} as $key => $value)
        {
            $object->$key = $value;
        }

        unset($object->{'@attributes'});
    }

    return $object;
}

function rmNewLine($string)
{
    return str_replace('\n', '', $string);
}

function isValidMd5($value)
{
    return preg_match('/^[a-f0-9]{32}$/', $value);
}

function isoToUtf8($string)
{
    return iconv('ISO-8859-1', 'UTF-8', $string);
}
