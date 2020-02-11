<?php

namespace WillyMaciel\Sankhya\Resources;

use WillyMaciel\Sankhya\Clients\Client;

/**
 *
 */
abstract class BaseResource
{
    protected $client;

    CONST MODULO = 'mge';
    CONST SERVICE_NAME = '';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function getServiceName(string $methodName)
    {
        return STATIC::SERVICE_NAME . ".$methodName";
    }

    protected function getUri(string $methodName)
    {
        return static::MODULO . "/service.sbr?serviceName=" . STATIC::SERVICE_NAME . '.' . $methodName;
    }

    public function jsonResponse($response)
    {
        return json_decode($response);
    }
}
