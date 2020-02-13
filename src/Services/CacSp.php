<?php

namespace WillyMaciel\Sankhya\Services;

use WillyMaciel\Sankhya\Clients\Client;
use WillyMaciel\Sankhya\Models\Nota;
use Tightenco\Collect\Support\Collection;
use WillyMaciel\Sankhya\Traits\XmlRequest;

/**
 *
 */
class CacSp extends BaseService
{
    use XmlRequest;

    CONST MODULO = 'mgecom';
    CONST SERVICE_NAME = 'CACSP';

    public function incluirNota(Nota $nota)
    {
        $endPoint = $this->getUri('incluirNota');

        $serviceName = $this->getServiceName('incluirNota');
        $body = $this->makeServiceRequest($serviceName, $nota->toArray());

        return $body;
    }
}
