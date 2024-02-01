<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Party;
use App\Entity\Point;
use App\Form\PartyType;
use App\Repository\CategoryRepository;
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
    public function makeParty(CategoryRepository $categoryRepository, SessionManager $sessionManager, ServiceQuestion $serviceQuestion,EntityManagerInterface $entityManager): Response
    {
        $participants=$sessionManager->getSession('user');

        if (is_array($participants) && count($participants) <= 1) {
            $sessionManager->clearSession();
            return $this->redirectToRoute('app_party', [], Response::HTTP_SEE_OTHER);
        }
        $categories = $categoryRepository->findAll();
        $questions = $serviceQuestion->getRandomQuestionsByCategory($categories);

        $party=new Party();
        foreach ($participants as $participant){

            $point= new Point();
            $point->setUsername($participant);
            $point->setPoint(0);
            $participant->setPoint($point);

            $party->addParticipant($participant);

            $entityManager->persist($point);
            $entityManager->persist($participant);
        }
        foreach ($questions as $question){
            $party->addQuestion($question[0]);
        }
        $entityManager->persist($party);
        $entityManager->flush();
        $sessionManager->clearSession();
        return $this->redirectToRoute('app_party_startGame', ['id' => $party->getId()]);
    }
    #[Route('/start/{id}', name: 'app_party_startGame')]
    public function startGame(Party $party): Response
    {
        dd($party->getParticipant()->getValues(),$party->getQuestion()->getValues());
        return $this->json($party->getQuestion()->getValues(),Response::HTTP_OK);

        return $this->render('party/show.html.twig',[
            "party"=>$party
        ] );
    }
    #[Route('/{id}/json', name: 'app_party_dataJson')]
    public function dataJson(Party $party): Response
    {
        return $this->json($party,Response::HTTP_OK,[],['groups'=>'game:read-one']);

        return $this->render('party/show.html.twig',[
            "party"=>$party
        ] );
    }
    #[Route('/test2/{id}', name: 'app_party_dataJso')]
    public function hhhh(Party $party): Response
    {

        return $this->render('party/score.html.twig',[
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

