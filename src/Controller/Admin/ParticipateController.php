<?php

namespace App\Controller\Admin;

use App\Entity\Participate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/participate', name: 'admin_participate_')]

class ParticipateController extends AbstractController
{

    #[Route('/', name: 'index')]

    public function index(EntityManagerInterface $em):Response
    {
        $participates = $em->getRepository(Participate::class)->findAll();

        return $this->render('admin/participate/index.html.twig', compact('participates'));
    }

}