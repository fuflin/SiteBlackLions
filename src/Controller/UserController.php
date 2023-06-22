<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    //fonction pour modifier un user
    #[Route('/user/{id}/edit', name: 'edit_user')]

    public function editEvent(EntityManagerInterface $em, User $user, Request $request): Response
    {

        // $user = $this->getUser();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form

            $em->persist($user); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_home');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('user/index.html.twig', [
            'registrationForm' => $form->createView(),
            'edit'
        ]); // création du formulaire
    }
}
