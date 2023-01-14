<?php

namespace App\Service;

use App\Entity\Aluno;
use App\Entity\User;
use App\Repository\AlunoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Pagination\PaginationInterface;

class AlunoService
{
    private $alunoRepository;

    private $paginator;

    public function __construct(
        AlunoRepository $alunoRepository,
        PaginatorInterface $paginator
    ) {
        $this->alunoRepository = $alunoRepository;
        $this->paginator = $paginator;
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
            $this->alunoRepository->findAll(),
            $request->query->getInt('page', 1),
            10,
        );
    }

    public function cadastrar(Aluno $aluno): void
    {
        $this->alunoRepository->save($aluno, true);
    }

    public function editar(Aluno $aluno): void
    {
        $this->alunoRepository->save($aluno, true);
    }

    public function excluir(Aluno $aluno): void
    {
        $this->alunoRepository->remove($aluno, true);
    }
}
