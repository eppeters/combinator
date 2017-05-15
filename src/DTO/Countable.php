<?php


namespace Combinator\DTO;


use Combinator\Contract\Json\Jsonable;
use Combinator\Exception\Value\InvalidJSONException;
use Combinator\Exception\Value\InvalidNameException;
use Combinator\Contract\DTO;

class Countable implements DTO, Jsonable
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

    public function toJson() : string
    {
        $arrayRepresentation = [
            'name' => $this->name,
            'value' => $this->value
        ];

        $json_representation = json_encode($arrayRepresentation);
        if ($json_representation === false) {
            throw new InvalidJSONException(
                "Unable to turn Countable into string. Original countable: " .
                print_r($arrayRepresentation, true)
            );
        }

        return $json_representation;
    }

}
