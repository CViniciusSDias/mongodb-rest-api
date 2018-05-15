<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Model;

use CViniciusSDias\MongoDbRestApi\Exception\ValidacaoException;

class Estado extends AbstractModel implements \JsonSerializable
{
    use HydratableTrait, JsonTrait;

    /** @var string */
    private $nome;
    /** @var string */
    private $sigla;

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
    public function getSigla(): string
    {
        return $this->sigla;
    }

    /**
     * @param string $sigla
     * @return Estado
     */
    public function setSigla(string $sigla): Estado
    {
        if (false === filter_var($sigla, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[A-Z]{2}$/']])) {
            throw new ValidacaoException('A sigla de um estado deve conter apenas 2 letras maiúsculas');
        }

        $this->sigla = $sigla;
        return $this;
    }

    public function jsonSerialize()
    {
        $dados = $this->toArray();
        $dados['links'] = [[
            'rel' => 'self',
            'href' => '/estados/' . $this->getId()
        ]];

        return $dados;
    }
}
