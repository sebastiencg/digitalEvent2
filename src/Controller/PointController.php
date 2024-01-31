<?php

namespace App\Controller;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointController extends AbstractController
{
    #[Route('/point/one/{id}', name: 'app_point_one_point')]
    public function addOnePoint(Participant $participant, EntityManagerInterface $entityManager): Response
    {
        $point = $participant->getPoint()->getPoint() + 1;
        $participant->getPoint()->setPoint($point);

        $entityManager->persist($participant);

        $entityManager->flush();

        return $this->render('party/index.html.twig', [
        ]);
    }
    #[Route('/point/one/{id}', name: 'app_point_two_point')]
    public function addTwoPoint(Participant $participant, EntityManagerInterface $entityManager): Response
    {
        $point = $participant->getPoint()->getPoint() + 2;
        $participant->getPoint()->setPoint($point);

        $entityManager->persist($participant);

        $entityManager->flush();

        return $this->render('party/index.html.twig', [
        ]);
    }
    #[Route('/score', name: 'app_score')]
    public function score(): Response
    {
        return $this->render('party/score.html.twig', [
        ]);
    }
}
