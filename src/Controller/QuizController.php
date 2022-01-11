<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Competence;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
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

    public function index(Competence $competence): Response
    {
        $form = $this->createForm(AnswerType::class);
        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController', 'competence' => $competence,'form' => $form->createView()
        ]);
    }

    public function question(QuestionRepository $questionRepository, Request $request, Competence $competence): Response
    {
        $answer = new Answer();
        $this->session = $request->getSession();
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
}
