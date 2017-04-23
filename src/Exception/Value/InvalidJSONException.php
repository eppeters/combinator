<?php


namespace Combinator\Exception\Value;

use Combinator\Exception\Exception;
use Throwable;

class InvalidJSONException extends Exception
{

    public function __construct(
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        if (!$message) {
            $message = "Invalid JSON";
        }
        parent::__construct($message, $code, $previous);
    }

}
