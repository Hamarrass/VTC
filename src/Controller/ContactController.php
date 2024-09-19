<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contacts')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'contacts_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'contacts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'contact_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
            // Récupération manuelle de l'entité
            $contact = $entityManager->getRepository(Contact::class)->find($id);

            // Gestion du cas où l'entité n'est pas trouvée
            if (!$contact) {
                throw $this->createNotFoundException('Le contact n\'existe pas.');
            }
    
        // Créer le formulaire basé sur l'entité existante
        $form = $this->createForm(ContactType::class, $contact);

        // Gérer la requête (GET ou POST)
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les modifications dans la base de données
            $entityManager->flush();

            // Ajouter un message de succès (optionnel)
            $this->addFlash('success', 'Contact modifié avec succès!');

            // Rediriger vers une autre page (par exemple la liste des contacts)
            return $this->redirectToRoute('contacts_index');
        }

        // Afficher le formulaire
        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact,
        ]);
    }


    #[Route('/{id}', name: 'contacts_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/contact/{id}/delete', name: 'contact_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
          // Récupération manuelle de l'entité
          $contact = $entityManager->getRepository(Contact::class)->find($id);

          // Gestion du cas où l'entité n'est pas trouvée
          if (!$contact) {
              throw $this->createNotFoundException('Le contact n\'existe pas.');
          }
        // Vérification du token CSRF pour la sécurité
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();

            // Ajouter un message de confirmation
            $this->addFlash('success', 'Contact supprimé avec succès!');
        }

        // Rediriger vers la liste des contacts après la suppression
        return $this->redirectToRoute('contacts_index');
    }

}
