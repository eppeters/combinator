<?php

namespace phpunit;

use Combinator\Exception\Value\InvalidJSONException;
use Combinator\Exception\Value\InvalidNameException;
use Combinator\Transformer\JsonCountableTransformer;
use PHPUnit\Framework\TestCase;

class JsonCountableTransformerTest extends TestCase
{

    public function testCountableTransformedFromJSONWithoutValueGetsAValueOfZero() {

        $jsonWithoutValue = '{ "name": "test" }';

        $transformer = new JsonCountableTransformer();
        $countable = $transformer->toCountable($jsonWithoutValue);

        $this->assertEquals(0, $countable->getValue());
    }

    /**
     * @expectedException \Combinator\Exception\Value\InvalidNameException
     */
    public function testCallingToCountableWithValidJsonWithoutANamePropertyThrowsInvalidNameException() {

        $jsonWithoutName = '{ "value": 0 }';

        $transformer = new JsonCountableTransformer();

        $transformer->toCountable($jsonWithoutName);
    }

    /**
     * @expectedException \Combinator\Exception\Value\InvalidJSONException
     */
    public function testCallingToCountableEmptyJSONStringThrowsInvalidJSONException() {

        $jsonWithoutName = '';

        $transformer = new JsonCountableTransformer();

        $transformer->toCountable($jsonWithoutName);
    }

    /**
     * @expectedException \TypeError
     */
    public function testCallingToCountableWithNULLJSONStringThrowsTypeError() {

        $jsonWithoutName = null;

        $transformer = new JsonCountableTransformer();

        $transformer->toCountable($jsonWithoutName);
    }

    /**
     * @expectedException \Combinator\Exception\Value\InvalidJSONException
     */
    public function testCallingToCountableWithInvalidJSONStringThrowsInvalidJSONException() {

        $invalidJSONString = '{';
        $transformer = new JsonCountableTransformer();

        $transformer->toCountable($invalidJSONString);
    }

}
