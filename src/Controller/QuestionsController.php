<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\Response;

class QuestionsController extends AbstractController
{
    /**
     * @Route("/questions", name="questions")
     */
    public function index(QuestionRepository $questionRepository): JsonResponse
    {

        var_dump($questionRepository->findAll());

        return $this->json(['test' => 'books']);
    }
}
