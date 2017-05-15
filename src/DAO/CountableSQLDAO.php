<?php


namespace Combinator\DAO;


use Combinator\Contract\DAO;
use Combinator\Contract\DTO;
use Combinator\DTO\Countable;
use Combinator\Exception\Location\ItemNotFoundException;

class CountableSQLDAO extends DAO
{

    public function __construct(\PDO $handler)
    {
        parent::__construct($handler);
    }

    /**
     * @param Countable
     */
    public function save(DTO $countable)
    {
        $countableSavingSQL = $this->handler->prepare(
            'INSERT INTO countable (name, value) VALUES (?, ?);'
        );

        $countableSavingSQL->execute([
            $countable->getName(),
            $countable->getValue()
        ]);
    }

    public function read($name) : Countable {
        $countableReadingSQL = $this->handler->prepare(
            'SELECT * FROM countable WHERE name = ?'
        );
        $countableReadingSQL->execute([ $name ]);

        $countableValues = $countableReadingSQL->fetch(\PDO::FETCH_ASSOC);

        if (is_null($countableValues)) {
            throw new ItemNotFoundException("Cannot find countable with name $name");
        }

        $countable = new Countable(
            $countableValues['id'],
            $countableValues['name'],
            $countableValues['value']
        );

        return $countable;
    }

}
