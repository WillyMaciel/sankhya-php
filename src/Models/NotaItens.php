<?php

namespace WillyMaciel\Sankhya\Models;

use WillyMaciel\Sankhya\Interfaces\Arrayable;
use Tightenco\Collect\Support\Collection;

/**
 *  Container que controla os Itens da nota
 */
class NotaItens implements Arrayable
{
    /**
     * Coleção de Itens
     * @var Collection
     */
    private $itens;

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
     * Transforma todos os itens da collection em array
     * @return Array
     */
    public function toArray()
    {
        $collection = $this->itens->map(function($value)
        {
            return $value->toArray();
        });

        return $collection->toArray();
    }
}
