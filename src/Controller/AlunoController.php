<?php

namespace App\Controller;

use App\Entity\Aluno;
use App\Form\AlunoType;
use App\Service\AlunoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/aluno')]
class AlunoController extends AbstractController
{
    private $alunoService;

    public function __construct(
        AlunoService $alunoService
    ) {
        $this->alunoService = $alunoService;
    }

    #[Route('/', name: 'app_aluno_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        if (!$this->alunoService->canListar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('aluno/index.html.twig', [
            'pagination' => $this->alunoService->listar($request),
        ]);
    }

    #[Route('/new', name: 'app_aluno_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request): Response
    {
        if (!$this->alunoService->canListar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $aluno = new Aluno();
        $form = $this->createForm(AlunoType::class, $aluno);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->alunoService->cadastrar($aluno);

            return $this->redirectToRoute('app_aluno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aluno/new.html.twig', [
            'aluno' => $aluno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aluno_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Aluno $aluno): Response
    {
        return $this->render('aluno/show.html.twig', [
            'aluno' => $aluno,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aluno_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Aluno $aluno): Response
    {
        if (!$this->alunoService->canEditar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(AlunoType::class, $aluno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->alunoService->editar($aluno);

            return $this->redirectToRoute('app_aluno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aluno/edit.html.twig', [
            'aluno' => $aluno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aluno_delete', methods: ['POST'])]
    #[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_GERENTE')")]
    public function delete(Request $request, Aluno $aluno): Response
    {
        if (!$this->alunoService->canExcluir($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$aluno->getId(), $request->request->get('_token'))) {
            $this->alunoService->excluir($aluno);
        }

        return $this->redirectToRoute('app_aluno_index', [], Response::HTTP_SEE_OTHER);
    }
}
