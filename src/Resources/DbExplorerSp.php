<?php

namespace WillyMaciel\Sankhya\Resources;

use WillyMaciel\Sankhya\Clients\Client;
use Tightenco\Collect\Support\Collection;

/**
 *
 */
class DbExplorerSp extends BaseResource
{
    CONST MODULO = 'mge';
    CONST SERVICE_NAME = 'DbExplorerSP';

    /**
     * Executa Query no Servidor (SOMENTE SELECT).
     *
     * @param  string $query
     * @return Collection
     */
    public function executeQuery(string $query)
    {
        $fullServiceName = $this->getServiceName('executeQuery');

        $body = [
            'serviceName' => $fullServiceName,
            'requestBody' => [
                'sql' => str_replace(array("\r", "\n"), '', $query)
            ]
        ];

        $body = json_encode($body);

        $response = $this->client->get(self::getUri('executeQuery'), $body);

        return $this->createCollection($response);
    }

    /**
     * @param  mixed $response
     * @return Collection
     */
    private function createCollection($response)
    {
        if(count($response->responseBody->rows) <= 0)
        {
            return new Collection();
        }

        $fields = [];
        foreach($response->responseBody->fieldsMetadata as $f)
        {
             $fields[] = $f->name;
        }

        $rows = [];
        foreach ($response->responseBody->rows as $key => $row)
        {
            //Combina Keys com Values
            $rows[] = (object)array_combine($fields, $row);
        }

        return new Collection($rows);
    }
}
