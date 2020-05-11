# Sankhya PHP API
Este package utiliza o package "tightenco/collect" como dependência, para retornar resultados como Collection (o mesmo utilizado no framework Laravel).

## Instalação via composer

``` bash
composer require willymaciel/sankhya-php
```

## Autenticação

### Login

``` php
require_once __DIR__ . '/vendor/autoload.php';
use WillyMaciel\Sankhya\SwServiceInvoker;

$api = new SwServiceInvoker('http://urldosankhya.com.br:8080/');
$api->login('usuario_sankhya', 'senha');
```

### Logout

```php
$api->logout();
```

## Services

### DbExplorer
Para utilizar o DbExplorer o usuário utilizado para Login deve ter permissão neste Modulo no SankhyaW.

OBS: o DbExplorer possui um limite de 5000 registros por query.

``` php
//Realiza uma query (Somente Select)
//Retorna os resultados em uma Collection
$result = $api->dbExplorer('SELECT * FROM TSIUSU');
dump($result);
```

###CacSp - Incluir Nota

Primeiro deve-se criar o Cabeçalho da nota, necessário para criar uma Nota, em seguida podemos incluir itens na nota.
Exemplo de inclusão de nota:

```

//Cria Cabeçalho
$notaCabecalho = new NotaCabecalho();
$notaCabecalho->setTipMov('P');
$notaCabecalho->setDtNeg('11/05/2020');
$notaCabecalho->setCodTipVenda(234);
$notaCabecalho->setCodParc(2190);
$notaCabecalho->setCodTipOper(1033);
$notaCabecalho->setCodEmp(1);
$notaCabecalho->setCodVend(777);
$notaCabecalho->setCodNat(1010101);
$notaCabecalho->setCifFob('C');
$notaCabecalho->setCodCenCus(0);
$notaCabecalho->setCustomField('algum_custom_field', 'valor');
$notaCabecalho->setObservacao('Pedido criado pelo Package WillyMaciel\\Sankhya-php');

//Cria a nota enviando o cabeçalho no constructor
$nota = new Nota($notaCabecalho);
//utilize informarPreco = true se pretende informar o preço de cada item manualmente
// $nota->informarPreco(true);


//Cria itens e vincula a nota
$item = new NotaItem();
$item->setCodProd(10961);
$item->setCodVol('UN');
$item->setCodLocalOrig(0);
$item->setQtdNeg(1);
$item->setPercDesc(0);
$item->setVlrUnit(50);

$nota->addItem($item);

$item = new NotaItem();
$item->setCodProd(30068);
$item->setCodVol('UN');
$item->setCodLocalOrig(0);
$item->setQtdNeg(1);
$item->setPercDesc(0);
$item->setVlrUnit(60);

$nota->addItem($item);

//Chamada para incluir a nota no sankhya
dump($api->incluirNota($nota));

```
