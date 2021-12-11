<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\exactly;

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
        $fileContent = file_get_contents('pytania.csv');
        $contentArray = explode('\n', $fileContent);

        foreach ($contentArray as $line) {
            $lineArray = explode(';', $line);
            print_r($lineArray);
            if (!isset($lineArray[1])) {
                continue;
            }
            $question = new Question();
            $question->setQuestion($lineArray[0])->setRange($lineArray[1]);
            $entityManage = $this->getDoctrine()->getManager();
            $entityManage->persist($question);
            $entityManage->flush();
        }
        return $this->redirectToRoute('index');

    }
}
