<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use Psr\SimpleCache\CacheInterface;

abstract class BaseRepository
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
        $this->mongoCollection = $mongoDatabase->selectCollection($this->getCollectionName());
        $this->cache = $cache;
    }

    public function inserir(AbstractModel $model): AbstractModel
    {
        if (is_null($model->getDataCriacao())) {
            $model->setDataCriacao(date('Y-m-d'));
        }

        if (is_null($model->getDataUltimaAlteracao())) {
            $model->setDataUltimaAlteracao(date('Y-m-d'));
        }

        $result = $this->mongoCollection->insertOne($model->toArray());
        $objectId = (string) $result->getInsertedId();

        return $model->setId($objectId);
    }

    /**
     * @return AbstractModel[]
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function listarTodos(): array
    {
        if ($this->cache->has($this->getCollectionName())) {
            return unserialize($this->cache->get($this->getCollectionName()));
        }
        $result = $this->mongoCollection->find();
        $modelList = [];
        /** @var BSONDocument $model */
        foreach ($result->toArray() as $model) {
            $modelList[] = $this->getModelInstance()->hidrate($model->getArrayCopy());
        }
        $this->cache->set($this->getCollectionName(), serialize($modelList), new \DateInterval('PT1M'));

        return $modelList;
    }

    public function listarUm(string $id)
    {
        /** @var BSONDocument $result */
        $result = $this->mongoCollection->findOne(['_id' => new ObjectId($id)]);
        return $this->getModelInstance()->hidrate($result->getArrayCopy());
    }

    public function atualizar(string $id, AbstractModel $model): AbstractModel
    {
        /** @var BSONDocument $result */
        $result = $this->mongoCollection->findOneAndUpdate(
            ['_id' => new ObjectId($id)],
            ['$set' => $model->toArray()]
        );
        $modelOriginal = $this->getModelInstance()->hidrate($result->getArrayCopy());

        return $modelOriginal->hidrate($model->toArray());
    }

    public function remover(string $id): int
    {
        $result = $this->mongoCollection->deleteOne(['_id' => new ObjectId($id)]);
        return $result->getDeletedCount();
    }

    abstract public function getCollectionName(): string;
    abstract public function getModelInstance(): AbstractModel;
}
