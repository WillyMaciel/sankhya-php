<?php

namespace WillyMaciel\Sankhya;

use WillyMaciel\Sankhya\Clients\Client;
use WillyMaciel\Sankhya\Clients\CurlClient;
use WillyMaciel\Sankhya\Resources\Autenticacao;
use WillyMaciel\Sankhya\Resources\DbExplorerSp;
/**
 *
 */
class SwServiceInvoker
{
    private $client;
    private $enderecoServidor;
    private $jSessionId;

    function __construct(string $enderecoServidor, Client $client = NULL)
    {
        $this->enderecoServidor = $enderecoServidor;

        if(empty($client))
        {
            $this->client = new CurlClient($enderecoServidor);
        }
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function login($nomeUsuario, $senha)
    {
        $autenticacao = new Autenticacao($this->client);
        $this->jSessionId = $autenticacao->login($nomeUsuario, $senha);

        $this->client->addHeaders(['Cookie' => "JSESSIONID=$this->jSessionId"]);
    }

    public function logout()
    {
        if(!empty($this->jSessionId))
        {
            $autenticacao = new Autenticacao($this->client);
            if($autenticacao->logout())
            {
                $this->jSessionId = null;
            }

        }
    }

    public function dbExplorer($query)
    {
        $dbExplorer = new DbExplorerSp($this->client);

        return $dbExplorer->executeQuery($query);
    }
}
