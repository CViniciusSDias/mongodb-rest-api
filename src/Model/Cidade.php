<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Model;

use CViniciusSDias\MongoDbRestApi\Exception\ValidacaoException;
use CViniciusSDias\MongoDbRestApi\Service\ConversorDeData;
use MongoDB\BSON\UTCDateTime;

class Cidade implements \JsonSerializable
{
    use HydratableTrait;

    /** @var string */
    private $_id;
    /** @var string */
    private $nome;
    /** @var string */
    private $estadoId;
    private $dataCriacao;
    private $dataUltimaAlteracao;

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->_id;
    }

    /**
     * @param string $_id
     * @return Estado
     */
    public function setId(string $_id): Estado
    {
        $this->_id = $_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Estado
     */
    public function setNome(string $nome): Estado
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstadoId(): string
    {
        return $this->estadoId;
    }

    /**
     * @param string $estadoId
     * @return Estado
     */
    public function setSigla(string $estadoId): Estado
    {
        $this->estadoId = $estadoId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * @param string|UTCDateTime $dataCriacao
     * @return Estado
     */
    public function setDataCriacao($dataCriacao)
    {
        if (is_string($dataCriacao)) {
            $this->dataCriacao = (new ConversorDeData())->stringParaDataMongo($dataCriacao);
            return $this;
        }
        $this->dataCriacao = $dataCriacao;
        return $this;
    }

    public function getDataUltimaAlteracao(): ?UTCDateTime
    {
        return $this->dataUltimaAlteracao;
    }

    /**
     * @param string|UTCDateTime $dataUltimaAlteracao
     * @return Estado
     */
    public function setDataUltimaAlteracao($dataUltimaAlteracao)
    {
        if (is_string($dataUltimaAlteracao)) {
            $this->dataUltimaAlteracao = (new ConversorDeData())->stringParaDataMongo($dataUltimaAlteracao);
            return $this;
        }
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        return $this;
    }

    public function jsonSerialize()
    {
        $dados = $this->toArray();
        $dados['links'] = [[
            'rel' => 'self',
            'href' => '/cidades/' . $this->getId()
        ]];

        return $dados;
    }

    public function toArray(): array
    {
        return $dados = array_filter(get_object_vars($this));
    }
}
