<?php

declare(strict_types=1);

namespace Exceptions;

use Throwable;

class UnexpectedModelException extends \Exception
{

    public function __construct(
        string $model,
        string $message = 'Invalid model "%s" given',
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct(sprintf($message, $model), $code, $previous);
    }
}
