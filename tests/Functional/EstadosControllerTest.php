<?php

namespace Tests\Functional;

class EstadosControllerTest extends BaseTestCase
{
    public function testRequestSemApiKey()
    {
        $response = $this->runApp('GET', '/estados');

        $this->assertEquals(401, $response->getStatusCode());
    }
}
