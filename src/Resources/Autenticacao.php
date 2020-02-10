<?php

namespace WillyMaciel\Sankhya\Resources;

use WillyMaciel\Sankhya\Clients\Client;
use WillyMaciel\Sankhya\Traits\Xmlable;

/**
 *
 */
class Autenticacao extends BaseResource
{
    use Xmlable;

    CONST MODULO = 'mge';
    CONST SERVICE_NAME = 'MobileLoginSP';

    private $nomusu;
    private $interno;
    private $interno2;
    private $jSessionId;

    public function login($nomusu, $interno)
    {
        $this->nomusu = strtoupper($nomusu);
        $this->interno = $interno;
        $this->interno2 = isValidMd5($interno) ? $interno : md5($nomusu . $interno);

        $body = [
            'NOMUSU'    => $this->nomusu,
            'INTERNO2'  => $this->interno2
        ];

        $serviceName = $this->getFullServiceName('login');
        $body = $this->toXml($body, $serviceName);

        $endPoint = $this->getFullUri('login');

        $response = $this->client->get($endPoint, $body);
        $this->jSessionId = $response->responseBody->jsessionid;

        return $this->jSessionId;
    }

    public function logout()
    {
        $endPoint = $this->getFullUri('logout');
        $response = $this->client->get($endPoint);

        if($response->status == 1)
        {
            $this->jSessionId = null;
            return true;
        }

        return false;
    }

    public function getJsessionId()
    {
        return $this->jSessionId;
    }
}
