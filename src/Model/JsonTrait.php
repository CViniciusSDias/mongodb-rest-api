<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Model;

trait JsonTrait
{
    public function toArray(): array
    {
        return $dados = array_filter(get_object_vars($this));
    }
}
