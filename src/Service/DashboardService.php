<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Aluno;
use App\Entity\Lancamento;
use App\Enum\SituacaoEnum;
use Doctrine\ORM\EntityManagerInterface;

class DashboardService
{
    private $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function canVisualizar(User $user): bool
    {
        return true;
    }

    public function listar(): array
    {
        return [
            'dashboardAlunos' => $this->getDashboardAlunos(),
            'dashboardLancamentos' => $this->getDashboardLancamentos(),
            'dashboardLancamentosDoDia' => $this->getDasboardLancaentosDoDia(),
        ];
    }

    private function getDashboardAlunos(): array
    {
        $totalAlunos = $this->em->getRepository(Aluno::class)->findAll();

        $totalAlunosAtivos = $this->em->getRepository(Aluno::class)->findBy(
            [
                'situacao' => SituacaoEnum::ATIVO,
            ]
        );

        $totalAlunosInativos = $this->em->getRepository(Aluno::class)->findBy(
            [
                'situacao' => SituacaoEnum::INATIVO,
            ]
        );

        return [
            'total' => count($totalAlunos),
            'ativos' => count($totalAlunosAtivos),
            'inativos' => count($totalAlunosInativos),
        ];
    }

    private function getDashboardLancamentos(): array
    {
        $lancamentosMesAtual = $this->em->getRepository(Lancamento::class)->findLancamentosMesAtual();
        $lancamentosMesAtualPendentes = $this->em->getRepository(Lancamento::class)->findLancamentosMesAtualPendentes();
        $lancamentosMesAtualPagos = $this->em->getRepository(Lancamento::class)->findLancamentosMesAtualPagos();
        $lancamentosMesAtualVencidos = $this->em->getRepository(Lancamento::class)->findLancamentosMesAtualVencidos();

        return [
            'totalLancamentosMes' => count($lancamentosMesAtual),
            'totalLancamentosPendentesMes' => count($lancamentosMesAtualPendentes),
            'totalLancamentosPagosMes' => count($lancamentosMesAtualPagos),
            'totalLancamentosVencidosMes' => count($lancamentosMesAtualVencidos),
        ];
    }

    private function getDasboardLancaentosDoDia(): array
    {
        $lancamentosDoDia = $this->em->getRepository(Lancamento::class)->findLancamentosDoDia();

        return [
            'lancamentosDoDia' => $lancamentosDoDia,
            'totalLancamentosDoDia' => count($lancamentosDoDia),
        ];
    }
}
