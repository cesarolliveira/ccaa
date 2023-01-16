<?php

namespace App\Controller;

use App\Entity\Curso;
use App\Form\CursoType;
use App\Service\CursoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/curso')]
class CursoController extends AbstractController
{
    private $cursoService;

    public function __construct(
        CursoService $cursoService
    ) {
        $this->cursoService = $cursoService;
    }

    #[Route('/', name: 'app_curso_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        if (!$this->cursoService->canListar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('curso/index.html.twig', [
            'pagination' => $this->cursoService->listar($request),
        ]);
    }

    #[Route('/new', name: 'app_curso_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request): Response
    {
        $curso = new Curso();
        $form = $this->createForm(CursoType::class, $curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cursoService->cadastrar($curso);

            return $this->redirectToRoute('app_curso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('curso/new.html.twig', [
            'curso' => $curso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_curso_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Curso $curso): Response
    {
        if (!$this->cursoService->canVisualizar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('curso/show.html.twig', [
            'curso' => $curso,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_curso_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Curso $curso): Response
    {
        if (!$this->cursoService->canEditar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(CursoType::class, $curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cursoService->editar($curso);

            return $this->redirectToRoute('app_curso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('curso/edit.html.twig', [
            'curso' => $curso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_curso_delete', methods: ['POST'])]
    #[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_GERENTE')")]
    public function delete(Request $request, Curso $curso): Response
    {
        if (!$this->cursoService->canExcluir($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$curso->getId(), $request->request->get('_token'))) {
            $this->cursoService->excluir($curso);
        }

        return $this->redirectToRoute('app_curso_index', [], Response::HTTP_SEE_OTHER);
    }
}
