<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Controller;

use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use CViniciusSDias\MongoDbRestApi\Repository\BaseRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class BaseController
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarTodos(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $modelList = $this->repository->listarTodos();
        $response->getBody()->write(json_encode($modelList));

        return $response;
    }

    public function listarUm(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $model = $this->repository->listarUm($args['id']);
        $response->getBody()->write(json_encode($model));

        return $response;
    }

    public function inserir(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = $this->getModelInstance();
        $dados = json_decode($request->getBody()->getContents(), true);

        $model = $this->repository->inserir($model->hidrate($dados));
        $response->getBody()->write(json_encode($model));
        return $response;
    }

    public function atualizar(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $model = $this->getModelInstance();
        $dados = json_decode($request->getBody()->getContents(), true);

        $model = $this->repository->atualizar($args['id'], $model->hidrate($dados));
        $response->getBody()->write(json_encode($model));

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

    abstract public function getModelInstance(): AbstractModel;
}
