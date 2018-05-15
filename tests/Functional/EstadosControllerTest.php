<?php

namespace Tests\Functional;

use CViniciusSDias\MongoDbRestApi\Model\Estado;

class EstadosControllerTest extends BaseTestCase
{
    public function testRequestSemApiKey()
    {
        $estado = new Estado();
        $estado->setNome('Rio de Janeiro')
            ->setSigla('RJ');
        $response = $this->runApp('GET', '/estados', $estado->toArray());

        $this->assertEquals(401, $response->getStatusCode());
    }
}
