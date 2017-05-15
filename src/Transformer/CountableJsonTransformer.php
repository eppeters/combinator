<?php


namespace Combinator\Transformer;


use Combinator\Contract\Json\Jsonable;
use Combinator\Contract\Json\JsonTransformer;
use Combinator\DTO\Countable;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class CountableJsonTransformer implements JsonTransformer
{

    /**
     * @param Jsonable $countable
     * @return string
     */
    public function toJson(Jsonable $countable) : string
    {
        if (!$countable instanceof Countable) {
            throw new InvalidTypeException();
        }

        return $countable->toJson();
    }

}
