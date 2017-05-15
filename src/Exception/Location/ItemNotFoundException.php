<?php

namespace Combinator\Exception\Location;


use Combinator\Exception\Exception;
use Throwable;

class ItemNotFoundException extends Exception
{

    public function __construct(
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        if (!$message) {
            $message = "Item not found.";
        }
        parent::__construct($message, $code, $previous);
    }

}
