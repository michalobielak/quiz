<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    public function addQuestion(): Response
    {
        $question = new Question();
        $question->setQuestion('Pytanie 1?')->setRange(1);
        $entityManage = $this->getDoctrine()->getManager();
        $entityManage->persist($question);
        $entityManage->flush();
        return $this->redirectToRoute('index');
    }
}
