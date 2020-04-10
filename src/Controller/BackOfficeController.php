<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackOfficeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="app_backoffice")
     */
    public function index(LoggerInterface $logger): Response
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackOfficeController',
        ]);
    }
}
