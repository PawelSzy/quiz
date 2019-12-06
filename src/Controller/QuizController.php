<?php

namespace App\Controller;

use App\Service\QuizFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\QuizType;
use App\Quiz\QuizData;
use App\Quiz\Quiz;

class QuizController extends AbstractController
{
    /**
     * @Route("/quiz", name="quiz")
     */
    public function index(QuizFactory $quizFactory, Request $request)
    {
        $form = $this->createForm(QuizType::class, new QuizData());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            /**
             * @var App\Quiz\Quiz $quiz
             */
            $quiz = $quizFactory->createQuiz($data->numberOfQuestions, $data->levelOfQuestion);

            if ($quiz->getNumberOfQuestions() < $data->numberOfQuestions) {
                $error = new FormError("Nie ma tylu pytań z tego poziomu, zmiejsz liczbę pytań");
                $form->addError($error);
            }

            dump($quiz);

        }

        return $this->render('quiz/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
