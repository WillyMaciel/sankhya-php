<?php

namespace WillyMaciel\Sankhya\Services;

use WillyMaciel\Sankhya\Clients\Client;
use Tightenco\Collect\Support\Collection;
use WillyMaciel\Sankhya\Traits\JsonRequest;

/**
 *
 */
class DbExplorerSp extends BaseService
{
    use JsonRequest;

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

        $data = [
            'sql' => str_replace(array("\r", "\n"), '', $query)
        ];

        $body = $this->makeServiceRequest($fullServiceName, $data);

        $response = $this->client->get(self::getUri('executeQuery'), $body);

        return $this->createCollection($response);
    }

    /**
     * Manipula os resultados para criar uma Collection
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
