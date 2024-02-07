<?php

namespace App\Controller;

use App\Entity\Compter;
use App\Entity\Draw;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteurController extends AbstractController
{

    #[Route('/compteur/new', name: 'app_compteur_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $compteur = new Compter();
        $compteur->setCompteur(0);
        $compteur->setIsExplicationVisible(false);
        $compteur->setIsResponseVisible(false);
        $compteur->setNumberForm(2);
        $entityManager->persist($compteur);
        $entityManager->flush();
        return $this->json($compteur, Response::HTTP_OK);
    }


    #[Route('/compteur/{id}', name: 'app_compteur')]
    public function index(Compter $compter): Response
    {
        return $this->json($compter, Response::HTTP_OK);
    }


    #[Route('/compteur/{id}/up', name: 'app_compteur_up')]
    public function upCompter(Compter $compter, EntityManagerInterface $entityManager): Response
    {
        $compter->setCompteur($compter->getCompteur() + 1);

        $entityManager->persist($compter);
        $entityManager->flush();

        return $this->json($compter, Response::HTTP_OK);
    }


    #[Route('/compteur/{id}/down', name: 'app_compteur_down')]
    public function downCompter(Compter $compter, EntityManagerInterface $entityManager): Response
    {

        $compter->setCompteur(0);
        $entityManager->persist($compter);
        $entityManager->flush();

        return $this->json($compter, Response::HTTP_OK);
    }

    #[Route('/compteur/{id}/responseVisible', name: 'app_compteur_responseVisible')]
    public function responseVisible(Compter $compter, EntityManagerInterface $entityManager): Response
    {

        $compter->setIsResponseVisible(true);
        $entityManager->persist($compter);
        $entityManager->flush();

        return $this->json($compter, Response::HTTP_OK);
    }

    #[Route('/compteur/{id}/responseNoVisible', name: 'app_compteur_responseNoVisible')]
    public function responseNoVisible(Compter $compter, EntityManagerInterface $entityManager): Response
    {

        $compter->setIsResponseVisible(false);
        $entityManager->persist($compter);
        $entityManager->flush();

        return $this->json($compter, Response::HTTP_OK);
    }

    #[Route('/compteur/{id}/explicationVisible', name: 'app_compteur_explicationVisible')]
    public function explicationVisible(Compter $compter, EntityManagerInterface $entityManager): Response
    {

        $compter->setIsExplicationVisible(true);
        $entityManager->persist($compter);
        $entityManager->flush();

        return $this->json($compter, Response::HTTP_OK);
    }

    #[Route('/compteur/{id}/explicationNoVisible', name: 'app_compteur_explicationNoVisible')]
    public function explicationNoVisible(Compter $compter, EntityManagerInterface $entityManager): Response
    {

        $compter->setIsExplicationVisible(false);
        $entityManager->persist($compter);
        $entityManager->flush();

        return $this->json($compter, Response::HTTP_OK);
    }

    #[Route('/compteur/{compterId}/form/{formId}', name: 'app_participant_userOfGame', methods: ['GET', 'POST'])]
    public function formId(
        #[MapEntity(id: 'compterId')] Compter $compter,
        #[MapEntity(id: 'formId')] Draw $draw,
        EntityManagerInterface $entityManager): Response
    {
        $compter->setNumberForm($draw->getId());
        $entityManager->persist($compter);
        $entityManager->flush();
        return $this->json(["ok"], Response::HTTP_OK);
    }
}
