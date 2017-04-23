<?php


namespace Combinator\Contract\Countable;


use Combinator\DTO\Countable;

interface CountableTransformer
{

    public function toCountable($representation) : Countable;

}
