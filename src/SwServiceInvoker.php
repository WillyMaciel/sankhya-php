<?php

namespace WillyMaciel\Sankhya;

use WillyMaciel\Sankhya\Clients\Client;
use WillyMaciel\Sankhya\Clients\CurlClient;
use WillyMaciel\Sankhya\Services\Autenticacao;
use WillyMaciel\Sankhya\Services\DbExplorerSp;
use WillyMaciel\Sankhya\Services\CacSp;
use WillyMaciel\Sankhya\Models\Nota;
/**
 *
 */
class SwServiceInvoker
{
    private $client;
    private $enderecoServidor;
    private $jSessionId;

    /**
     * @param string
     * @param Client|null
     */
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

    /**
     * @param  string $nomeUsuario
     * @param  string $senha //senha em plain text ou MD5 concatenando o nome do usuário com a senha.
     * @return void
     */
    public function login(string $nomeUsuario, string $senha)
    {
        $autenticacao = new Autenticacao($this->client);
        $this->jSessionId = $autenticacao->login($nomeUsuario, $senha);

        $this->client->addHeaders(['Cookie' => "JSESSIONID=$this->jSessionId"]);
        $this->client->addQuery(['mgeSession' => $this->jSessionId]);
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

    /**
     * @param  string $query
     * @return Collection
     */
    public function dbExplorer($query)
    {
        $dbExplorer = new DbExplorerSp($this->client);

        return $dbExplorer->executeQuery($query);
    }

    public function incluirNota(Nota $nota)
    {
        $cacSp = new CacSp($this->client);

        return $cacSp->incluirNota($nota);
    }
}
