<?php

namespace App\Controller;

use App\Entity\Event;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Multimedia;
use App\Form\MultimediaType;
use App\Service\FileUploader;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MultimediaController extends AbstractController
{
    #[Route('/multimedia', name: 'app_multimedia')]
    public function index(EntityManagerInterface $em): Response
    {
        $videos = $em->getRepository(Multimedia::class)->getVideos();
        $images = $em->getRepository(Multimedia::class)->getImages();

        $events = $em->getRepository(Event::class)->findAll();

        return $this->render('multimedia/index.html.twig', [
            'videos' => $videos,
            'images' => $images,
            'events' => $events,
        ]);
    }


    //fonction pour ajouter un media
    #[Route('/multimedia/add', name: 'add_media')]

    public function add(EntityManagerInterface $em, Multimedia $media = null, FileUploader $fileUploader, Request $request): Response
    {

        $form = $this->createForm(MultimediaType::class, $media);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis ici géré par symfony)
        if ($form->isSubmitted() && $form->isValid()) {

                $posterFiles = $form->get('media')->getData(); // hydratation d'un fichier

                        // on boucle pour pouvoir ajouter plusieurs éléments en même temps

                        foreach($posterFiles as $posterFile) { // pour chaque élément dans le tableau $posterFiles

                            $media = new Multimedia(); // je crée un nouvel objet contenant mon image/vidéo

                            $posterFileName = $fileUploader->upload($posterFile); // on utilise le service upload pour chargé le média afin de le stocké en base de donnée
                            $media->setMedia($posterFileName);
                            $em->persist($media); // on persiste à chaque élément
                        }


            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_multimedia');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('multimedia/add.html.twig', [
            'mediaForm' => $form->createView()
        ]); // création du formulaire
    }

    // fonction pour afficher les détails d'un event
    #[Route('/multimedia/event/{id}', name: 'show_media')]

    public function showMedia(EntityManagerInterface $em, $id): Response
    {
        // dd($events);
        $event = $em->getRepository(Event::class)->find($id);

        $videos = $em->getRepository(Multimedia::class)->findVids($event);
        $images = $em->getRepository(Multimedia::class)->findImgs($event);

        // $medias = $em->getRepository(Multimedia::class)->findMedias($event);
        // dd($medias);

        return $this->render('multimedia/showMediaEvent.html.twig', [
            'event' => $event,
            // 'medias' => $medias,
            'images' => $images,
            'videos' => $videos
        ]);

    }

}
