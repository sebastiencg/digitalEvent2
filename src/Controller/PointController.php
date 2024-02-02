<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointController extends AbstractController
{
    #[Route('/point/question/{QuestionId}/user/{userId}', name: 'app_point_one_point')]
    public function addOnePoint(
        #[MapEntity(id: 'QuestionId')] Question $question,
        #[MapEntity(id: 'userId')] Participant $participant,
        EntityManagerInterface $entityManager): Response
    {
        $point = $participant->getPoint()->getPoint() + $question->getPoint();
        $participant->getPoint()->setPoint($point);

        $entityManager->persist($participant);

        $entityManager->flush();

        return $this->json([],Response::HTTP_OK);
    }

    #[Route('/score', name: 'app_score')]
    public function score(): Response
    {

        return $this->render('party/score.html.twig', [
        ]);
    }
}
