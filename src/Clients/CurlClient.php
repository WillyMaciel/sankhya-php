<?php

namespace WillyMaciel\Sankhya\Clients;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Uri;

/**
 *
 */
class CurlClient implements Client
{
    CONST USER_AGENT = 'SWServiceInvoker';
    private $baseUri;
    private $headers = [];
    private $headersProcessed;
    private $cookies;
    private $query = [];
    private $queryProcessed;

    function __construct($baseUri)
    {
        $this->baseUri = $baseUri;

        $this->headers = [
            'Cache-Control' => 'no-cache',
            'Content-Type'  => 'text/xml;charset=ISO-8859-1'
        ];
    }

    public function get($endpoint, $params = [])
    {
        return $this->request('GET', $endpoint, $params);
    }

    public function post($endpoint, $params = [])
    {
        return $this->request('POST', $endpoint, $params);
    }

    private function request($method = 'GET', $endpoint, $params = NULL)
    {
        $curl = curl_init();

        $body = (isset($params['body'])) ? $params['body'] : NULL;
        $body = isoToUtf8($body);
        $body = (is_array($body)) ? http_build_query($body) : $body;

        $localQuery = (isset($params['query'])) ? $params['query'] : [];
        $localHeaders = (isset($params['headers'])) ? $parmas['headers'] : [];

        $this->processHeaders($localHeaders);
        $this->processQuery($localQuery);

        $url = $this->baseUri . $endpoint . $this->queryProcessed;

        $options = [
            CURLOPT_USERAGENT => STATIC::USER_AGENT,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_ENCODING => "",
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $this->headersProcessed
        ];

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        //Checa Erro cURL
        if($response === false)
        {
            throw new \Exception("cURL Error: " . curl_error($curl) . ' - ' . $this->baseUri . $endpoint, 1);
        }

        $response = $this->convertResponse($response);

        //Checa Erro do retorno WebService
        if((int)$response->status !== 1)
        {
            $response->statusMessage = isoToUtf8(base64_decode($response->statusMessage));

            throw new \Exception("WebService: $response->statusMessage" , 1);
        }

        return $response;
    }

    public function addHeaders(array $headers)
    {
        foreach($headers as $key => $header)
        {
            $this->headers[$key] = $header;
        }
    }

    private function processHeaders(array $localHeaders = [])
    {
        if(!is_array($localHeaders))
        {
            throw new \Exception("Propriedade headers deve ser do tipo Array ['key' => value]", 1);
        }
        $this->headersProcessed = [];
        $headers = array_merge($this->headers, $localHeaders);

        foreach($headers as $key => $header)
        {
            $this->headersProcessed[] = "$key: $header";
        }
    }

    public function addQuery(array $queries)
    {
        foreach($queries as $key => $value)
        {
            $this->query[$key] = $value;
        }
    }

    private function processQuery($query = [])
    {
        if(!is_array($query))
        {
            throw new \Exception("Propriedade Query deve ser do tipo Array ['key' => value]", 1);
        }

        $this->queryProcessed = [];
        $query = array_merge($this->query, $query);

        if(empty($query))
        {
            return;
        }

        $array = [];

        foreach ($query as $key => $value)
        {
            $array[] = "$key=$value";
        }

        $this->queryProcessed = '?' . implode('&', $array);
    }


    private function convertResponse($response)
    {
        $firstChar = substr($response, 0, 1);

        switch ($firstChar)
        {
            case '{':
                return json_decode(isoToUtf8($response));
                break;
            case '<':
                return simpleXmlToObject($response);
                break;

            default:
                return false;
                break;
        }
    }
}
