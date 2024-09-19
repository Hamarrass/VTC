<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Form\DisponibiliteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisponibiliteController extends AbstractController
{

    #[Route('/disponibilite/new', name: 'disponibilite_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $disponibilite = new Disponibilite();
        $form = $this->createForm(DisponibiliteType::class, $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($disponibilite);
            $em->flush();
            return $this->redirectToRoute('disponibilite_list');
        }

        return $this->render('disponibilite/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/disponibilite', name: 'disponibilite_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $disponibilites = $em->getRepository(Disponibilite::class)->findAll();
        return $this->render('disponibilite/list.html.twig', [
            'disponibilites' => $disponibilites,
        ]);
    }
}
