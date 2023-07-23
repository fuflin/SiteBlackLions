<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Event;
use App\Form\PostType;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Participate;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    // affichage de tous les events dans la base de données
    #[Route('/event', name: 'app_event')]

    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator): Response
    {
        $events = $em->getRepository(Event::class)->findBy([], ['date_create' => 'DESC']);

        $pagination = $paginator->paginate(
            $em->getRepository(Event::class)->paginationQuery(),
            $request->query->get('page', 1),
            3
        );

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
            // 'events' => $events,
            'pagination' => $pagination
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

        //---- condition pour vérifier si l'utilisateur est bien connecté ----//
        if (!$user) { // si la personne n'a pas de compte
            //un message d'alerte s'affiche
            $this->addFlash("danger", "Veuillez vous connecter pour vous inscrire à l'événement");
            //et l'utilisateur sera renvoyé vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        //--- condition bloqué inscription quand limite personne atteinte + bloqué inscriptions à j-2 de la date de l'event ---//

        // variable créer pour récupérer le nombre de participant à un event
        $placeEvent = $em->getRepository(Participate::class)->getInscrit($event);

        //variable pour créer pour le calcule de la différence de la date
        $dateInscription = new \DateTime();// j'instancie la classe DateTime à la date du jour
        $dateEvenement = $event->getDateCreate();//on attribue à cette variable la date de l'event

        $diff = $dateEvenement->diff($dateInscription)->days;//variable contenant le résultat de la différence

        // si la différence est supérieur ou égale à 2 OU que le nombre de place est équivalent au nombre limite de place de l'event
        if ($diff <= 2 || $placeEvent == $event->getNbMaxPers()) {

            $event->setIsLock(true);//alors on modifie l'état is_lock à true
            $this->addFlash("danger", "Clôture des inscriptions");//on affichera un message pour informer les utilisateurs

            $em->persist($event);// prépare les données à enregistré en base de données
            $em->flush();// transfére dans la base de données toutes les modifications apportées
            // cela nous redirigera vers la page d'affichage des events
            return $this->redirectToRoute('app_event');
        }

        //----- partie pour l'inscription -----//
        $participate = new Participate();//j'instancie la classe participate

        //on va attribuer différentes données

        $participate->setDateRegis($dateInscription);// on attribue la date d'inscription
        $participate->setUser($user);// on attribue le bon user
        $participate->setEvent($event);// on attribue le bon event

        $this->addFlash("success", "Inscription validée");//message de confirmation pour l'inscription

        $em->persist($participate);// prépare les données à enregistré en base de données
        $em->flush();// transfére dans la base de données toutes les modifications apportées

        return $this->redirectToRoute('app_event');// redirection vers la page événement
    }

    // fonction pour désinscrire à un événement
    #[Route('/event/{id}/remove/{idParticipate}', name: 'remove_regis_event')]

    public function removeRegisEvent(EntityManagerInterface $em, Event $event, $idParticipate)
    {
        //on cherche l'id de la participation
        $participate = $em->getRepository(Participate::class)->find($idParticipate);

        $user = $this->getUser(); //on récupère le User en session

        // si le user connecté ET l'événement dans le tableau à un ID identique alors
        if ($user && $event->getParticipates()->contains($participate)) {

            //la donnée en base de donnée avec le paramètre $participate est préparé pour suppression
            $em->remove($participate);
        }

        $em->flush();// transfére dans la base de données toutes les modifications apportées

        //retour à la page d'affichage des événements
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
