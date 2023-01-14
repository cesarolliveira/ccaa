<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Curso;
use App\Repository\CursoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

class CursoService
{
    private $cursoRepository;

    private $paginator;

    public function __construct(
        CursoRepository $cursoRepository,
        PaginatorInterface $paginator
    ) {
        $this->cursoRepository = $cursoRepository;
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
            $this->cursoRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
    }

    public function cadastrar(Curso $curso): void
    {
        $this->cursoRepository->save($curso, true);
    }

    public function editar(Curso $curso): void
    {
        $this->cursoRepository->save($curso, true);
    }

    public function excluir(Curso $curso): void
    {
        $this->cursoRepository->remove($curso, true);
    }
}
