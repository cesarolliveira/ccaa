<?php

namespace App\Controller;

use App\Entity\Lancamento;
use App\Form\LancamentoType;
use App\Service\LancamentoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lancamento')]
class LancamentoController extends AbstractController
{
    private $lancamentoService;

    public function __construct(
        LancamentoService $lancamentoService
    ) {
        $this->lancamentoService = $lancamentoService;
    }

    #[Route('/', name: 'app_lancamento_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        if (!$this->lancamentoService->canListar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('lancamento/index.html.twig', [
            'pagination' => $this->lancamentoService->listar($request),
        ]);
    }

    #[Route('/new', name: 'app_lancamento_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request): Response
    {
        if (!$this->lancamentoService->canCadastrar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $lancamento = new Lancamento();
        $form = $this->createForm(LancamentoType::class, $lancamento);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->lancamentoService->cadastrar($lancamento);
            $this->addFlash('success', 'Lançamento cadastrado com sucesso.');

            return $this->redirectToRoute('app_lancamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lancamento/new.html.twig', [
            'lancamento' => $lancamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lancamento_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Lancamento $lancamento): Response
    {
        if (!$this->lancamentoService->canVisualizar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('lancamento/show.html.twig', [
            'lancamento' => $lancamento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lancamento_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Lancamento $lancamento): Response
    {
        if (!$this->lancamentoService->canEditar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(LancamentoType::class, $lancamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->lancamentoService->editar($lancamento);
            $this->addFlash('success', 'Lançamento editado com sucesso.');

            return $this->redirectToRoute('app_lancamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lancamento/edit.html.twig', [
            'lancamento' => $lancamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lancamento_delete', methods: ['POST'])]
    #[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_GERENTE')")]
    public function delete(Request $request, Lancamento $lancamento): Response
    {
        if (!$this->lancamentoService->canExcluir($lancamento)) {
            $this->addFlash('error', 'Não é possível excluir este lançamento.');

            return $this->redirectToRoute('app_lancamento_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isCsrfTokenValid('delete'.$lancamento->getId(), $request->request->get('_token'))) {
            $this->lancamentoService->excluir($lancamento);
            $this->addFlash('success', 'Lançamento excluído com sucesso.');
        }

        return $this->redirectToRoute('app_lancamento_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/pagar', name: 'app_lancamento_baixar_lancamento', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function pagarLancamento(Request $request, Lancamento $lancamento): Response
    {
        if (!$this->lancamentoService->canPagar($lancamento)) {
            $this->addFlash('error', 'Não foi possível pagar este lançamento.');

            return $this->redirectToRoute('app_lancamento_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isCsrfTokenValid('baixar'.$lancamento->getId(), $request->request->get('_token'))) {
            $this->lancamentoService->baixarLancamento($lancamento);
            $this->addFlash('success', 'Lançamento baixado com sucesso.');
        }

        return $this->redirectToRoute('app_lancamento_index', [], Response::HTTP_SEE_OTHER);
    }
}
