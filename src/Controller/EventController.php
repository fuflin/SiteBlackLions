<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Form\EventType;
use App\Entity\Participate;
use App\Form\ParticipateType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    // affichage de tous les events dans la base de données
    #[Route('/event', name: 'app_event')]

    public function index(EntityManagerInterface $em): Response
    {
        $events = $em->getRepository(Event::class)->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }


    // fonction pour afficher les détails d'un event
    #[Route('/event/{id}', name: 'show_event')]

    public function showEvent(Event $event): Response
    {

        return $this->render('event/detailEvent.html.twig', [
           'event' => $event,
        ]);

    }

    // fonction pour s'inscrire à un événement
    #[Route('/event/{id}/regis', name: 'regis_event')]

    public function regisEvent(EntityManagerInterface $em, Event $event)
    {
        $user = $this->getUser(); //on récupère le User en session

        if(!$user){ // si la personne n'a pas de compte , elle est renvoyé vers la page d'inscription
            return $this->redirectToRoute('app_login');
        }

        $participate = new Participate();

            $participate->setDateRegis(new \DateTime());
            $participate->setUser($user);
            $participate->setEvent($event);

            $em->persist($participate); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

        return $this->redirectToRoute('app_event');
    }

    // fonction pour désinscrire à un événement
    #[Route('/event/{id}/remove/{idParticipate}', name: 'remove_regis_event')]

    public function removeRegisEvent(EntityManagerInterface $em, Event $event, $idParticipate)
    {

        $participate = $em->getRepository(Participate::class)->find($idParticipate); //on cherche l'id de la participation

        $user = $this->getUser(); //on récupère le User en session

        if($user && $event->getParticipates()->contains($participate)){

            $em->remove($participate);
        }

        $em->flush();
        return $this->redirectToRoute('app_event');
    }

    #[Route("/events/search", name:"app_event_search", methods:["POST"])]
    public function searchAction(Request $request, EntityManagerInterface $entityManager)
    {
        $searchTerm = $request->request->get('searchTerm');
        $searchDate = $request->request->get('searchDate');

        $events = $entityManager->getRepository(Event::class)
            ->searchByTermAndDate($searchTerm, $searchDate);

        // Convert the events to JSON
        $jsonData = [];
        foreach ($events as $event) {
            $jsonData[] = [
                'id' => $event->getId(),
                'nom' => $event->getNom(),
                'date' => $event->getDate()->format('Y-m-d'),
                // Add other properties if needed
            ];
        }

        return new JsonResponse($jsonData);
    }

}
