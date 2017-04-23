<?php


namespace Combinator\Contract;


abstract class DAO
{

    public function __construct(\PDO $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return void
     */
    public abstract function save(DTO $dto);

}
