<?php
/**
 * Created by PhpStorm.
 * User: cvinicius
 * Date: 11/05/2018
 * Time: 12:34
 */

namespace CViniciusSDias\MongoDbRestApi\Model;


trait HydratableTrait
{
    public function hidrate(array $dados): self
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
