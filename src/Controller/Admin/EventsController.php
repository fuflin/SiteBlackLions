<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Event;
use App\Form\EventType;
use App\Service\SendMail;
use App\Entity\Participate;
use App\Service\FileUploader;
use App\Repository\EventRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/events', name: 'admin_events_')]

class EventsController extends AbstractController
{
    // affichage de la liste des events dans le panel admin
    #[Route('/', name: 'index')]

    public function index(EntityManagerInterface $em):Response
    {
        $events = $em->getRepository(Event::class)->findBy([], ['date_create' => 'DESC']);

        return $this->render('admin/events/index.html.twig', compact('events'));
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

        // $user = $this->getUser();

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

            return $this->redirectToRoute('admin_events_index');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('event/add.html.twig', [
            'eventForm' => $form->createView(),
            'edit'
        ]); // création du formulaire
    }

    // fonction pour supprimer un event
    #[Route('/event/{id}/delete', name: 'delete_event')]

    public function deleteEvent(EntityManagerInterface $em, Event $event, SendMail $mail): Response
    {
        //récupération des utilisateurs lié à l'événement supprimé
        $users = $em->getRepository(Participate::class)->findBy(['event' => $event]);

        //------- Supression de l'événement -------//

        //la donnée en base de donnée avec le paramètre $participate est préparé pour suppression
        $em->remove($event);
        // transfére dans la base de données toutes les modifications apportées
        $em->flush();
        //------- Supression de l'événement -------//

        //------- Envoi du mail aux différents users concerné par la suppression -------//
        foreach ($users as $user){

            $context = compact('user'); // informations des users
            $context['event'] = $event->getName(); // nom de l'event supprimé pour la vue du mail

            $mail->send(
                'admin@admin.fr', // adresse de l'admin
                $user->getUser()->getEmail(),   // adresse du user
                "Annulation d'événement",
                'mail',
                $context);
        }
        //------- Envoi du mail aux différents users concerné par la suppression fin -------//

        //redirection vers la page admin gestion événements
        return $this->redirectToRoute('admin_events_index');
    }

    // fonction pour bloqué un event
    #[Route('/event/lock', name: 'lock', methods: ['POST'])]

    public function lockEvent(EntityManagerInterface $em, Request $request, EventRepository $eventRepository): Response
    {

        if ($request->isMethod('POST')) {
            $eventId = $request->request->get('eventId');
            $event = $eventRepository->find($eventId);

            if ($event) {

                $isLock = $request->request->has('isLock');
                $event->setIsLock($isLock);
                $em->flush();
            }

            return $this->redirectToRoute('admin_events_index');
        }
    }

}