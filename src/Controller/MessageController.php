<?php

namespace App\Controller;

use App\Entity\Event;
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

    #[Route('/event/{id}/message/new', name: 'new_message_event')]
    public function newMessage(Event $event, EntityManagerInterface $em, Request $request): Response
    {
        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message->setUser($this->getUser());
            $message->setEvent($event);

            $message = $form->getData();

            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
        }

        return $this->render('event/messageForm.html.twig', [
            // 'event' => $event,
            'messageForm' => $form->createView()
        ]);
    }
}
