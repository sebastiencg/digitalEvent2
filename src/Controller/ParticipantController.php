<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\ParticipantOfDraw;
use App\Entity\Party;
use App\Entity\Point;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Service\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/participant')]
class ParticipantController extends AbstractController
{

    #[Route('/first', name: 'app_participant_new_first', methods: ['GET', 'POST'])]
    public function first(Request $request, EntityManagerInterface $entityManager,SessionManager $sessionManager): Response
    {
        $userObjects = $sessionManager->getSession('user');

        if (is_array($userObjects) && count($userObjects) >= 1) {
            $sessionManager->clearSession();
            return $this->redirectToRoute('app_party', [], Response::HTTP_SEE_OTHER);
        }

        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sessionManager->createSession("user",$participant);

            return $this->redirectToRoute('app_participant_new_second', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }
    #[Route('/seconde', name: 'app_participant_new_second', methods: ['GET', 'POST'])]
    public function second(Request $request, EntityManagerInterface $entityManager,SessionManager $sessionManager): Response
    {
        $userObjects = $sessionManager->getSession('user');

        if (is_array($userObjects) && count($userObjects) >= 2) {

            $sessionManager->clearSession();
            return $this->redirectToRoute('app_party', [], Response::HTTP_SEE_OTHER);
        }
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionManager->createSession("user",$participant);
            return $this->redirectToRoute('app_participant_new_third', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }
    #[Route('/third', name: 'app_participant_new_third', methods: ['GET', 'POST'])]
    public function third(Request $request, EntityManagerInterface $entityManager,SessionManager $sessionManager): Response
    {
        $userObjects = $sessionManager->getSession('user');

        if (is_array($userObjects) && count($userObjects) >= 3) {
            $sessionManager->clearSession();
            return $this->redirectToRoute('app_party', [], Response::HTTP_SEE_OTHER);
        }

        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sessionManager->createSession("user",$participant);
            return $this->redirectToRoute('app_participant_game', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
            'onlyToo'=>true
        ]);
    }
    #[Route('/make', name: 'app_participant_game', methods: ['GET', 'POST'])]
    public function parti(Request $request, EntityManagerInterface $entityManager,SessionManager $sessionManager): Response
    {
        $participants = $sessionManager->getSession('user');
        $participantOfDraw = new  ParticipantOfDraw();
        foreach ($participants as $participant) {

            $point = new Point();
            $point->setUsername($participant);
            $point->setPoint(0);
            $participant->setPoint($point);

            $participantOfDraw->addParticipantOfDraw($participant);

            $entityManager->persist($point);
            $entityManager->persist($participant);
        }
        $entityManager->persist($participantOfDraw);
        $entityManager->flush();
        return $this->json(["ok"],Response::HTTP_OK);
    }
//______________________________________________________________________________________
    #[Route('/new', name: 'app_participant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SessionManager $sessionManager): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }
    #[Route('/all', name: 'app_participant_index', methods: ['GET', 'POST'])]
    public function index(ParticipantRepository $participantRepository): Response
    {

        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll()
        ]);
    }

    #[Route('/{userId1}/{userId2}/{userId3}', name: 'app_participant_userOfGame', methods: ['GET', 'POST'])]
    public function userOfGame(
        #[MapEntity(id: 'userId1')] Participant $participant1,
        #[MapEntity(id: 'userId2')] Participant $participant2,
        #[MapEntity(id: 'userId3')] Participant $participant3,
        Request $request, EntityManagerInterface $entityManager,SessionManager $sessionManager): Response
    {
        $participantOfDraw = new  ParticipantOfDraw();
        $participantOfDraw->addParticipant($participant1);
        $participantOfDraw->addParticipant($participant2);
        $participantOfDraw->addParticipant($participant3);
        $entityManager->persist($participantOfDraw);
        $entityManager->flush();
        return $this->json(["ok"],Response::HTTP_OK);

    }


}
