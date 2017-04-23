<?php

namespace Combinator\Test\Unit;

use Combinator\DAO\CountableDAO;
use Combinator\DTO\Countable;
use PHPUnit\Framework\TestCase;

class CountableDAOTest extends TestCase
{

    protected function getBasePDOMock()
    {
        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')
            ->willReturn($this->createMock(\PDOStatement::class));

        return $pdo;
    }

    public function testSaveMethodCallsGetForAllValuesOfCountable()
    {
        $countableGetters = ['getName', 'getValue', 'getId'];

        $countable = $this->createMock(Countable::class);

        array_walk(
            $countableGetters,
            function ($getter) use ($countable) {
                $countable->expects($this->once())->method($getter);
            }
        );

        $pdo = $this->getBasePDOMock();

        $countableDAO = new CountableDAO($pdo);
        $countableDAO->save($countable);
    }

    public function testSaveMethodUsesPreparedStatementExactlyOnce()
    {
        $countable = $this->createMock(Countable::class);

        $pdo = $this->getBasePDOMock();
        $pdo->expects($this->once())
            ->method('prepare');

        $countableDAO = new CountableDAO($pdo);
        $countableDAO->save($countable);
    }

    public function testSaveMethodExecutesPreparedStatement() {
        $countable = $this->createMock(Countable::class);

        $preparedStatement = $this->createMock(\PDOStatement::class);
        $preparedStatement->expects($this->once())
            ->method('execute');

        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($preparedStatement);

        $countableDAO = new CountableDAO($pdo);
        $countableDAO->save($countable);
    }

}
