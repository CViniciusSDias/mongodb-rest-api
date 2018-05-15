<?php

declare(strict_types=1);

namespace CViniciusSDias\MongoDbRestApi\Model;

trait HydratableTrait
{
    public function hidrate(array $dados)
    {
        foreach ($dados as $propriedade => $valor) {
            $this->hidratePropriedade($propriedade, $valor);
        }

        return $this;
    }

    private function hidratePropriedade(string $propriedade, $valor)
    {
        $metodo = 'set' . ucfirst($propriedade);
        if (method_exists($this, $metodo)) {
            $this->$metodo($valor);
            return;
        }

        if (property_exists($this, $propriedade)) {
            $this->$propriedade = $valor;
            return;
        }

        throw new \DomainException("Propriedade $propriedade não encontrada na classe " . self::class);
    }
}
