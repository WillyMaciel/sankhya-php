<?php

namespace WillyMaciel\Sankhya\Models;

use WillyMaciel\Sankhya\Interfaces\Arrayable;

/**
 *
 */
class NotaCabecalho implements Arrayable
{
    private $NUNOTA;
    private $TIPMOV;
    private $DTNEG;
    private $CODTIPVENDA;
    private $CODPARC;
    private $CODTIPOPER;
    private $CODEMP;
    private $CODVEND;
    private $CODNAT;
    private $CIF_FOB;
    private $CODCENCUS;
    private $OBSERVACAO;
    private $customFields = [];

    public function setNunota($nunota)
    {
        $this->NUNOTA = $nunota;
    }

    public function setTipMov($tipmov)
    {
        $this->TIPMOV = $tipmov;
    }

    public function setDtNeg($dtneg)
    {
        $this->DTNEG = $dtneg;
    }

    public function setCodTipVenda($codtipvenda)
    {
        $this->CODTIPVENDA = $codtipvenda;
    }

    public function setCodParc($codparc)
    {
        $this->CODPARC = $codparc;
    }

    public function setCodTipOper($codtipoper)
    {
        $this->CODTIPOPER = $codtipoper;
    }

    public function setCodEmp($codemp)
    {
        $this->CODEMP = $codemp;
    }

    public function setCodVend($codvend)
    {
        $this->CODVEND = $codvend;
    }

    public function setCodNat($codnat)
    {
        $this->CODNAT = $codnat;
    }

    public function setCifFob($ciffob)
    {
        $this->CIF_FOB = $ciffob;
    }

    public function setCodCenCus($codcencus)
    {
        $this->CODCENCUS = $codcencus;
    }

    public function setObservacao($observacao)
    {
        $this->OBSERVACAO = $observacao;
    }

    public function setCustomField($fieldName, $fieldValue)
    {
        $this->customFields[strtoupper($fieldName)] = $fieldValue;
    }

    public function getNunota()
    {
        return $this->NUNOTA;
    }

    public function getTipMov()
    {
        return $this->TIPMOV;
    }

    public function getDtNeg()
    {
        return $this->DTNEG;
    }

    public function getCodTipVenda()
    {
        return $this->CODTIPVENDA;
    }

    public function getCodParc()
    {
        return $this->CODPARC;
    }

    public function getCodTipOper()
    {
        return $this->CODTIPOPER;
    }

    public function getCodEmp()
    {
        return $this->CODEMP;
    }

    public function getCodVend()
    {
        return $this->CODVEND;
    }

    public function getCodNat()
    {
        return $this->CODNAT;
    }

    public function getCifFob()
    {
        return $this->CIF_FOB;
    }

    public function getCodCenCus()
    {
        return $this->CODCENCUS;
    }

    public function getObservacao()
    {
        return $this->OBSERVACAO;
    }

    public function getCustomField($fieldName)
    {
        return $this->customFields[$fieldName];
    }

    public function toArray()
    {
        $array =  [
            'NUNOTA' => $this->NUNOTA,
            'TIPMOV' => $this->TIPMOV,
            'DTNEG'  => $this->DTNEG,
            'CODTIPVENDA' => $this->CODTIPVENDA,
            'CODPARC' => $this->CODPARC,
            'CODTIPOPER' => $this->CODTIPOPER,
            'CODEMP' => $this->CODEMP,
            'CODVEND' => $this->CODVEND,
            'CODNAT' => $this->CODNAT,
            'CIF_FOB' => $this->CIF_FOB,
            'CODCENCUS' => $this->CODCENCUS,
            'OBSERVACAO' => $this->OBSERVACAO
        ];

        foreach($this->customFields as $key => $value)
        {
            $array[$key] = $value;
        }

        return $array;
    }
}


