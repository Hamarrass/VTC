<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{

    #[Route('/voiture/new', name: 'voiture_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('voiture_list');
        }

        return $this->render('voiture/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/voiture', name: 'voiture_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $voitures = $em->getRepository(Voiture::class)->findAll();
        return $this->render('voiture/list.html.twig', [
            'voitures' => $voitures,
        ]);
    }
}
