<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Party;
use App\Form\PartyType;
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
        return $this->render('party/index.html.twig', );
    }

    #[Route('/make/', name: 'app_party_make')]
    public function makeParty(QuestionRepository $questionRepository, SessionManager $sessionManager, ServiceQuestion $serviceQuestion,EntityManagerInterface $entityManager): Response
    {
        $allQuestions = $questionRepository->findAll();
        $questions = $serviceQuestion->Take10Question($allQuestions);
        $party=new Party();
        $participants=$sessionManager->getSession('user');
        foreach ($participants as $participant){
            $party->addParticipant($participant);
            $entityManager->persist($participant);
        }
        foreach ($questions as $question){
            $party->addQuestion($question);
        }
        $entityManager->persist($party);
        $entityManager->flush();
        $sessionManager->clearSession();
        return $this->redirectToRoute('app_party_startGame', ['id' => $party->getId()]);
    }
    #[Route('/start/{id}', name: 'app_party_startGame')]
    public function startGame(Party $party): Response
    {
        dd($party);
        return $this->render('party/show.html.twig',[
            "party"=>$party
        ] );
    }

        /*$allQuestions = $questionRepository->findAll();

        $randomKeys = array_rand($allQuestions, min(10, count($allQuestions)));

        $randomKeys = is_array($randomKeys) ? $randomKeys : [$randomKeys];

        $randomQuestions = [];
        foreach ($randomKeys as $key) {
            $randomQuestions[] = $allQuestions[$key];
        }

        shuffle($randomQuestions);

        return $this->render('party/show.html.twig', [
            'questions' => $randomQuestions,
        ]);
*/

        /*
            #[Route('/new', name: 'app_party_new')]
            public function newParty(Request $request,SessionManager $sessionManager): Response
            {
                $form = $this->createForm(PartyType::class);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $formData = $form->getData();
                    $key='username';
                    $sessionManager->createSession($key,$formData["username"]);
                    dd($sessionManager->getSession($key));
                }
                return $this->render('party/new.html.twig',[
                    'form' => $form->createView(),

                ] );
            }
        */
    }

