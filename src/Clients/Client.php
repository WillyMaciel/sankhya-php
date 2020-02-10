<?php

namespace WillyMaciel\Sankhya\Clients;

interface Client
{
    public function __construct($baseUri);
	public function post($endpoint, $data);
    public function get($endpoint, $data);
    public function addHeaders(array $headers);
}
