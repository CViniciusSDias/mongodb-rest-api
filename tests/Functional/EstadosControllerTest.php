<?php

namespace Tests\Functional;

class EstadosControllerTest extends BaseTestCase
{
	public function testInserirEstado()
	{
		$estado = new Estado();
		$estado->setNome('Rio de Janeiro')
		    ->setSigla('RJ');
		$response = $this->runApp('POST', '/estados', json_encode($estado->toArray()));
		
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('Rio de Janeiro', (string) $response->getBody());
		$this->assertTrue(false !== json_decode((string) $response->getBody());
	}
}