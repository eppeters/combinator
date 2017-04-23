<?php

namespace phpunit;

use Combinator\DTO\Countable;
use PHPUnit\Framework\TestCase;

class CountableTest extends TestCase
{

    public function testDefaultArgsToConstructorSetValueToZero() {
        $countable = new Countable(null, 'name');
        $this->assertEquals(0, $countable->getValue());
    }

    public function testNamePassedToConstructorIsNotDifferentWhenGottenFromGetter() {
        $countable = new Countable(null, 'test-name');
        $this->assertEquals('test-name', $countable->getName());
    }

}
