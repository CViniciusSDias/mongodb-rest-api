<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Pipe;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthMiddleware
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        if (!$request->hasHeader('X-Api-Key')) {
            $response = $response->withStatus(401);
            $response->getBody()->write(json_encode(['erro' => 'Insira o header X-Api-Key']));
            return $response;
        }

        if ($request->getHeaderLine('X-Api-Key') !== md5('mongodb-rest-api')) {
            $response = $response->withStatus(401);
            $response->getBody()->write(json_encode(['erro' => 'X-Api-Key Inválida. Insira a chave correta']));
            return $response;
        }

        return $next($request, $response);
    }
}
