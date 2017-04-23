<?php

namespace Combinator\Test\Unit;

use Combinator\DAO\CountableDAO;
use Combinator\DTO\Countable;
use Combinator\Exception\Value\InvalidNameException;
use Combinator\HTTP\Response\Invalid\InvalidNameResponse;
use Combinator\HTTP\Response\Valid\ItemCreatedResponse;
use Combinator\Transformer\JsonCountableTransformer;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Combinator\Handler\CreateCountableHandler;

class CreateCountableHandlerTest extends TestCase
{

    public function testCreatingGetsRequestBody()
    {
        $transformer = $this->createMock(JsonCountableTransformer::class);
        $dao = $this->createMock(CountableDAO::class);
        $handler = new CreateCountableHandler($transformer, $dao);

        $request = $this->createMock(Request::class);
        $request->method('getBody');

        $request->expects($this->once())->method('getBody');

        $handler->create($request);
    }

    public function testInvalidNameResponseReturnedWhenInvalidNameExceptionIsThrownByTransformer() {
        $transformer = $this->createMock(JsonCountableTransformer::class);

        $exception = new InvalidNameException();
        $transformer->method('toCountable')->willThrowException($exception);

        $dao = $this->createMock(CountableDAO::class);

        $handler = new CreateCountableHandler($transformer, $dao);

        $request = $this->createMock(Request::class);

        $response = $handler->create($request);

        $this->assertInstanceOf(InvalidNameResponse::class, $response);
    }

    public function testReturnsItemCreatedResponseWhenNoExceptionIsThrownByTransformer() {
        $transformer = $this->createMock(JsonCountableTransformer::class);
        $dao = $this->createMock(CountableDAO::class);

        $handler = new CreateCountableHandler($transformer, $dao);

        $request = $this->createMock(Request::class);

        $response = $handler->create($request);

        $this->assertInstanceOf(ItemCreatedResponse::class, $response);
    }

    public function testCreatingCallsSaveMethodForCountableDAO() {
        $countable = new Countable(0, 'test-name');

        $transformer = $this->createMock(JsonCountableTransformer::class);
        $transformer->method('toCountable')->willReturn($countable);

        $dao = $this->createMock(CountableDAO::class);
        $dao
            ->expects($this->once())
            ->method('save')
            ->with($countable);

        $handler = new CreateCountableHandler($transformer, $dao);

        $request = $this->createMock(Request::class);

        $handler->create($request);
    }

}
