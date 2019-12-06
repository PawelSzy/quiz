<?php

namespace App\Controller;

use App\Service\QuizFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\QuizType;
use App\Classes\QuizData;

class QuizController extends AbstractController
{
    /**
     * @Route("/quiz", name="quiz")
     */
    public function index(QuizFactory $quizFactory, Request $request)
    {
        $questions = $quizFactory->createQuiz(2, 1);
        $form = $this->createForm(QuizType::class, new QuizData());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $quiz = $quizFactory->createQuiz($data->numberOfQuestions, $data->levelOfQuestion);
        }

            return $this->render('quiz/index.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}
