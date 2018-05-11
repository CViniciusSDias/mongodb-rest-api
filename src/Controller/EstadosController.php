<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Controller;

use CViniciusSDias\MongoDbRestApi\Model\Estado;
use CViniciusSDias\MongoDbRestApi\Repository\EstadosRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EstadosController
{
    /**
     * @var EstadosRepository
     */
    private $repository;

    public function __construct(EstadosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarTodos(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $estados = $this->repository->listarTodos();
        $response->getBody()->write(json_encode($estados));

        return $response;
    }

    public function listarUm(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $estado = $this->repository->listarUm($args['id']);
        $response->getBody()->write(json_encode($estado));

        return $response;
    }

    public function inserir(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $estado = new Estado();
        $dados = json_decode($request->getBody()->getContents(), true);

        $estado = $this->repository->inserir($estado->hidrate($dados));
        $response->getBody()->write(json_encode($estado));
        return $response;
    }

    public function atualizar(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $estado = new Estado();
        $dados = json_decode($request->getBody()->getContents(), true);

        $estado = $this->repository->atualizar($args['id'], $estado->hidrate($dados));
        $response->getBody()->write(json_encode($estado));

        return $response;
    }

    public function remover(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $qtd = $this->repository->remover($args['id']);
        $response->getBody()->write(json_encode([
            'id' => $args['id'],
            'quantidadeDeletados' => $qtd
        ]));

        return $response;
    }
}
