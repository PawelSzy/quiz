<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

class QuestionsController extends AbstractController
{
    /**
     * @Route("/questions", name="questions")
     */
    public function index(QuestionRepository $questionRepository, PaginatorInterface $paginator,  Request $request): Response
    {
//        var_dump($questionRepository->findAll());


//        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $pagination = $paginator->paginate($questionRepository->findAll(),$request->query->getInt('page', 1),10);

        return $this->render('questions/index.html.twig', [
            'pagination' => $pagination,
        ]);

//        return $this->render('questions/index.html.twig', [
//            'controller_name' => 'QuestionsController',
//        ]);
    }
}
