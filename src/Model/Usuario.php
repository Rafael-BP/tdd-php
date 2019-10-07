<?php

namespace Alura\Leilao\Model;

class Usuario
{
    /** @var string */
    private $nome;

    /**
     * Usuario constructor.
     * @param string $nome
     */
    public function __construct(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }
}
