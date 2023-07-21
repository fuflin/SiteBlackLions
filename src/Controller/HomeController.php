<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {

        $events = $em->getRepository(Event::class)->findBy([], ['date_create' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'description' => "ceci est ma meta description pour la page d'accueil",
            'events' => $events,
        ]);
    }


    // route pour la page airsoft, étant une page fixe sans interaction avec la bdd sa route a été mise ici
    #[Route('/airsoft', name: 'app_airsoft')]
    public function indexAirsoft(): Response
    {
        return $this->render('airsoft/index.html.twig', []);
    }
}
