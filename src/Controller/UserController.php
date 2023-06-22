<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserMailType;
use App\Form\ChangPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]

    public function index(): Response
    {
        return $this->render('user/index.html.twig', []);
    }


    //fonction pour modifier le pseudo ou le pseudo discord
    #[Route('/user/{id}/edit_nickname', name: 'edit_user_pseudo')]

    public function editNickname(EntityManagerInterface $em, User $user, Request $request): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form

            $em->persist($user); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_home');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('user/editPseudo.html.twig', [
            'pseudoForm' => $form->createView(),
            'edit'
        ]); // création du formulaire
    }

    //fonction pour modifier le pseudo ou le pseudo discord
    #[Route('/user/{id}/edit_email', name: 'edit_user_mail')]

    public function editMail(EntityManagerInterface $em, User $user, Request $request): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(UserMailType::class, $user);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form

            $em->persist($user); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_home');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('user/editEmail.html.twig', [
            'mailForm' => $form->createView(),
            'edit'
        ]); // création du formulaire
    }

    #[Route('/user/{id}/edit_password', name: 'edit_user_password')]

    public function editPassword(EntityManagerInterface $em, User $user, UserPasswordHasherInterface $hasher, Request $request): Response
    {

        // $user = $this->getUser();

        $form = $this->createForm(ChangPasswordType::class);
        $form->handleRequest($request);

        // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {

                $user->setPassword($form->getData()->getNewPassword());
            }

            $em->persist($user); // équivalent du prepare dans PDO
            $em->flush(); // équivalent de insert into (execute) dans PDO

            return $this->redirectToRoute('app_home');
        }

        // vue pour afficher le formulaire d'ajout
        return $this->render('user/editPassword.html.twig', [
            'passForm' => $form->createView(),
            'edit'
        ]); // création du formulaire
    }

    #[Route('/event/{id}/delete_user', name: 'delete_user')]

    public function deleteEvent(EntityManagerInterface $em, User $user): Response
    {
        $user = $this->getUser();

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
}
