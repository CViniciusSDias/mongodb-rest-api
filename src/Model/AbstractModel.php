<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Model;

use CViniciusSDias\MongoDbRestApi\Service\ConversorDeData;
use MongoDB\BSON\UTCDateTime;

abstract class AbstractModel
{
    /** @var string */
    protected $_id;
    protected $dataCriacao;
    protected $dataUltimaAlteracao;

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->_id;
    }

    /**
     * @param string $_id
     * @return self
     */
    public function setId(string $_id): self
    {
        $this->_id = $_id;
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
     * @return self
     */
    public function setDataCriacao($dataCriacao): self
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
     * @return self
     */
    public function setDataUltimaAlteracao($dataUltimaAlteracao): self
    {
        if (is_string($dataUltimaAlteracao)) {
            $this->dataUltimaAlteracao = (new ConversorDeData())->stringParaDataMongo($dataUltimaAlteracao);
            return $this;
        }
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        return $this;
    }

    abstract public function hidrate(array $dados);
}
