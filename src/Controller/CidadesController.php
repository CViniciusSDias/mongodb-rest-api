<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Controller;

use CViniciusSDias\MongoDbRestApi\Model\Cidade;
use CViniciusSDias\MongoDbRestApi\Repository\CidadesRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CidadesController
{
    /**
     * @var CidadesRepository
     */
    private $repository;

    public function __construct(CidadesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarTodos(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $cidades = $this->repository->listarTodos();
        $response->getBody()->write(json_encode($cidades));

        return $response;
    }

    public function listarUm(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $cidade = $this->repository->listarUm($args['id']);
        $response->getBody()->write(json_encode($cidade));

        return $response;
    }

    public function inserir(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $cidade = new Cidade();
        $dados = json_decode($request->getBody()->getContents(), true);

        $cidade = $this->repository->inserir($cidade->hidrate($dados));
        $response->getBody()->write(json_encode($cidade));
        return $response;
    }

    public function atualizar(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $cidade = new Cidade();
        $dados = json_decode($request->getBody()->getContents(), true);

        $cidade = $this->repository->atualizar($args['id'], $cidade->hidrate($dados));
        $response->getBody()->write(json_encode($cidade));

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
