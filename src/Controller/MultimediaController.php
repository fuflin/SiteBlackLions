<?php

namespace App\Controller;

use App\Entity\Multimedia;
use App\Form\MultimediaType;
use App\Service\FileUploader;
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
        $medias = $em->getRepository(Multimedia::class)->findAll();
        return $this->render('multimedia/index.html.twig', [
            'medias' => $medias,
        ]);
    }


    //fonction pour ajouter un media
    #[Route('/multimedia/add', name: 'add_media')]

    public function add(EntityManagerInterface $em, Multimedia $media = null, FileUploader $fileUploader, Request $request): Response
    {
        // if(!$media){

        //     $media = new Multimedia();
        // }

        $form = $this->createForm(MultimediaType::class, $media);
        $form->handleRequest($request);
        

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
            $medias = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form
                dd($medias);

                $posterFile = $form->get('media')->getData(); // hydratation d'un fichier

                if ($posterFile) {

                    $posterFileName = $fileUploader->upload($posterFile); // on utilise le service upload pour chargé le média afin de le stocké en base de donnée
                    $media->setMedia($posterFileName);
                }

            $em->persist($media); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_multimedia');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('multimedia/add.html.twig', [
            'mediaForm' => $form->createView()
        ]); // création du formulaire
    }
}
