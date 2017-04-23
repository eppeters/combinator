<?php


namespace Combinator\Contract\HTTP;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface CreateHandler
{

    public function create(RequestInterface $request): ResponseInterface;

}
