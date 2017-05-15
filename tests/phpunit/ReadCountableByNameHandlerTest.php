<?php

namespace phpunit;

use Combinator\DAO\CountableSQLDAO;
use Combinator\Exception\Location\ItemNotFoundException;
use Combinator\Handler\ReadCountableByNameHandler;
use Combinator\HTTP\Response\Invalid\ItemNotFoundResponse;
use Combinator\Transformer\CountableJsonTransformer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Route;

class ReadCountableByNameHandlerTest extends TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject $transformer */
    protected $transformer;
    /** @var  \PHPUnit_Framework_MockObject_MockObject $dao */
    protected $dao;
    /** @var  \PHPUnit_Framework_MockObject_MockObject $route */
    protected $route;
    /** @var  \PHPUnit_Framework_MockObject_MockObject $request */
    protected $request;

    public function setUp()
    {
        parent::setUp();

        $this->transformer = $this->createMock(CountableJsonTransformer::class);
        $this->dao = $this->createMock(CountableSQLDAO::class);
        $this->route = $this->createMock(Route::class);

        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->request
            ->method('getAttribute')
            ->willReturn($this->route);
    }

    public function testReadCallsGetArgumentWithNameArgumentOnRequestObject()
    {
        $this->route
            ->expects($this->once())
            ->method('getArgument')
            ->with('name')
            ->willReturn('a name');

        $this->request
            ->expects($this->once())
            ->method('getAttribute')
            ->with('route')
            ->willReturn($this->route);

        $handler = new ReadCountableByNameHandler($this->transformer, $this->dao);

        $handler->read($this->request);
    }

    public function testReadCallsToJsonOnTransformerObject()
    {
        $this->transformer
            ->expects($this->once())
            ->method('toJson');

        $handler = new ReadCountableByNameHandler($this->transformer, $this->dao);

        $handler->read($this->request);
    }

    public function testReadReturnsItemNotFoundResponseWhenDAOThrowsItemNotFoundException() {
        $this->dao
            ->method('read')
            ->willThrowException(new ItemNotFoundException());

        $handler = new ReadCountableByNameHandler($this->transformer, $this->dao);
        $response = $handler->read($this->request);

        $this->assertInstanceOf(ItemNotFoundResponse::class, $response);
    }
}
