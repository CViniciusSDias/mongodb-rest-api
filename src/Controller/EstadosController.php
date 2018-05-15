<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Controller;

use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use CViniciusSDias\MongoDbRestApi\Model\Estado;

class EstadosController extends BaseController
{
    public function getModelInstance(): AbstractModel
    {
        return new Estado();
    }
}
