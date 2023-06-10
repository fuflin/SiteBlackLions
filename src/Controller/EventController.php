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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    // affichage de tous les events dans la base de données
    #[Route('/event', name: 'app_event')]

    public function index(EntityManagerInterface $em): Response
    {
        $events = $em->getRepository(Event::class)->findAll();
        $participates = $em->getRepository(Participate::class)->findAll();
        // dd('hello');

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'participates' => $participates
        ]);
    }


    //fonction pour ajouter un event
    #[Route('/event/add', name: 'add_event')]

    public function addEvent(EntityManagerInterface $em, Event $event = null, FileUploader $fileUploader, Request $request): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form

                $posterFile = $form->get('poster')->getData(); // hydratation d'un fichier

                if ($posterFile) {

                    $posterFileName = $fileUploader->upload($posterFile); // on utilise le service upload pour chargé l'image afin de la stocké en base de donnée
                    $event->setPoster($posterFileName);
                }

            $em->persist($event); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_event');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('event/add.html.twig', [
            'eventForm' => $form->createView()
        ]); // création du formulaire
    }

    //fonction pour modifier un event
    #[Route('/event/{id}/edit', name: 'edit_event')]

    public function editEvent(EntityManagerInterface $em, Event $event = null, FileUploader $fileUploader, Request $request): Response
    {

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form


                $posterFile = $form->get('poster')->getData(); // hydratation d'un fichier

                if ($posterFile) {

                    $posterFileName = $fileUploader->upload($posterFile); // on utilise le service upload pour chargé l'image afin de la stocké en base de donnée
                    $event->setPoster($posterFileName);
                }

            $em->persist($event); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_event');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('event/add.html.twig', [
            'eventForm' => $form->createView(),
            'edit'
        ]); // création du formulaire
    }

    // fonction pour supprimer un event
    #[Route('/event/{id}/delete', name: 'delete_event')]

    public function deleteEvent(EntityManagerInterface $em, Event $event): Response
    {

        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('app_event');
    }


    // fonction pour afficher les détails d'un event
    #[Route('/event/{id}', name: 'show_event')]

    public function showEvent(Event $event): Response
    {

        $participate = $event->getParticipates();

        return $this->render('event/detailEvent.html.twig', [
           'event' => $event,
           'participate' => $participate
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
            $participate->addUser($user);
            $participate->addEvent($event);

            $em->persist($participate); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_event');
    }

    // fonction pour désinscrire à un événement
    #[Route('/event/{id}/remove/{idParticipate}', name: 'remove_regis_event')]

    public function removeRegisEvent(EntityManagerInterface $em, Event $event, $idParticipate)
    {
        $participate = $em->getRepository(Participate::class)->find($idParticipate);

        $user = $this->getUser(); //on récupère le User en session

        if($user && $event->getParticipates()->contains($participate)){

            $event->removeParticipate($participate);
        }

        $em->flush();
        return $this->redirectToRoute('app_event');
    }

}
