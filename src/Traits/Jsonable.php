<?php

namespace WillyMaciel\Sankhya\Traits;

trait Jsonable
{
    public function toJson($data)
    {
        return json_encode($data);
    }
}
