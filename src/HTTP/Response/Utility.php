<?php

namespace Combinator\HTTP\Response\Utility {

    /**
     * Creates a JSON object string with a 'message' key and the given $message as
     * the value.
     *
     * @param string $message
     */
    function jsonResponseBodyMessage(string $message) : string {
        return json_encode([
            "message" => $message
        ]);
    }
}
