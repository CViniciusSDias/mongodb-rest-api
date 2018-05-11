<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\Estado;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use Psr\SimpleCache\CacheInterface;

class EstadosRepository
{
    /**
     * @var Collection
     */
    private $mongoCollection;
    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(Database $mongoDatabase, CacheInterface $cache)
    {
        $this->mongoCollection = $mongoDatabase->selectCollection('estados');
        $this->cache = $cache;
    }

    public function inserir(Estado $estado): Estado
    {
        if (is_null($estado->getDataCriacao())) {
            $estado->setDataCriacao(date('Y-m-d'));
        }

        if (is_null($estado->getDataUltimaAlteracao())) {
            $estado->setDataUltimaAlteracao(date('Y-m-d'));
        }

        $result = $this->mongoCollection->insertOne($estado->toArray());
        $objectId = (string) $result->getInsertedId();

        return $estado->setId($objectId);
    }

    public function listarTodos(): array
    {
        if ($this->cache->has('estados')) {
            return unserialize($this->cache->get('estados'));
        }
        $result = $this->mongoCollection->find();
        $estadoList = [];
        /** @var BSONDocument $estado */
        foreach ($result->toArray() as $estado) {
            $estadoList[] = (new Estado())->hidrate($estado->getArrayCopy());
        };
        $this->cache->set('estados', serialize($estadoList), new \DateInterval('PT1M'));

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
