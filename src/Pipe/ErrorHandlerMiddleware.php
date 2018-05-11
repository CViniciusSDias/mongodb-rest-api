<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Pipe;

use CViniciusSDias\MongoDbRestApi\Exception\ValidacaoException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorHandlerMiddleware
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        /** @var ResponseInterface $response */
        try {
            $response = $next($request, $response);
        } catch (ValidacaoException $validacaoException) {
            $response->getBody()->write(json_encode([
                'erro' => $validacaoException->getMessage()
            ]));
            $response = $response->withStatus($validacaoException->getCode());
        }

        return $response;
    }
}
