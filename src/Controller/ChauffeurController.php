<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Form\ChauffeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ChauffeurController extends AbstractController
{

    #[Route('/chauffeur/new', name: 'chauffeur_new')]
    public function new(Request $request, EntityManagerInterface $em ,SluggerInterface $slugger): Response
    {
      
        $chauffeur = new Chauffeur();
        
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             // Gérer le téléchargement de la photo
             $photoFile = $form->get('photo')->getData();
             if ($photoFile) {

                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                    try {
                        $photoFile->move(
                            $this->getParameter('photos_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Gérer les erreurs de téléchargement
                    }
                              // Enregistrer le nom du fichier dans la base de données
                $chauffeur->setPhoto($newFilename);
             }
                    
                $em->persist($chauffeur);
                $em->flush();
                return $this->redirectToRoute('chauffeur_list');
        }
    

        return $this->render('chauffeur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/chauffeur', name: 'chauffeur_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $chauffeurs = $em->getRepository(Chauffeur::class)->findAll();
        return $this->render('chauffeur/list.html.twig', [
            'chauffeurs' => $chauffeurs,
        ]);
    }
}
