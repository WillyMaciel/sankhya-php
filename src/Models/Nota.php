<?php

namespace WillyMaciel\Sankhya\Models;

use WillyMaciel\Sankhya\Interfaces\Arrayable;
use WillyMaciel\Sankhya\Interfaces\Xmlable;
use \DOMDocument;

/**
 *
 */
class Nota implements Arrayable, Xmlable
{
    private $cabecalho;
    private $itens;

    public function __construct(NotaCabecalho $cabecalho, NotaItens $notaItens = null)
    {
        $this->cabecalho = $cabecalho;
        $this->itens = (empty($notaItens)) ? new NotaItens() : $notaItens;
    }

    /**
     * Adiciona um unico item ao NotaItens, função facilitadora
     * pode também ser utilizada diretamente no objeto NotaItens
     * @param NotaItem $item [description]
     */
    public function addItem(NotaItem $item)
    {
        $this->itens->addItem($item);
    }

    /**
     * Seta NotaItens manualmente
     * @param NotaItens $notaItens
     */
    public function setNotaItens(NotaItens $notaItens)
    {
        $this->itens = $notaItens;
    }

    /**
     * Determina se o preco unitario sera informado no XML ou
     * se sera obtido da tabela de precos automaticamente.
     * @param  bool   $bool = True ou False
     * @return void
     */
    public function informarPreco(bool $bool)
    {
        $this->itens->informarPreco($bool);
    }

    public function toArray()
    {
        $array = [
            'nota' => [
                'cabecalho' => $this->cabecalho->toArray(),
                'itens' => $this->itens->toArray()
            ]
        ];

        return $array;
    }

    /**
     * Retorna objeto como Xml
     * @return String Xml em formato texto
     */
    public function toXml()
    {
        $dom = new DOMDocument();
        $nota = $dom->createElement('nota');
        $dom->appendChild($nota);

        $cab = new DOMDocument();
        $cab->loadXML($this->cabecalho->toXml());
        $cab = $dom->importNode($cab->documentElement, true);
        $nota->appendChild($cab);

        $itens = new DOMDocument();
        $itens->loadXML($this->itens->toXml());
        $itens = $dom->importNode($itens->documentElement, true);
        $nota->appendChild($itens);

        return $dom->saveXML($dom->documentElement);
    }
}
