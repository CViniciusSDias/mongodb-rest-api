<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Service;

use CViniciusSDias\MongoDbRestApi\Exception\ValidacaoException;
use MongoDB\BSON\UTCDateTime;

class ConversorDeData
{
    public function stringParaDataMongo(string $data): UTCDateTime
    {
        $data = filter_var($data, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/[0-9]{2}-[0-9]{2}-[0-9]/']]);
        if (false === $data) {
            throw new ValidacaoException('Formato de data inválido. Formato correto: YYYY-MM-DD');
        }
        $dataPhp = new \DateTime($data);
        // Multiplicação devido aos milisegundos que o PHP não adiciona
        $dataMongo = new UTCDateTime($dataPhp->getTimestamp() * 1000);

        return $dataMongo;
    }
}
