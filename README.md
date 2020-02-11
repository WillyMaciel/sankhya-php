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
