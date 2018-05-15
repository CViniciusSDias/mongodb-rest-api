<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use CViniciusSDias\MongoDbRestApi\Model\Cidade;

class CidadesRepository extends BaseRepository
{
    public function getCollectionName(): string
    {
        return 'cidades';
    }

    public function getModelInstance(): AbstractModel
    {
        return new Cidade();
    }
}
