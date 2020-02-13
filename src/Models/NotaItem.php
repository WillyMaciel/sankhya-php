<?php

namespace WillyMaciel\Sankhya\Models;

use WillyMaciel\Sankhya\Interfaces\Arrayable;

/**
 *
 */
class NotaItem implements Arrayable
{
    private $NUNOTA;
    private $SEQUENCIA;
    private $CODPROD;
    private $CODVOL;
    private $CODLOCALORIG;
    private $CONTROLE;
    private $QTDNEG;
    private $VLRUNIT;
    private $PERCDESC;

    public function setNuNota($nunota)
    {
        $this->NUNOTA = $nunota;
    }

    public function setSequencia($sequencia)
    {
        $this->SEQUENCIA = $sequencia;
    }

    public function setCodProd(int $codprod)
    {
        $this->CODPROD = $codprod;
    }

    public function setCodVol(string $codvol)
    {
        $this->CODVOL = $codvol;
    }

    public function setCodLocalOrig($codlocalorig)
    {
        $this->CODLOCALORIG = $codlocalorig;
    }

    public function setControle($controle)
    {
        $this->CONTROLE = $controle;
    }

    public function setQtdNeg(int $qtdneg)
    {
        $this->QTDNEG = $qtdneg;
    }

    public function setVlrUnit($vlrunit)
    {
        $this->VLRUNIT = $vlrunit;
    }

    public function setPercDesc($percdesc)
    {
        $this->PERCDESC = $percdesc;
    }

    public function getNuNota()
    {
        return $this->NUNOTA;
    }

    public function getSequencia()
    {
        return $this->SEQUENCIA;
    }

    public function getCodProd()
    {
        return $this->CODPROD;
    }

    public function getCodVol()
    {
        return $this->CODVOL;
    }

    public function getCodLocalOrig()
    {
        return $this->CODLOCALORIG;
    }

    public function getControle()
    {
        return $this->CONTROLE;
    }

    public function getQtdNeg()
    {
        return $this->QTDNEG;
    }

    public function getVlrUnit()
    {
        return $this->VLRUNIT;
    }

    public function getPercDesc()
    {
        return $this->PERCDESC;
    }

    public function toArray()
    {
        $array = [
            'NUNOTA'        => $this->NUNOTA,
            'SEQUENCIA'     => $this->SEQUENCIA,
            'CODPROD'       => $this->CODPROD,
            'CODVOL'        => $this->CODVOL,
            'CODLOCALORIG'  => $this->CODLOCALORIG,
            'CONTROLE'      => $this->CONTROLE,
            'QTDNEG'        => $this->QTDNEG,
            'VLRUNIT'       => $this->VLRUNIT,
            'PERCDESC'      => $this->PERCDESC
        ];

        return $array;
    }
}
