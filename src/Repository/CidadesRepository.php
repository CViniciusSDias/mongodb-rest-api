<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\Cidade;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use Psr\SimpleCache\CacheInterface;

class CidadesRepository
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
        $this->mongoCollection = $mongoDatabase->selectCollection('cidades');
        $this->cache = $cache;
    }

    public function inserir(Cidade $cidade): Cidade
    {
        if (is_null($cidade->getDataCriacao())) {
            $cidade->setDataCriacao(date('Y-m-d'));
        }

        if (is_null($cidade->getDataUltimaAlteracao())) {
            $cidade->setDataUltimaAlteracao(date('Y-m-d'));
        }

        $result = $this->mongoCollection->insertOne($cidade->toArray());
        $objectId = (string) $result->getInsertedId();

        return $cidade->setId($objectId);
    }

    public function listarTodos(): array
    {
        if ($this->cache->has('estados')) {
            return unserialize($this->cache->get('estados'));
        }
        $result = $this->mongoCollection->find();
        $cidadeList = [];
        /** @var BSONDocument $cidade */
        foreach ($result->toArray() as $cidade) {
            $cidadeList[] = (new Cidade())->hidrate($cidade->getArrayCopy());
        };
        $this->cache->set('cidades', serialize($cidadeList), new \DateInterval('PT1M'));

        return $cidadeList;
    }

    public function listarUm(string $id)
    {
        /** @var BSONDocument $result */
        $result = $this->mongoCollection->findOne(['_id' => new ObjectId($id)]);
        return (new Cidade())->hidrate($result->getArrayCopy());
    }

    public function atualizar(string $id, Cidade $cidade): Cidade
    {
        /** @var BSONDocument $result */
        $result = $this->mongoCollection->findOneAndUpdate(
            ['_id' => new ObjectId($id)],
            ['$set' => $cidade->toArray()]
        );
        $cidadeOriginal = (new Cidade())->hidrate($result->getArrayCopy());

        return $cidadeOriginal->hidrate($cidade->toArray());
    }

    public function remover(string $id): int
    {
        $result = $this->mongoCollection->deleteOne(['_id' => new ObjectId($id)]);
        return $result->getDeletedCount();
    }
}
