<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Pipe;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ContentTypeMiddleware
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
    {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);
        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
