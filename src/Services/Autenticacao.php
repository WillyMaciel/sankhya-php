<?php

namespace WillyMaciel\Sankhya\Services;

use WillyMaciel\Sankhya\Clients\Client;
use WillyMaciel\Sankhya\Traits\XmlRequest;

/**
 *
 */
class Autenticacao extends BaseService
{
    use XmlRequest;

    CONST MODULO = 'mge';
    CONST SERVICE_NAME = 'MobileLoginSP';

    private $nomusu;
    private $interno;
    private $interno2;
    private $jSessionId;

    /**
     * Autentica usuário no servidor Sankhya
     * @param  string $nomusu  Nome do usuário Sankhya
     * @param  string $interno Senha do usuário em plaintext ou md5 do login concatenado com a senha
     * @return string          Se logado, retorna o JSessionId
     */
    public function login($nomusu, $interno)
    {
        $this->nomusu = strtoupper($nomusu);
        $this->interno = $interno;
        $this->interno2 = isValidMd5($interno) ? $interno : md5($nomusu . $interno);

        $body = [
            'NOMUSU'    => $this->nomusu,
            'INTERNO2'  => $this->interno2
        ];

        $serviceName = $this->getServiceName('login');
        $body = $this->makeServiceRequest($serviceName, $body);

        $endPoint = $this->getUri('login');

        $response = $this->client->get($endPoint, $body);
        $this->jSessionId = $response->responseBody->jsessionid;

        return $this->jSessionId;
    }

    /**
     * Termina a sessão do usuário no Sankhya, liberando licença e recursos no servidor.
     * @return bool True se deslogado sem erros
     */
    public function logout()
    {
        $endPoint = $this->getUri('logout');
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
