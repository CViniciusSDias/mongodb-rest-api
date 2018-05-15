<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Controller;

use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use CViniciusSDias\MongoDbRestApi\Model\Cidade;

class CidadesController extends BaseController
{
    public function getModelInstance(): AbstractModel
    {
        return new Cidade();
    }
}
