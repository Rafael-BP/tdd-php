<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Exception\LeilaoFinalizadoException;
use Alura\Leilao\Exception\LeilaoVazioException;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    /** @var Avaliador */
    private $leiloeiro;

    /**
     * setUp
     */
    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        static::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then
        static::assertEquals(1700, $menorValor);
    }


    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }

    /*
     * DataProvider de Leilão em Ordem Crescente
     */
    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            'ordem-crescente' => [$leilao]
        ];
    }

    /*
     * DataProvider de Leilão em Ordem Decrescente
     */
    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem-decrescente' => [$leilao]
        ];
    }

    /*
     * DataProvider de Leilão em Ordem Aleatória
     */
    public function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem-aleatoria' => [$leilao]
        ];
    }

    /**
     * Teste para a regra de negócio da qual Leilão Vázio não pode ser Avaliado
     */
    public function testLeilaoVazioNaoPodeSerAvaliado()
    {
        static::expectException(LeilaoVazioException::class);
        static::expectExceptionMessage("Não é possível avaliar Leilão vázio");

        $leilao = new Leilao('Fiat 147 0KM');
        $this->leiloeiro->avalia($leilao);
    }

    public function testLeilaoFinalizadoNaoPodeSerAvaliado()
    {
        static::expectException(LeilaoFinalizadoException::class);
        static::expectExceptionMessage("Leilão já finalizado");

        $leilao = new Leilao('Fiat 147 0KM');
        $joao = new Usuario('João');
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
    }

}