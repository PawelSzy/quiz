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
            $quiz = $quizFactory->createQuiz($data->levelOfQuestion, $data->numberOfQuestions);

            if ($quiz->getNumberOfQuestions() < $data->numberOfQuestions) {
                $error = new FormError("Nie ma tylu pytań z tego poziomu, zmiejsz liczbę pytań");
                $form->addError($error);
            }

            $session = $request->getSession();
            $session->set('quiz', $quiz);

            return $this->redirectToRoute('quiz_test');
        }

        return $this->render('quiz/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quiz_test", name="quiz_test")
     */
    public function quiz_test(Request $request)
    {
        $session = $request->getSession();
        $quiz = $session->get('quiz');
        return $this->render('quiz/quiz_test.html.twig', [
//            'form' => $form->createView(),
        ]);
    }

}
