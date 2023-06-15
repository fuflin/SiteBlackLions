<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/users', name: 'admin_users_')]

class UsersController extends AbstractController
{

    #[Route('/', name: 'index')]

    public function index(EntityManagerInterface $em):Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/users/index.html.twig', compact('users'));
    }

    //fonction pour modifier un user
    // #[Route('/user/{id}/edit', name: 'edit_user')]

    // public function edituser(EntityManagerInterface $em, User $user = null, Request $request): Response
    // {

    //     $user = $this->getUser();

    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     // si (on a bien appuyer sur submit && que les infos du formalaire sont conformes au filter input qu'on aura mis)
    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $user = $form->getData(); // hydratation avec données du formulaire / injection des valeurs saisies dans le form

    //         $em->persist($user); // équivalent du prepare dans PDO
    //         $em->flush(); // équivalent de insert into (execute) dans PDO

    //         if( in_array('ROLE_ADMIN', $user->getRoles(), true) ){

    //             return $this->redirectToRoute('admin_users_index');

    //         } else {

    //             return $this->redirectToRoute('app_user');
    //         }
    //     }

    //     // vue pour afficher le formulaire d'ajout
    //     return $this->render('user/add.html.twig', [
    //         'userForm' => $form->createView(),
    //         'edit'
    //     ]); // création du formulaire
    // }

    // #[Route('/', name: 'index')]

    // public function banUser()
    // {

    // }

}