<?php

namespace Combinator\Contract\Json;

interface JsonTransformer
{

    public function toJson(Jsonable $item) : string;

}
