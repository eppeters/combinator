<?php


namespace Combinator\Contract\Json;


interface Jsonable
{
    public function toJson() : string;
}
