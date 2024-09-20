<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends AbstractController
{
    public function book(Request $request, EntityManagerInterface $em): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('course_success');
        }

        return $this->render('course/book.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}