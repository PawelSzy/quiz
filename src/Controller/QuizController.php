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

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class QuizController extends AbstractController
{
    /**
     * @Route("/", name="quiz")
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
            else {
                $this->setQuizInSession($request, $quiz);
                return $this->redirectToRoute('quiz_test');
            }
        }

        return $this->render('quiz/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quiz", name="quiz_test")
     */
    public function quiz_test(Request $request)
    {
        $quiz = $this->getQuizFromSession($request);

        if (!$quiz->valid()) {
            return $this->redirectToRoute('quiz_end');
        }

        $question = $quiz->current();
        $answers = $question->getAnswers();

        $form = $this->createFormBuilder()
            ->add('answers', ChoiceType::class, [
                'choices' => $answers,
                'choice_label' => function ($choice, $key, $value) use ($answers) {
                    return $choice->getContent();
                },
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Następne pytanie'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // @TODO make posible to make multiple choices
            $answers = [$data['answers']];
            $question->checkIfAnswersAreCorrect($answers);

            foreach ($answers as $answer) {
                $quiz->addUserAnswer($question->getId(), $answer);
            }

            $quiz->next();

            return $this->redirectToRoute('quiz_test');
        }

        return $this->render('quiz/quiz_test.html.twig', [
            'form' => $form->createView(),
            'question' => $question->getContent(),
        ]);
    }

    /**
     * @Route("/quiz_end", name="quiz_end")
     */
    public function quiz_end(Request $request) {
        $quiz = $this->getQuizFromSession($request);

        return $this->render('quiz/quiz_end.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    public function setQuizInSession(Request $request, $quiz)
    {
        $session = $request->getSession();
        $session->set('quiz', $quiz);
    }

    public function getQuizFromSession(Request $request)
    {
        $session = $request->getSession();
        $quiz = $session->get('quiz');
        return $quiz;
    }
}
