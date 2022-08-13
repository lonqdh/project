<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DesignerController extends AbstractController
{
    #[Route('/designer', name: 'app_designer')]
    public function index(): Response
    {
        return $this->render('designer/index.html.twig', [
            'controller_name' => 'DesignerController',
        ]);
    }
}
