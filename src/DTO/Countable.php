<?php


namespace Combinator\DTO;


use Combinator\Exception\Value\InvalidNameException;
use Combinator\Contract\DTO;

class Countable implements DTO
{
    protected $id;
    protected $name;
    protected $value;

    public function __construct(?int $id = null, string $name, int $value = 0) {
        if (strlen($name) === 0) {
            throw new InvalidNameException('Countable name must be at least 1 character');
        }

        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getValue() : int {
        return $this->value;
    }

}
