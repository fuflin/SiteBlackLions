<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    //fonction pour créer un message
    #[Route('/message/send', name: 'send_message')]
    public function send(Request $request, EntityManagerInterface $em): Response
    {

        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $message->setSender($this->getUser());
            $message->setCreatedAt(new \DateTime());

            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute('app_message');
        }

        return $this->render("message/send.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    //affichage des messages reçus
    #[Route('/receive', name: 'receive')]
    public function receive(): Response
    {
        return $this->render('message/receive.html.twig');
    }

    //affichage des messages envoyés
    #[Route('/sent', name: 'sent')]
    public function sent(): Response
    {
        return $this->render('message/sent.html.twig');
    }

    //affichage du contenu des messages
    #[Route('/read/{id}', name: 'read')]
    public function read(Message $message, EntityManagerInterface $em): Response
    {
        $message->setIsRead(true);

        $em->persist($message);
        $em->flush();


        return $this->render('message/read.html.twig', compact('message'));
    }

    // fonction suppression message
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $em, Message $message): Response
    {
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('receive');
    }

}

