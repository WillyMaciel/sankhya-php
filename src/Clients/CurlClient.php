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
    private $headers;
    private $headersProcessed;
    private $cookies;

    function __construct($baseUri)
    {
        $this->baseUri = $baseUri;

        $this->headers = [
            "Cache-Control: no-cache",
            "Content-Type: text/xml;charset=ISO-8859-1"
        ];
    }

    public function get($endpoint, $body = [])
    {
        return $this->request('GET', $endpoint, $body);
    }

    public function post($endpoint, $body = [])
    {
        return $this->request('GET', $endpoint, $body);
    }

    private function request($method = 'GET', $endpoint, $body = NULL)
    {
        $curl = curl_init();

        $body = (is_array($body)) ? http_build_query($body) : $body;
        $this->processHeaders();

        $options = [
            CURLOPT_USERAGENT => STATIC::USER_AGENT,
            CURLOPT_URL => $this->baseUri . $endpoint,
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

    private function processHeaders()
    {
        $this->headersProcessed = [];
        foreach($this->headers as $key => $header)
        {
            $this->headersProcessed[] = "$key: $header";
        }
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
