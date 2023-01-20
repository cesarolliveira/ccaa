<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Lancamento;
use App\Repository\LancamentoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Pagination\PaginationInterface;

class LancamentoService
{
    private $paginator;

    private $lancamentoRepository;

    public function __construct(
        PaginatorInterface $paginator,
        LancamentoRepository $lancamentoRepository
    ) {
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

    public function canExcluir(Lancamento $lancamento): bool
    {
        if ($lancamento->getContrato()) {
            return false;
        }

        return true;
    }

    public function listar(Request $request): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->lancamentoRepository->findAll(),
            $request->query->getInt('page', 1),
            10,
        );
    }

    public function cadastrar(Lancamento $lancamento): void
    {
        $this->lancamentoRepository->save($lancamento, true);
    }

    public function editar(Lancamento $lancamento): void
    {
        $this->lancamentoRepository->save($lancamento, true);
    }

    public function excluir(Lancamento $lancamento): void
    {
        $this->lancamentoRepository->remove($lancamento, true);
    }
}
