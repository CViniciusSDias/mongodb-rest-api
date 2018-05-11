<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Service;

use MongoDB\BSON\UTCDateTime;

class ConversorDeData
{
    public function stringParaDataMongo(string $data): UTCDateTime
    {
        $dataPhp = new \DateTime($data);
        // Multiplicação devido aos milisegundos que o PHP não adiciona
        $dataMongo = new UTCDateTime($dataPhp->getTimestamp() * 1000);

        return $dataMongo;
    }
}
