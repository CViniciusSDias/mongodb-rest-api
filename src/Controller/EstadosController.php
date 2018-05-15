<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Controller;

use CViniciusSDias\MongoDbRestApi\Exception\ValidacaoException;
use CViniciusSDias\MongoDbRestApi\Model\AbstractModel;
use CViniciusSDias\MongoDbRestApi\Model\Estado;
use CViniciusSDias\MongoDbRestApi\Repository\BaseRepository;
use CViniciusSDias\MongoDbRestApi\Repository\CidadesRepository;
use CViniciusSDias\MongoDbRestApi\Repository\EstadosRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EstadosController extends BaseController
{
    /**
     * @var CidadesRepository
     */
    private $cidadesRepository;

    public function __construct(EstadosRepository $repository, CidadesRepository  $cidadesRepository)
    {
        parent::__construct($repository);
        $this->cidadesRepository = $cidadesRepository;
    }

    public function getModelInstance(): AbstractModel
    {
        return new Estado();
    }

    public function remover(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $cidades = $this->cidadesRepository->listarTodos(['estadoId' => $args['id']]);

        if (count($cidades) > 0) {
            throw new ValidacaoException('Este estado contém cidades vinculadas. Não é possível excluir', 412);
        }

        $qtd = $this->repository->remover($args['id']);
        $response->getBody()->write(json_encode([
            'id' => $args['id'],
            'quantidadeDeletados' => $qtd
        ]));

        return $response;
    }
}
