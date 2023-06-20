<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Service\SendMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/events', name: 'admin_events_')]

class EventsController extends AbstractController
{

    #[Route('/', name: 'index')]

    public function index(EntityManagerInterface $em):Response
    {
        $events = $em->getRepository(Event::class)->findAll();

        return $this->render('admin/events/index.html.twig', compact('events'));
    }


    
    #[Route('/event/{id}', name: 'delete')]

    public function sendMail(Event $event, SendMail $mail):Response
    {
        dd($event);

        return $this->redirectToRoute('admin_events_index');
    }

}