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
        return $this->render('event/index.html.twig', [
            'events' => $events,
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


    // fonction pour afficher les détails d'un event + inscription à l'event en question
    #[Route('/event/{id}', name: 'show_event')]

    public function showEvent(EntityManagerInterface $em, Event $event, Request $request): Response
    {

        $user = $this->getUser(); //on récupère le User en session

        $participate = new Participate();

        $form = $this->createForm(ParticipateType::class, $participate);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if(!$user){ // si la personne n'a pas de compte , elle est renvoyé vers la page d'inscription
                    return $this->redirectToRoute('app_login');
                }

                $participate = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form

                $participate->setDateRegis(new \DateTime());
                $participate->addUser($user);
                $participate->addEvent($event);

                $em->persist($participate); // équivalent du prepare dans PDO
                $em->flush(); // équivalent de insert into (execute) dans PDO

                return $this->redirectToRoute('app_event');
            }

        return $this->render('event/detailEvent.html.twig', [
           'event' => $event,
           'Form' => $form->createView(),
        ]);
    }
}
