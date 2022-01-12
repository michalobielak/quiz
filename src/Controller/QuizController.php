<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Competence;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use App\Repository\CompetenceRepository;
use App\Repository\QuestionRepository;
use App\Repository\SummaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    private $session;

    //TODO ogarnąć podsumowanie
    /**
     * QuizController constructor.
     */
    public function __construct()
    {
//        $this->session = new Session();
    }

    public function index(Competence $competence, Request $request): Response
    {

        $this->session = $request->getSession();
        $this->session->set('competenceId', $competence->getId());
        $form = $this->createForm(AnswerType::class);
        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController', 'competence' => $competence,'form' => $form->createView()
        ]);
    }

    public function question(CompetenceRepository $competenceRepository, QuestionRepository $questionRepository, Request $request): Response
    {
        $answer = new Answer();
        $this->session = $request->getSession();

        $competenceId = $this->session->get('competenceId');
        if (is_null($competenceId)) {
            throw new \Exception('brak id kompetencji');
        }
        $competence = $competenceRepository->find($competenceId);
        $form = $this->createForm(AnswerType::class, $answer, ['attr' => ['id' => 'answer_form']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();
            $user = $this->session->get('user');

            $answer->setUser($user);
            $question = $questionRepository->find($form->get('question_id')->getData());
            $answer->setQuestion($question);
            $entityManage = $this->getDoctrine()->getManager();
            $entityManage->persist($answer);
            $entityManage->flush();
        }
        $numberQuestion = $this->session->get('numberQuestion');
        $questions = $competence->getQuestions();
        $questionsCount = $questions->count();
        var_dump($numberQuestion);
        var_dump($questionsCount);
        var_dump(array_keys($questions->toArray()));
        if ($questionsCount <= $numberQuestion) {
            return $this->redirectToRoute('summary');
        }
        $question = $questions->get($numberQuestion);
        $numberQuestion++;
        $this->session->set('numberQuestion', $numberQuestion);

        $form = $this->createForm(AnswerType::class, $answer, ['attr' => ['id' => 'answer_form']]);
        $form->get('question_id')->setData($question->getId());
        return $this->render('quiz/ajax/question.html.twig', [
            'question' => $question->getQuestion(),
            'controller_name' => 'QuizController',
            'form' => $form->createView()
        ]);
    }

    public function summary(QuestionRepository $questionRepository, AnswerRepository $answerRepository, SummaryRepository $summaryRepository, Request $request) {
        $points = 0;
        $maxPoints = 0;
        $this->session = $request->getSession();
        $answers = $answerRepository->findBy(['user' => $this->session->get('user')]);
        foreach ($answers as $answer) {
            $question = $questionRepository->find($answer->getQuestion());
            $maxPoints += ($question->getRange() * 5);
            $points += ($question->getRange() * $answer->getAnswer());
        }
        $summaryPercent = ($points / $maxPoints) * 100;
        if ($summaryPercent > 80) {
            $summaryDesc = 'Zaawansowany';
            $summary = $summaryRepository->findOneBy(
                [
                    'Competence' => $this->session->get('competenceId'),
                    'evalution' => 3
                ]
            );
        } else if ($summaryPercent > 40) {
            $summaryDesc = 'Srednio-zaawansowany';
            $summary = $summaryRepository->findOneBy(
                [
                    'Competence' => $this->session->get('competenceId'),
                    'evalution' => 2
                ]
            );

        } else {
            $summaryDesc = 'Podstawowy';
            $summary = $summaryRepository->findOneBy(
                [
                    'Competence' => $this->session->get('competenceId'),
                    'evalution' => 1
                ]
            );

        }
        return $this->render('quiz/ajax/summary.html.twig', [
            'summaryPercent' => $summaryPercent,
            'summaryDesc' => $summaryDesc,
            'summaryLongDesc' => $summary->getDescription(),
            'controller_name' => 'QuizController',
        ]);
    }
}
