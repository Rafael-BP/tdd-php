<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Exception\LeilaoFinalizadoException;
use Alura\Leilao\Exception\LeilaoVazioException;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;

class Avaliador
{
    /** @var float */
    private $maiorValor = -INF;
    /** @var float */
    private $menorValor = INF;
    /** @var array */
    private $maioresLances;

    /**
     * @param Leilao $leilao
     */
    public function avalia(Leilao $leilao): void
    {
        if($leilao->isFinalizado()) {
            throw new LeilaoFinalizadoException("Leilão já finalizado");
        }
        if (empty($leilao->getLances())) {
            throw new LeilaoVazioException("Não é possível avaliar Leilão vázio");
        }
        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorValor) {
                $this->maiorValor = $lance->getValor();
            }

            if ($lance->getValor() < $this->menorValor) {
                $this->menorValor = $lance->getValor();
            }

            $lances = $leilao->getLances();
            usort($lances, function (Lance $lance1, Lance $lance2) {
                return $lance2->getValor() - $lance1->getValor();
            });
            $this->maioresLances = array_slice($lances, 0, 3);
        }
    }

    /**
     * @return float
     */
    public function getMaiorValor(): float
    {
        return $this->maiorValor;
    }

    /**
     * @return float
     */
    public function getMenorValor(): float
    {
        return $this->menorValor;
    }

    /**
     * @return Lance[]
     */
    public function getMaioresLances(): array
    {
        return $this->maioresLances;
    }
}