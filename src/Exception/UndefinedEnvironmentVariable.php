<?php


namespace Combinator\Exception;

use Exception;
use Throwable;


class UndefinedEnvironmentVariable extends Exception
{
    const MESSAGE_TEMPLATE = 'Undefined environment variable: %s';

    /**
     * UndefinedEnvironmentVariable constructor.
     * @param string $envVarName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $envVarName = "",
        $code = 0,
        Throwable $previous = null
    ) {
        $message = sprintf(static::MESSAGE_TEMPLATE, $envVarName);

        parent::__construct($message, $code, $previous);
    }
}
