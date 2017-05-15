<?php


namespace Combinator\Contract\HTTP;


use Combinator\Contract\DAO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ReadHandler
{
    public function read(ServerRequestInterface $request) : ResponseInterface;
}
