<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\Estado;
use MongoDB\BSON\ObjectId;
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
        $result = $this->mongoCollection->insertOne($estado->toArray());
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

    public function listarUm(string $id)
    {
        /** @var BSONDocument $result */
        $result = $this->mongoCollection->findOne(['_id' => new ObjectId($id)]);
        return (new Estado())->hidrate($result->getArrayCopy());
    }

    public function atualizar(string $id, Estado $estado): Estado
    {
        /** @var BSONDocument $result */
        $result = $this->mongoCollection->findOneAndUpdate(
            ['_id' => new ObjectId($id)],
            ['$set' => $estado->toArray()]
        );
        $estadoOriginal = (new Estado())->hidrate($result->getArrayCopy());

        return $estadoOriginal->hidrate($estado->toArray());
    }

    public function remover(string $id): int
    {
        $result = $this->mongoCollection->deleteOne(['_id' => new ObjectId($id)]);
        return $result->getDeletedCount();
    }
}
