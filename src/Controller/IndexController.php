<?php

namespace App\Controller;

use App\Entity\Area;
use App\Entity\Competence;
use App\Entity\Question;
use App\Repository\AreaRepository;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\exactly;

class IndexController extends AbstractController
{
    private $session;

    /**
     * QuizController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }
    public function index(AreaRepository $areaRepository): Response
    {
        $this->session->set('numberQuestion', 0);
        $user = time();
        $this->session->set('user', $user);
        return $this->render('index/index.html.twig', [
            'areas' => $areaRepository->findAll(),
            'btnClass' => ['', 'primary', 'secondary', 'success', 'danger', 'warning']
        ]);
    }
    public function competence(Area $area): Response
    {
        return $this->render('index/competences.html.twig', [
            'competences' => $area->getCompetences(),
            'btnClass' => ['primary', 'secondary', 'success', 'danger', 'warning']
        ]);
    }

    public function addAreas(): Response
    {
        $fileContent = file_get_contents('obszary.csv');
        var_dump($fileContent);
        $contentArray = explode(PHP_EOL, $fileContent);
        unset($contentArray[0]);
        foreach ($contentArray as $line) {
            $lineArray = explode(';', $line);
            print_r($lineArray);
            if (!isset($lineArray[1])) {
                continue;
            }
            $area = new Area();
            $area->setId($lineArray[0])->setName($lineArray[1])->setDesription($lineArray[2]);
            $entityManage = $this->getDoctrine()->getManager();
            $entityManage->persist($area);
            $entityManage->flush();
        }
        return $this->redirectToRoute('index');
    }
    public function addCompetence(AreaRepository $areaRepository): Response
    {
        $fileContent = file_get_contents('kompetencje.csv');
        $contentArray = explode(PHP_EOL, $fileContent);
        unset($contentArray[0]);
        foreach ($contentArray as $line) {
            $lineArray = explode(';', $line);
            if (!isset($lineArray[1])) {
                continue;
            }
            $competence = new Competence();
            $competence->setId($lineArray[1])->setArea($areaRepository->find($lineArray[0]))->setName($lineArray[2])->setDescription($lineArray[3]);
            $entityManage = $this->getDoctrine()->getManager();
            $entityManage->persist($competence);
            $entityManage->flush();
        }
        return $this->redirectToRoute('index');
    }

    public function addQuestion(AreaRepository $areaRepository, CompetenceRepository $competenceRepository): Response
    {
        $fileContent = file_get_contents('pytania.csv');
        $contentArray = explode(PHP_EOL, $fileContent);

        unset($contentArray[0]);
        foreach ($contentArray as $line) {
            $lineArray = explode(';', $line);
            if (!isset($lineArray[1])) {
                continue;
            }
            $question = new Question();
            $question->setQuestion($lineArray[0])->setRange($lineArray[1])->setArea($areaRepository->find($lineArray[2]))->setCompetence($competenceRepository->find($lineArray[3]));
            $entityManage = $this->getDoctrine()->getManager();
            $entityManage->persist($question);
            $entityManage->flush();
        }
        return $this->redirectToRoute('index');

    }
}
