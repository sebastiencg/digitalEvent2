<?php

namespace App\Controller;

use App\Entity\Draw;
use App\Entity\Participant;
use App\Entity\ParticipantOfDraw;
use App\Entity\Party;
use App\Entity\Point;
use App\Form\PartyType;
use App\Repository\CategoryRepository;
use App\Repository\DrawRepository;
use App\Repository\ParticipantOfDrawRepository;
use App\Repository\PartyRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResponseOfQuestionRepository;
use App\Service\SessionManager;
use App\Service\ServiceQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/party')]
class PartyController extends AbstractController
{
    #[Route('/', name: 'app_party')]
    public function index(): Response
    {
        return $this->render('party/index.html.twig',);
    }

    /**
     * #[Route('/make/', name: 'app_party_make')]
     * public function makeParty(CategoryRepository $categoryRepository, SessionManager $sessionManager, ServiceQuestion $serviceQuestion, EntityManagerInterface $entityManager): Response
     * {
     * $participants = $sessionManager->getSession('user');
     *
     * if (is_array($participants) && count($participants) <= 1) {
     * $sessionManager->clearSession();
     * return $this->redirectToRoute('app_party', [], Response::HTTP_SEE_OTHER);
     * }
     * $categories = $categoryRepository->findAll();
     * $questions = $serviceQuestion->getRandomQuestionsByCategory($categories);
     *
     * $party = new Party();
     * foreach ($participants as $participant) {
     *
     * $point = new Point();
     * $point->setUsername($participant);
     * $point->setPoint(0);
     * $participant->setPoint($point);
     *
     * $party->addParticipant($participant);
     *
     * $entityManager->persist($point);
     * $entityManager->persist($participant);
     * }
     * foreach ($questions as $question) {
     * $party->addQuestion($question[0]);
     * }
     * $entityManager->persist($party);
     * $entityManager->flush();
     * $sessionManager->clearSession();
     * return $this->redirectToRoute('app_party_startGame', ['id' => $party->getId()]);
     * }
 */
   /* #[Route('/make/{id}', name: 'app_party_make')]
    public function makeParty(CategoryRepository $categoryRepository, SessionManager $sessionManager, ServiceQuestion $serviceQuestion, EntityManagerInterface $entityManager): Response
    {
        $participants = $sessionManager->getSession('user');

        if (is_array($participants) && count($participants) <= 1) {
            $sessionManager->clearSession();
            return $this->redirectToRoute('app_party', [], Response::HTTP_SEE_OTHER);
        }
        $categories = $categoryRepository->findAll();
        $questions = $serviceQuestion->getRandomQuestionsByCategory($categories);

        $party = new Party();
        foreach ($participants as $participant) {

            $point = new Point();
            $point->setUsername($participant);
            $point->setPoint(0);
            $participant->setPoint($point);

            $party->addParticipant($participant);

            $entityManager->persist($point);
            $entityManager->persist($participant);
        }
        foreach ($questions as $question) {
            $party->addQuestion($question[0]);
        }
        $entityManager->persist($party);
        $entityManager->flush();
        $sessionManager->clearSession();
        return $this->redirectToRoute('app_party_startGame', ['id' => $party->getId()]);
    }
*/
    #[Route('/start/last', name: 'app_party_lastGame')]
    public function lastGame(DrawRepository $partyRepository): Response
    {
        $lastParty = $partyRepository->findOneBy([], ['id' => 'DESC']);

        if (!$lastParty) {
            throw $this->createNotFoundException('Aucune partie trouvée.');
        }
        return $this->json($lastParty, Response::HTTP_OK, [], ['groups' => 'game:read-one']);
    }



    #[Route('/start/{id}', name: 'app_party_startGame')]
    public function startGame(Party $party): Response
    {
        return $this->json($party, Response::HTTP_OK, [], ['groups' => 'game:read-one']);
    }

    #[Route('/make/{id}', name: 'app_party_show')]
    public function party(Draw $draw, EntityManagerInterface $entityManager,ParticipantOfDrawRepository $participantOfDrawRepository): Response
    {
        $lastParticipantOfDraw = $participantOfDrawRepository->findOneBy([], ['id' => 'DESC']);
        $lastParticipantOfDraw->setDraw($draw);
        $entityManager->persist($lastParticipantOfDraw);
        $entityManager->flush();

        return $this->json($lastParticipantOfDraw, Response::HTTP_OK, [], ['groups' => 'game:read-one']);
    }

}
