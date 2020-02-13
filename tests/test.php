<?php

namespace willymaciel\tests;

use WillyMaciel\Sankhya\SwServiceInvoker;
use WillyMaciel\Sankhya\Models\Nota;
use WillyMaciel\Sankhya\Models\NotaCabecalho;
use WillyMaciel\Sankhya\Models\NotaItem;
use WillyMaciel\Sankhya\Services\CacSp;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

//Instancia api passando o endereço do servidor sankhya
$api = new SwServiceInvoker('http://swhomologa.ramada.local:8180/');

//Senha pode ser a senha plaintext ou o md5 do usuário + senha concatenados
//O metodo login detecta ambos automaticamente
// $api->login('KOBI', '113b1809e3c7efafe6d6cba44cbe7f08');
$api->login('KOBI', 'admkobi12');

//Realiza uma query
//$result = $api->dbExplorer('SELECT * FROM TSIUSU');

//Dump resultados
//dump($result);

$notaCabecalho = new NotaCabecalho();
$notaCabecalho->setTipMov('P');
$notaCabecalho->setDtNeg(date("d/m/Y"));
$notaCabecalho->setCodTipVenda(234);
$notaCabecalho->setCodParc(2190);
$notaCabecalho->setCodTipOper(1033);
$notaCabecalho->setCodEmp(1);
$notaCabecalho->setCodVend(777);
$notaCabecalho->setCodNat(1010101);
$notaCabecalho->setCifFob('C');
$notaCabecalho->setCodCenCus(0);
$notaCabecalho->setCustomField('ad_kobinumped', '');
$notaCabecalho->setObservacao('Pedido criado pelo Package WillyMaciel\\Sankhya-php');
$notaCabecalho->setCustomField('ad_obsintmob', '');

$nota = new Nota($notaCabecalho);

$item = new NotaItem();
$item->setCodProd(10961);
$item->setCodVol('UN');
$item->setQtdNeg(10);

$nota->addItem($item);

dd($api->incluirNota($nota));


dump($notaCabecalho, $notaCabecalho->toArray());

dump($nota, $nota->toArray());

dump($item);



//Logout do servidor
//para liberar recursos e licença
$api->logout();
