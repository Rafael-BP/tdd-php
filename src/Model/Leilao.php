<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    /**
     * Leilao constructor.
     * @param string $descricao
     */
    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    /**
     * @param Lance $lance
     */
    public function recebeLance(Lance $lance)
    {
        if (!empty($this->getLances()) && $this->isLanceDoUltimoUsuario($lance)) {
            return;
        }

        $usuario = $lance->getUsuario();
        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($usuario);
        if($totalLancesUsuario >= 5) {
            return;
        }
        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    private function isLanceDoUltimoUsuario(Lance $lance)
    {
        $ultimoLance = $this->getLances()[array_key_last($this->getLances())];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    /**
     * @param Usuario $usuario
     * @return mixed
     */
    private function quantidadeLancesPorUsuario(Usuario $usuario)
    {
        $totalLancesUsuario = array_reduce(
            $this->getLances(),
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1;
                }
                return $totalAcumulado;
            },
            0
        );
        return $totalLancesUsuario;
    }
}
