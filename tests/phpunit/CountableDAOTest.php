<?php

namespace Combinator\Test\Unit;

use Combinator\DAO\CountableSQLDAO;
use Combinator\DTO\Countable;
use Combinator\Exception\Location\ItemNotFoundException;
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
        $countableGetters = ['getName', 'getValue'];

        $countable = $this->createMock(Countable::class);

        array_walk(
            $countableGetters,
            function ($getter) use ($countable) {
                $countable->expects($this->once())->method($getter);
            }
        );

        $pdo = $this->getBasePDOMock();

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->save($countable);
    }

    public function testSaveMethodUsesPreparedStatementExactlyOnce()
    {
        $countable = $this->createMock(Countable::class);

        $pdo = $this->getBasePDOMock();
        $pdo->expects($this->once())
            ->method('prepare');

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->save($countable);
    }

    public function testSaveMethodExecutesPreparedStatement() {
        $countable = $this->createMock(Countable::class);

        $preparedStatement = $this->createMock(\PDOStatement::class);
        $preparedStatement->expects($this->once())
            ->method('execute');

        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($preparedStatement);

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->save($countable);
    }

    public function testReadMethodUsesPreparedStatementExactlyOnce()
    {
        $preparedStatement = $this->createMock(\PDOStatement::class);
        $preparedStatement
            ->method('fetch')
            ->willReturn(['name' => 'name', 'id' => 1, 'value' => 0 ]);

        $pdo = $this->createMock(\PDO::class);
        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($preparedStatement);

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->read('name');
    }

    public function testReadMethodExecutesPreparedStatement() {
        $preparedStatement = $this->createMock(\PDOStatement::class);
        $preparedStatement->expects($this->once())
            ->method('execute');

        $preparedStatement
            ->method('fetch')
            ->willReturn(['name' => 'name', 'id' => 1, 'value' => 0 ]);

        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($preparedStatement);

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->read('name');
    }

    public function testReadMethodCallsFetchOnStatementExactlyOnce() {
        $preparedStatement = $this->createMock(\PDOStatement::class);
        $preparedStatement
            ->expects($this->once())
            ->method('fetch')
            ->willReturn(['name' => 'name', 'id' => 1, 'value' => 0 ]);

        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($preparedStatement);

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->read('name');
    }

    /**
     * @expectedException \Combinator\Exception\Location\ItemNotFoundException
     */
    public function testReadMethodThrowsItemNotFoundExceptionWhenStatementResultIsEmpty() {
        $preparedStatement = $this->createMock(\PDOStatement::class);
        $preparedStatement
            ->method('fetch')
            ->willReturn(null);

        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($preparedStatement);

        $countableDAO = new CountableSQLDAO($pdo);
        $countableDAO->read('name');
    }

}
