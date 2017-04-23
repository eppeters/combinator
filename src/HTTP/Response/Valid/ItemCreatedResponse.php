<?php


namespace Combinator\HTTP\Response\Valid;


use Combinator\HTTP\Response\Response;

class ItemCreatedResponse extends Response
{

    public function __construct(
        $status = 201,
        array $headers = [],
        $body = null,
        $version = '1.1',
        $reason = null
    ) {
        parent::__construct($status, $headers, $body, $version, $reason);
    }

}
