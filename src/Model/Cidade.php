<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Model;

class Cidade extends AbstractModel implements \JsonSerializable
{
    use HydratableTrait, JsonTrait;

    /** @var string */
    private $nome;
    /** @var string */
    private $estadoId;

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Cidade
     */
    public function setNome(string $nome): Cidade
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

    public function setEstadoId(string $estadoId): Cidade
    {
        $this->estadoId = $estadoId;
        return $this;
    }

    /**
     * @param string $estadoId
     * @return Cidade
     */
    public function setSigla(string $estadoId): Cidade
    {
        $this->estadoId = $estadoId;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $dados = $this->toArray();
        $dados['links'] = [
            [
                'rel' => 'self',
                'href' => '/cidades/' . $this->getId()
            ],
            [
                'rel' => 'estado',
                'href' => '/estados/' . $this->getEstadoId()
            ]
        ];

        return $dados;
    }
}
