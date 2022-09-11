<?php

declare(strict_types=1);

namespace Exceptions;

use Throwable;

class InvalidTableException extends \Exception
{

    public function __construct(
        string $table,
        string $message = 'Invalid table name "%s" given',
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct(sprintf($message, $table), $code, $previous);
    }
}
