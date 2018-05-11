<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\Estado;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;

class EstadosRepository
{
    /**
     * @var Collection
     */
    private $mongoCollection;

    public function __construct(Database $mongoDatabase)
    {
        $this->mongoCollection = $mongoDatabase->selectCollection('estados');
    }

    public function inserir(Estado $estado): Estado
    {
        $result = $this->mongoCollection->insertOne($estado->jsonSerialize());
        $objectId = (string) $result->getInsertedId();
        return $estado->setId($objectId);
    }

    public function listarTodos(): array
    {
        $result = $this->mongoCollection->find();
        $estadoList = [];
        /** @var BSONDocument $estado */
        foreach ($result->toArray() as $estado) {
            $estadoList[] = (new Estado())->hidrate($estado->getArrayCopy());
        };

        return $estadoList;
    }
}
