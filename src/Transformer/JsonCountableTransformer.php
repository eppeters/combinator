<?php


namespace Combinator\Transformer;

use Combinator\Contract\Countable\CountableTransformer;
use Combinator\DTO\Countable;
use Combinator\Exception\Value\InvalidJSONException;
use Combinator\Exception\Value\InvalidNameException;


class JsonCountableTransformer implements CountableTransformer
{

    protected $decodedJson;

    /**
     * @throws InvalidNameException
     */
    protected function decodeJson(string $representation) {
        $decodedJson = json_decode($representation, true);
        if (!$decodedJson) {
            throw new InvalidJSONException('Invalid JSON: ' . json_last_error_msg());
        }

        if (!isset($decodedJson['name']) || !is_string($decodedJson['name'])) {
            throw new InvalidNameException('Countable must have a name');
        }

        return $decodedJson;
    }

    /**
     * @throws InvalidNameException
     */
    public function toCountable($representation) : Countable {
        $decodedJson = $this->decodeJson($representation);

        return new Countable(
            null,
            $decodedJson['name']
        );
    }

}
