<?php

namespace WillyMaciel\Sankhya\Models;

use WillyMaciel\Sankhya\Interfaces\Arrayable;

/**
 *
 */
class Nota implements Arrayable
{
    private $cabecalho;
    private $itens;

    public function __construct(NotaCabecalho $cabecalho, NotaItens $notaItens = null)
    {
        $this->cabecalho = $cabecalho;
        $this->itens = (empty($notaItens)) ? new NotaItens() : $notaItens;
    }

    public function addItem(NotaItem $item)
    {
        $this->itens->addItem($item);
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
}
