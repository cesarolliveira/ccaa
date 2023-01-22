<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Lancamento;
use App\Enum\SituacaoLancamentoEnum;
use App\Repository\LancamentoRepository;
use App\Form\Filters\LancamentoFilterType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;

class LancamentoService
{
    private $paginator;

    private $lancamentoRepository;

    private $formFactory;

    private $filterBuilderUpdater;

    public function __construct(
        PaginatorInterface $paginator,
        LancamentoRepository $lancamentoRepository,
        FormFactoryInterface $formFactory,
        FilterBuilderUpdater $filterBuilderUpdater
    ) {
        $this->paginator = $paginator;
        $this->lancamentoRepository = $lancamentoRepository;
        $this->formFactory = $formFactory;
        $this->filterBuilderUpdater = $filterBuilderUpdater;
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

    public function canPagar(Lancamento $lancamento): bool
    {
        if (SituacaoLancamentoEnum::PENDENTE === $lancamento->getSituacao()) {
            return true;
        }

        return false;
    }

    public function listar(Request $request): array
    {
        $queryBuilder = $this->lancamentoRepository->createQueryBuilder('lancamento');

        $form = $this->formFactory->create(LancamentoFilterType::class);

        if ($request->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($request->query->get($form->getName()));

            // build the query from the given form object
            $this->filterBuilderUpdater->addFilterConditions(
                $form,
                $queryBuilder,
            );
        }

        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10,
        );

        return [
            'pagination' => $pagination,
            'form_filter' => $form,
        ];
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

    public function baixarLancamento(Lancamento $lancamento): void
    {
        $lancamento->setSituacao(SituacaoLancamentoEnum::PAGO);
        $this->lancamentoRepository->save($lancamento, true);
    }
}
