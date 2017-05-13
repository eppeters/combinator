<?php


namespace Combinator\DAO;


use Combinator\Contract\DAO;
use Combinator\Contract\DTO;

class CountableSQLDAO extends DAO
{

    public function __construct(\PDO $handler)
    {
        parent::__construct($handler);
    }

    /**
     * @param Countable
     */
    public  function save(DTO $countable)
    {

        $countableSavingSQL = $this->handler->prepare('');
        $countableSavingSQL->execute([
            $countable->getId(),
            $countable->getName(),
            $countable->getValue()
        ]);
    }

}