<?php

namespace App\Controller;

use App\Entity\Draw;
use App\Form\DrawType;
use App\Repository\DrawRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/draw')]
class DrawController extends AbstractController
{
    #[Route('/', name: 'app_draw_index', methods: ['GET'])]
    public function index(DrawRepository $drawRepository): Response
    {
        return $this->render('draw/index.html.twig', [
            'draws' => $drawRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_draw_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $draw = new Draw();
        $form = $this->createForm(DrawType::class, $draw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($draw);
            $entityManager->flush();

            return $this->redirectToRoute('app_draw_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('draw/new.html.twig', [
            'draw' => $draw,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_draw_show', methods: ['GET'])]
    public function show(Draw $draw): Response
    {
        return $this->render('draw/show.html.twig', [
            'draw' => $draw,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_draw_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Draw $draw, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DrawType::class, $draw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_draw_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('draw/edit.html.twig', [
            'draw' => $draw,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_draw_delete', methods: ['POST'])]
    public function delete(Request $request, Draw $draw, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$draw->getId(), $request->request->get('_token'))) {
            foreach ($draw->getQuestion() as $question){
                $question->setDraw(null);
                $entityManager->persist($question);
            }
            $entityManager->remove($draw);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_draw_index', [], Response::HTTP_SEE_OTHER);
    }
}
