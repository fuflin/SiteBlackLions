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
        // $posts = $em->getRepository(post::class)->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
            // 'posts' => $posts
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
           'postForm'=> $form->createView()
        ]);

    }

    // fonction pour supprimé un post
    #[Route('/event/{id}/delete/{idPost}', name: 'delete_post')]

    public function deleteMessage(EntityManagerInterface $em, Event $event, $idPost)
    {
        $post = $em->getRepository(Post::class)->find($idPost); //on cherche l'id du Post

         //on récupère le User en session

        if($event->getPosts()->contains($post)){

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

    #[Route("/events/search", name:"app_event_search", methods:["GET"])]

    public function search(Request $request, EventRepository $eventRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        // Utilisez la méthode appropriée du repository pour effectuer la recherche
        $event = $eventRepository->searchByNameOrDate($searchTerm);
        // dd($event);
        // Retournez la réponse en JSON
        return $this->json($event);
    }

    // #[Route("/events/search", name:"app_event_search", methods:["GET"])]

    // public function searchEvent(Request $request, EventRepository $eventRepository): Response
    // {

    //     $data = new SearchData();

    //     $form = $this->createForm(SearchForm::class, $data);
    //     dd($data);
    //     $form->handleRequest($request);
    //     // $data = $request->query->get('data');

    //     $event = $eventRepository->searchEvent($data);
    //     // dd($event);
    //     return $this->render('multimedia/index.html.twig', [
    //         'event' => $event,
    //         'form' => $form->createView(),
    //     ]);
    // }

}
