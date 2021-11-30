<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    //TODO ogarnąć podsumowanie
    public function index(): Response
    {
        $form = $this->createForm(AnswerType::class);
        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController','form' => $form->createView()
        ]);
    }

    public function question(QuestionRepository $questionRepository, Request $request): Response
    {
        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer, ['attr' => ['id' => 'answer_form']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();
            //TODO ogarnąć zapis i odczyt usera z sesji (nawet zwykły timestamp z momentu gdy zaczęto rozwiązywać quiz)
            $answer->setUser(1);
            $question = $questionRepository->find($form->get('question_id')->getData());
            $answer->setQuestion($question);
            $entityManage = $this->getDoctrine()->getManager();
            $entityManage->persist($answer);
            $entityManage->flush();
            return $this->redirectToRoute('quiz');
        }
        //TODO losowanie pytań
        $question = $questionRepository->find(1);
        $form->get('question_id')->setData($question->getId());
        return $this->render('quiz/ajax/question.html.twig', [
            'question' => $question->getQuestion(),
            'controller_name' => 'QuizController',
            'form' => $form->createView()
        ]);
    }
}
