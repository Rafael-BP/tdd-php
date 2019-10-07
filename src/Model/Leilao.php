<?php

namespace Alura\Leilao\Model;

use Alura\Leilao\Exception\CincoLancesPorLeilaoException;
use Alura\Leilao\Exception\DoisLancesConsecultivosException;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    /** @var bool */
    private $finalizado = false;

    /**
     * @return bool
     */
    public function isFinalizado()
    {
        return $this->finalizado;
    }

    /**
     * @param bool $finalizado
     */
    public function setFinalizado($finalizado)
    {
        $this->finalizado = $finalizado;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

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
            throw new DoisLancesConsecultivosException("Usuário não pode propor 2 lances consecultivos");
        }

        $usuario = $lance->getUsuario();
        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($usuario);
        if($totalLancesUsuario >= 5) {
            throw new CincoLancesPorLeilaoException("Usuário não pode propor mais de 5 lances por Leilão");
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

    public function finaliza()
    {
        $this->setFinalizado(true);
    }
}
