<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Exception;

use Throwable;

class ValidacaoException extends \DomainException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = $code === 0 ? 415 : $code;
    }
}
