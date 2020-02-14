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
//$notaCabecalho->setDtNeg(date("d/m/Y"));
$notaCabecalho->setDtNeg('12/02/2020');
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

//Incluir Nota
$nota = new Nota($notaCabecalho);
// $nota->informarPreco(true);

$item = new NotaItem();
$item->setCodProd(10961);
$item->setCodVol('UN');
$item->setCodLocalOrig(0);
$item->setQtdNeg(13);
$item->setPercDesc(0);
$item->setVlrUnit(50);

$nota->addItem($item);

$item = new NotaItem();
$item->setCodProd(30068);
$item->setCodVol('UN');
$item->setCodLocalOrig(0);
$item->setQtdNeg(13);
$item->setPercDesc(0);
$item->setVlrUnit(60);

$nota->addItem($item);

dump($api->incluirNota($nota));

//Logout do servidor
//para liberar recursos e licença
$api->logout();
