<?php


namespace Combinator\Handler;


use Combinator\Contract\DAO;
use Combinator\DAO\CountableSQLDAO;
use Combinator\Exception\Location\ItemNotFoundException;
use Combinator\HTTP\Response\Invalid\ItemNotFoundResponse;
use Combinator\HTTP\Response\Response;
use Combinator\Transformer\CountableJsonTransformer;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Route;

class ReadCountableByNameHandler implements \Combinator\Contract\HTTP\ReadHandler
{
    protected $dao;
    protected $transformer;

    public function __construct(CountableJsonTransformer $transformer, CountableSQLDAO $dao)
    {
        $this->transformer = $transformer;
        $this->dao = $dao;
    }

    public function read(ServerRequestInterface $request) : ResponseInterface {
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $name = $route->getArgument('name');

        try {
            $countable = $this->dao->read($name);
        } catch (ItemNotFoundException $exception) {
            return new ItemNotFoundResponse();
        }

        $countableJSON = $this->transformer->toJson($countable);

        $jsonStream = stream_for($countableJSON);
        $response = (new Response())->withBody($jsonStream);
        return $response;
    }
}
