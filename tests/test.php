<?php

namespace willymaciel\tests;

use WillyMaciel\Sankhya\SwServiceInvoker;
use WillyMaciel\Sankhya\Clients\Client;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using

$api = new SwServiceInvoker('http://urldoservidor.com.br:8080/');

//Senha pode ser a senha plaintext ou o md5 do usuário + senha
//O metodo login detecta ambos automaticamente
$api->login('usuariosankhya', 'senha');

$result = $api->dbExplorer('SELECT * FROM TSIUSU');
dump($result);

$api->logout();
