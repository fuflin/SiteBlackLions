<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Participate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/participate', name: 'admin_participate_')]

class ParticipateController extends AbstractController
{

    #[Route('/', name: 'index')]

    public function index(EntityManagerInterface $em):Response
    {
        $participates = $em->getRepository(Participate::class)->findBy([], ['event' => 'asc']);

        return $this->render('admin/participate/index.html.twig', compact('participates')); // compact est une fonction qui renvoi un tableau avec des variables et leurs données
    }

    // fonction pour afficher les détails d'un event pour une participation
    #[Route('/event/{id}', name: 'show')]

    public function showEvent(EntityManagerInterface $em, Event $event): Response
    {
        $participates = $em->getRepository(Participate::class)->findBy(['event' => $event], ['event' => 'asc']);

        return $this->render('admin/participate/index.html.twig', [
           'event' => $event,
           'participates' => $participates,
        ]);
    }

}