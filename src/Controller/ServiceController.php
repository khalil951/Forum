<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]
    public function index($name): Response
    {
        $classe = "3A6";
        return $this->render('service/index.html.twig', [
            'c' => $classe,
            'name' => $name
        ]);
    }
    #[Route('/afficher', name: 'service_afficher')]
    public function afficher(): Response
    {
        $services =[
            [
                'name' => 'Service 1',
                'description' => 'Description 1'
            ],
            [
                'name' => 'Service 2',
                'description' => 'Description 2'
            ]
            ];
        return $this->render('service/afficher.html.twig',[
            'services'=>$services
        ]);
    }
}
