<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    // route pour la page airsoft, étant une page fixe sans interaction avec la bdd sa route a été mise ici
    #[Route('/airsoft', name: 'app_airsoft')]
    public function indexAirsoft(): Response
    {
        return $this->render('airsoft/index.html.twig', []);
    }
}
