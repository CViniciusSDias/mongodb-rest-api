<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Repository;

use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use CViniciusSDias\MongoDbRestApi\Model\Estado;

class EstadosRepository extends BaseRepository
{
    public function getCollectionName(): string
    {
        return 'estados';
    }

    public function getModelInstance(): AbstractModel
    {
        return new Estado();
    }
}
