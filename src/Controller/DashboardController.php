<?php

namespace App\Controller;

use App\Service\DashboardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    private $dashboardService;

    public function __construct(
        DashboardService $dashboardService
    ) {
        $this->dashboardService = $dashboardService;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        if (!$this->dashboardService->canVisualizar($this->getUser())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('dashboard/index.html.twig', [
            'data' => $this->dashboardService->listar(),
        ]);
    }
}
