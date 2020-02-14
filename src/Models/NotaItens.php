<?php

namespace WillyMaciel\Sankhya\Models;

use WillyMaciel\Sankhya\Interfaces\Arrayable;
use WillyMaciel\Sankhya\Interfaces\Xmlable;
use Tightenco\Collect\Support\Collection;
use \DOMDocument;

/**
 *  Container que controla os Itens da nota
 */
class NotaItens implements Arrayable, Xmlable
{
    /**
     * Coleção de Itens
     * @var Collection
     */
    private $itens;

    /**
     * Se true, valor do item informado em VLRUNIT ira sobreescrever
     * o preço do produto estabelecido no sistema
     * @var string
     */
    private $informarPreco = 'False';

    public function __construct(array $itens = null)
    {
        $this->itens = new Collection();

        if(!empty($itens))
        {
            foreach ($itens as $key => $item)
            {
                if(!is_a($item, 'NotaItem'))
                {
                    throw new \Exception("Item precisa ser do tipo NotaItem", 1);
                }

                $this->itens->add($item);
            }
        }
    }

    public function addItem(NotaItem $item)
    {
        $this->itens->add($item);
    }

    /**
    * Determina se o preco unitario sera informado no XML ou
    * se sera obtido da tabela de precos automaticamente.
    * @param  bool   $bool = True ou False
    * @return void
    */
    public function informarPreco(bool $bool)
    {
        $this->informarPreco = ($bool) ? 'True' : 'False';
    }

    /**
     * Transforma todos os itens da collection em array
     * @return Array
     */
    public function toArray()
    {
        $collection = $this->itens->map(function($value)
        {
            return $value->toArray();
        });

        $array['item'] = $collection->toArray();
        return $array;
    }

    /**
     * Retorna objeto como Xml
     * @return String Xml em formato texto
     */
    public function toXml()
    {
        $dom = new DOMDocument();
        $itens = $dom->createElement('itens');
        $itens->setAttribute('INFORMARPRECO', $this->informarPreco);

        $dom->appendChild($itens);

        foreach ($this->itens as $itemKey => $itemValues)
        {
            $item = new DOMDocument();
            $item->loadXML($itemValues->toXml());
            $item = $dom->importNode($item->documentElement, true);

            $itens->appendChild($item);
        }

        return $dom->saveXML($dom->documentElement);
    }
}
