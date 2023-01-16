<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Lancamento;
use App\Enum\SituacaoEnum;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private $paginator;

    private $userRepository;

    private $passwordEncoder;

    public function __construct(
        PaginatorInterface $paginator,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordEncoder
    ) {
        $this->paginator = $paginator;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
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
            $this->userRepository->findAll(),
            $request->query->getInt('page', 1),
            10,
        );
    }

    public function cadastrar(User $user): void
    {
        $user->setPassword(
            $this->passwordEncoder->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        $this->userRepository->save($user, true);
    }

    public function editar(User $user): void
    {
        $this->userRepository->save($user, true);
    }

    public function excluir(User $user): void
    {
        $this->userRepository->remove($user, true);
    }
}
