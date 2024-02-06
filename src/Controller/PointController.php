<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\ParticipantOfDraw;
use App\Entity\Point;
use App\Entity\Question;
use App\Repository\ParticipantOfDrawRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointController extends AbstractController
{
    #[Route('/point/question/{QuestionId}/user/{userId}', name: 'app_point_one_point', methods: ['GET']),]
    public function addOnePoint(
        #[MapEntity(id: 'QuestionId')] Question $question,
        #[MapEntity(id: 'userId')] Participant $participant,
        EntityManagerInterface $entityManager): Response
    {
        if(!$participant->getPoint()){
            $point=$question->getPoint();
            $newPoint= new Point();
            $newPoint->setPoint($point);
            $participant->setPoint($newPoint);
            $entityManager->persist($newPoint);

        }
        else{
            $point = $participant->getPoint()->getPoint() + $question->getPoint();
            $participant->getPoint()->setPoint($point);

        }

        $entityManager->persist($participant);

        $entityManager->flush();
        return $this->json($participant, Response::HTTP_OK, [], ['groups' => 'game:read-one']);

    }

    #[Route('/score/', name: 'app_score')]
    public function score(ParticipantOfDrawRepository $participantOfDrawRepository): Response
    {
        $lastParticipantOfDraw = $participantOfDrawRepository->findOneBy([], ['id' => 'DESC']);
        $score = [];

        foreach ($lastParticipantOfDraw->getParticipant() as $participant) {
            $score[] = [
                'point' => $participant->getPoint(),
                'participant' => [
                    'id' => $participant->getId(),
                    'name' => $participant->getUsername(),
                ],
            ];
        }
        usort($score, function ($a, $b) {
            // Assurez-vous que 'point' est une propriété numérique de l'objet Point
            $pointA = $a['point']->getPoint();
            $pointB = $b['point']->getPoint();

            // Comparez les valeurs numériques
            return $pointB - $pointA;
        });


        return $this->json($score, Response::HTTP_OK, [], ['groups' => 'game:read-one']);

    }
}
