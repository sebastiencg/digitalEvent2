<?php

namespace App\Controller;

use App\Entity\ResponseOfQuestion;
use App\Form\ResponseOfQuestionType;
use App\Repository\ResponseOfQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/response')]
class ResponseOfQuestionController extends AbstractController
{
    #[Route('', name: 'app_response_of_question_index', methods: ['GET'])]
    public function index(ResponseOfQuestionRepository $responseOfQuestionRepository): Response
    {
        return $this->render('response_of_question/index.html.twig', [
            'response_of_questions' => $responseOfQuestionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_response_of_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $responseOfQuestion = new ResponseOfQuestion();
        $form = $this->createForm(ResponseOfQuestionType::class, $responseOfQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responseOfQuestion);
            $entityManager->flush();

            return $this->redirectToRoute('app_response_of_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('response_of_question/new.html.twig', [
            'response_of_question' => $responseOfQuestion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_response_of_question_show', methods: ['GET'])]
    public function show(ResponseOfQuestion $responseOfQuestion): Response
    {
        return $this->render('response_of_question/show.html.twig', [
            'response_of_question' => $responseOfQuestion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_response_of_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ResponseOfQuestion $responseOfQuestion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResponseOfQuestionType::class, $responseOfQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_response_of_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('response_of_question/edit.html.twig', [
            'response_of_question' => $responseOfQuestion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_response_of_question_delete', methods: ['POST'])]
    public function delete(Request $request, ResponseOfQuestion $responseOfQuestion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responseOfQuestion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($responseOfQuestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_response_of_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
