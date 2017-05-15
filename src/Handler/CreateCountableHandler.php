<?php


namespace Combinator\Handler;


use Combinator\Contract\Countable\CountableTransformer;
use Combinator\Contract\HTTP\CreateHandler;
use Combinator\DAO\CountableSQLDAO;
use Combinator\Exception\Value\InvalidNameException;
use Combinator\HTTP\Response\Invalid\InvalidNameResponse;
use Combinator\HTTP\Response\Valid\ItemCreatedResponse;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CreateCountableHandler implements CreateHandler
{

    protected $transformer;
    protected $dao;

    public function __construct(CountableTransformer $transformer, CountableSQLDAO $dao)
    {
        $this->transformer = $transformer;
        $this->dao = $dao;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function create(RequestInterface $request) : ResponseInterface {
        $jsonBody = $request->getBody();

        try {
            $countable = $this->transformer->toCountable($jsonBody);
            $this->dao->save($countable);
            $response = new ItemCreatedResponse();
        } catch (InvalidNameException $exception) {
            $response = new InvalidNameResponse();
            $response->withBody(stream_for('Invalid name: ' . $exception->getMessage()));
        }

        return $response;
    }

}
