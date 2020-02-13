<?php

namespace WillyMaciel\Sankhya\Traits;

/**
 * Cria corpo de requisição em Json
 */
trait JsonRequest
{
    public function makeServiceRequest($serviceName, $data)
    {
        $body = [
            'serviceName' => $serviceName,
            'requestBody' => $data
        ];

        return json_encode($body);
    }
}
