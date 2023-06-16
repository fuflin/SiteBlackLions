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


    #[Route('/users/ban', name: 'ban', methods: ['POST'])]
    public function banUser(EntityManagerInterface $em, Request $request, User $user): Response
    {

        if ($request->isMethod('POST')) {
            $banId = $request->request->get('_banned');
            
            $user->setIsBanned(true);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_users_index');
        }


        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $this->$em->flush();

        //     return $this->redirectToRoute('admin_users_index');
        // }

        
    }
}