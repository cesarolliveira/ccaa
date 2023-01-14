<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Contrato;
use App\Entity\Lancamento;
use App\Enum\TipoLancamentoEnum;
use App\Enum\SituacaoLancamentoEnum;
use App\Repository\ContratoRepository;
use App\Repository\LancamentoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Pagination\PaginationInterface;

class ContratoService
{
    private $contratoRepository;

    private $paginator;

    private $lancamentoRepository;

    public function __construct(
        ContratoRepository $contratoRepository,
        PaginatorInterface $paginator,
        LancamentoRepository $lancamentoRepository
    ) {
        $this->contratoRepository = $contratoRepository;
        $this->paginator = $paginator;
        $this->lancamentoRepository = $lancamentoRepository;
    }

    public function canListar(User $user): bool
    {
        return true;
    }

    public function canVisualizar(User $user): bool
    {
        return true;
    }

    public function canCadastrar(User $user): bool
    {
        return true;
    }

    public function canEditar(User $user): bool
    {
        return true;
    }

    public function canExcluir(User $user): bool
    {
        return true;
    }

    public function listar(Request $request): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contratoRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
    }

    public function cadastrar(Contrato $contrato): void
    {
        $data = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $data = $data->setDate($data->format('Y'), $data->format('m'), $contrato->getVencimento());

        $valorLancamento = number_format(
            ($contrato->getValor() - $contrato->getDesconto()) / $contrato->getParcelas(),
            2,
            '.',
            ''
        );

        for ($i = 1; $i <= $contrato->getParcelas(); $i++) {
            $lancamento = new Lancamento();
            $lancamento->setContrato($contrato);
            $lancamento->setTipoLancamento(TipoLancamentoEnum::RECEITA);
            $lancamento->setFormaPagamento($contrato->getFormaPagamento());
            $lancamento->setDescricao(
                'Contrato: ' .
                $contrato->getAluno()->getNomeCompleto() .
                ' - ' .
                $contrato->getAluno()->getDocumentoCpf() .
                ' | Curso: ' .
                $contrato->getCurso()->getDescricao() .
                ' | Parcela: ' .
                $i .
                '/' .
                $contrato->getParcelas()
            );
            $lancamento->setParcela($i);
            $lancamento->setVencimento($data->add(new \DateInterval('P1M')));
            $lancamento->setValor($valorLancamento);
            $lancamento->setObservacao($contrato->getDescricao());
            $lancamento->setSituacao(SituacaoLancamentoEnum::PENDENTE);
            $lancamento->setAluno($contrato->getAluno());

            $this->lancamentoRepository->save($lancamento, true);
        }

        $this->contratoRepository->save($contrato, true);
    }

    public function editar(Contrato $contrato): void
    {
        $this->contratoRepository->save($contrato, true);
    }

    public function excluir(Contrato $contrato): void
    {
        $this->contratoRepository->remove($contrato, true);
    }
}
