<?php


namespace Combinator\HTTP\Response\Invalid;


use Combinator\HTTP\Response\Response;

class ItemNotFoundResponse extends Response
{
    public function __construct(
        $status = 404,
        array $headers = [],
        $body = null,
        $version = '1.1',
        $reason = null
    ) {
        parent::__construct($status, $headers, $body, $version, $reason);
    }
}
