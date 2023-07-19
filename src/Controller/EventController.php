<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Post;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\PostType;
use App\Entity\Participate;
use App\Repository\EventRepository;
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

        // condition pour vérouiller un événement en fonction de sa date
        foreach ($events as $event) {
            $dateActuelle = new \DateTime();
            $dateEvenement = $event->getDateCreate();

            if ($dateEvenement < $dateActuelle) {
        // si on a un différence sup ou égal à 2 jours ou que la date actuelle est supérieur(passée)
        // à la date de l'événement
                $event->setIsLock(true); // alors nous passons l'état is_lock à vrai
            }
        }

        $em->flush(); // Sauvegarde les modifications en base de données

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'description' => "ceci est la liste des événements du site BlackLions",
            'title' => "Liste des événements"
        ]);
    }


    // fonction pour afficher les détails d'un event
    #[Route('/event/{id}', name: 'show_event')]

    public function showEvent(Event $event, EntityManagerInterface $em, Request $request): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        $posts = $em->getRepository(Post::class)->findBy(['event' => $event]);

        $user = $this->getUser();

        $participates = $em->getRepository(Participate::class)->findBy(['user' => $user]);
        // dd($participates);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setUser($this->getUser());
            $post->setEvent($event);

            $post = $form->getData();

            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'Veuillez vous inscrire pour pouvoir chatter',
                'flashpost'
            );
            return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
        }

        return $this->render('event/detailEvent.html.twig', [
            'event' => $event,
            'participates' => $participates,
            'posts' => $posts,
            'postForm' => $form->createView()
        ]);
    }

    // fonction pour supprimé un post
    #[Route('/event/{id}/delete/{idPost}', name: 'delete_post')]

    public function deleteMessage(EntityManagerInterface $em, Event $event, $idPost)
    {
        $post = $em->getRepository(Post::class)->find($idPost); //on cherche l'id du Post

        //on récupère le User en session

        if ($event->getPosts()->contains($post)) {

            $em->remove($post);
        }

        $em->flush();
        return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
    }

    // fonction pour s'inscrire à un événement
    #[Route('/event/{id}/regis', name: 'regis_event')]

    public function regisEvent(EntityManagerInterface $em, Event $event)
    {
        $user = $this->getUser(); //on récupère le User en session

        if (!$user) { // si la personne n'a pas de compte , elle est renvoyé vers la page d'inscription
            $this->addFlash("danger", "Veuillez vous connecter pour vous inscrire à l'événement");
            return $this->redirectToRoute('app_login');
        }

        //condition bloqué inscription quand limite personne atteinte
        // partie condition pour bloqué les inscriptions à j-2 de la date de l'event

        // variable créer pour récupérer le nombre de participant à un event
        $placeEvent = $em->getRepository(Participate::class)->getNbRegis($event);

        //variable pour créer pour le calcule de la différence de la date
        $dateInscription = new \DateTime();
        $dateEvenement = $event->getDateCreate();
        //variable contenant le résultat de la différence
        $diff = $dateEvenement->diff($dateInscription)->days;

        if ($diff <= 2 || $placeEvent == $event->getNbMaxPers()) {

            $event->setIsLock(true);
            $this->addFlash("danger", "Clôture des inscriptions");

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event'); // Si l'inscription est effectuée trop près de la date de l'événement, rediriger vers une autre page.
        }
        // fin de partie condition

        $participate = new Participate();

        $participate->setDateRegis($dateInscription);
        $participate->setUser($user);
        $participate->setEvent($event);

        $this->addFlash("success", "Inscription validée");
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

        if ($user && $event->getParticipates()->contains($participate)) {

            $em->remove($participate);
        }

        $em->flush();
        return $this->redirectToRoute('app_event');
    }

    // fonction pour la recherche d'event par nom
    #[Route("/events/search", name: "app_event_search", methods: ["GET"])]

    public function search(Request $request, EventRepository $eventRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        // Utilisez la méthode appropriée du repository pour effectuer la recherche
        $event = $eventRepository->searchByNameOrDate($searchTerm);

        // Retournez la réponse en JSON
        return $this->json($event);
    }
}
