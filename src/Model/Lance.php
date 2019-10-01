<?php

namespace Alura\Leilao\Model;

class Lance
{
    /** @var Usuario */
    private $usuario;
    /** @var float */
    private $valor;

    /**
     * Lance constructor.
     * @param Usuario $usuario
     * @param float $valor
     */
    public function __construct(Usuario $usuario, float $valor)
    {
        $this->usuario = $usuario;
        $this->valor = $valor;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }
}
