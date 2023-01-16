<?php

namespace App\Controller;

use App\Entity\Contrato;
use App\Form\ContratoType;
use App\Service\ContratoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contrato')]
class ContratoController extends AbstractController
{
    private $contratoService;

    public function __construct(
        ContratoService $contratoService
    ) {
        $this->contratoService = $contratoService;
    }

    #[Route('/', name: 'app_contrato_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        if (!$this->contratoService->canListar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('contrato/index.html.twig', [
            'pagination' => $this->contratoService->listar($request),
        ]);
    }

    #[Route('/new', name: 'app_contrato_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request): Response
    {
        if (!$this->contratoService->canCadastrar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $contrato = new Contrato();
        $form = $this->createForm(ContratoType::class, $contrato);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contratoService->cadastrar($contrato);

            return $this->redirectToRoute('app_contrato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrato/new.html.twig', [
            'contrato' => $contrato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrato_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Contrato $contrato): Response
    {
        if (!$this->contratoService->canVisualizar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('contrato/show.html.twig', [
            'contrato' => $contrato,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrato_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Contrato $contrato): Response
    {
        if (!$this->contratoService->canEditar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ContratoType::class, $contrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contratoService->editar($contrato);

            return $this->redirectToRoute('app_contrato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrato/edit.html.twig', [
            'contrato' => $contrato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrato_delete', methods: ['POST'])]
    #[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_GERENTE')")]
    public function delete(Request $request, Contrato $contrato): Response
    {
        if (!$this->contratoService->canExcluir($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$contrato->getId(), $request->request->get('_token'))) {
            $this->contratoService->excluir($contrato);

            return $this->redirectToRoute('app_contrato_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
