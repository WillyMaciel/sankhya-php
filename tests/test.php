<?php

namespace willymaciel\tests;

use WillyMaciel\Sankhya\SwServiceInvoker;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

//Instancia api passando o endereço do servidor sankhya
$api = new SwServiceInvoker('http://urldoservidor.com.br:8080/');

//Senha pode ser a senha plaintext ou o md5 do usuário + senha concatenados
//O metodo login detecta ambos automaticamente
$api->login('usuariosankhya', 'senha');

//Realiza uma query
$result = $api->dbExplorer('SELECT * FROM TSIUSU');

//Dump resultados
dump($result);

//Logout do servidor
//para liberar recursos e licença
$api->logout();
