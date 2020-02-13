<?php

namespace WillyMaciel\Sankhya\Clients;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Uri;

/**
 *
 */
class GuzzleClient implements Client
{
    private $client;
    private $queryStrings = [];
    private $headers;
    private $cookies;

    function __construct($baseUri)
    {
        $this->baseUri = $baseUri;
        $this->headers = [
            'User-Agent'    => 'SWServiceInvoker',
            'Cache-Control' => 'no-cache',
            'Cookie'        => ''
        ];

        $this->client = new GuzzleHttpClient([
            'base_uri'      => $baseUri,
            'timeout'       => 10,
            'cookies'       => true,
            'headers'       => $this->headers
        ]);

        $this->cookies = new CookieJar();
    }

    public function get($endpoint, $options = [])
    {
        return $this->request('GET', $endpoint, $options);
    }

    public function post($endpoint, $options = [])
    {
        return $this->request('GET', $endpoint, $options);
    }

    private function request($method = 'GET', $endpoint, $options = [])
    {
        //Junta queryStrings padrões com as enviadas no body
        $options['query'] = isset($options['query'])  ? array_merge($options['query'], $this->queryStrings) : $this->queryStrings;
        $options['cookies'] = $this->cookies;
        $options['headers'] = $this->headers;

        $body = (isset($options['body']) ? $options['body'] : null);

        $uri = new Uri($endpoint);
        $uri = Uri::withQueryValues($uri, $options['query']);
        dump($uri);
        $request = new Request($method, $uri, $this->headers, $body);
        //$response = $this->client->request($method, $endpoint, $options);
        $response = $this->client->send($request, $options);
        dump($request, $response, $options);

        //$response = $this->transformResponse($response);

        return $response;
    }

    // private function transformResponse($response)
    // {
    //     $contentType = explode(';', $response->getHeader('Content-Type')[0])[0];
    //     switch ($contentType)
    //     {
    //         case 'text/xml':
    //             return simpleXmlToObject(simplexml_load_string($response->getBody()->getContents()));
    //             break;
    //         case 'application/json':
    //             return json_decode(($response->getBody()->getContents()));
    //             break;
    //     }
    // }

    public function setDefaultQueryStrings(array $queryStrings)
    {
        $this->queryStrings = $queryStrings;
    }

    public function setCookies(array $cookies)
    {
        $jar = CookieJar::fromArray(
            $cookies,
            $this->baseUri
        );

        $this->cookies = $jar;
    }

    public function addHeaders(array $headers)
    {
        foreach($headers as $key => $header)
        {
            $this->headers[$key] = $header;
        }
    }

}
