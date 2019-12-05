<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\Answer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $questions = [
            [
                'content' => "Kiedy odbyła się bitwa pod Grunwaldem",
                'level' => 1,
                'multi' => 0,
                'answers' => [
                  [
                      'content' => '1410',
                      'correct' => 1,
                  ],
                  [
                    'content' => '1525',
                    'correct' => 0,
                  ],
                ],
            ],
            [
                'content' => "Data odkrycia ameryki",
                'level' => 1,
                'multi' => 0,
                'answers' => [
                    [
                        'content' => '1492',
                        'correct' => 1,
                    ],
                    [
                        'content' => '1525',
                        'correct' => 0,
                    ],
                ],
            ],
            [
                'content' => "Chrzest Polski",
                'level' => 1,
                'multi' => 0,
                'answers' => [
                    [
                        'content' => '996',
                        'correct' => 1,
                    ],
                    [
                        'content' => '1525',
                        'correct' => 0,
                    ],
                ],
            ],
            [
                'content' => "Bitwa pod Wiedniem",
                'level' => 2,
                'multi' => 0,
                'answers' => [
                    [
                        'content' => '1683',
                        'correct' => 1,
                    ],
                    [
                        'content' => '1525',
                        'correct' => 0,
                    ],
                ],
            ],
            [
                'content' => "Upadek Cesarstwa Rzymskiego",
                'level' => 2,
                'multi' => 0,
                'answers' => [
                    [
                        'content' => '476',
                        'correct' => 1,
                    ],
                    [
                        'content' => '660',
                        'correct' => 0,
                    ],
                ],
            ],
            [
                'content' => "Upadek Bizancjum - zdobycie Konstatynopola",
                'level' => 2,
                'multi' => 0,
                'answers' => [
                    [
                        'content' => '1453',
                        'correct' => 1,
                    ],
                    [
                        'content' => '1330',
                        'correct' => 0,
                    ],
                ],
            ],
            [
                'content' => "Bitwa pod Narwą",
                'level' => 3,
                'multi' => 0,
                'answers' => [
                    [
                        'content' => '1700',
                        'correct' => 1,
                    ],
                    [
                        'content' => '1330',
                        'correct' => 0,
                    ],
                    [
                        'content' => '1250',
                        'correct' => 0,
                    ],
                ],
            ],
        ];

        foreach ($questions as $questionValues) {
            $question = new Question();
            foreach ($questionValues['answers'] as $key => $answerValue) {
                $answer = new Answer();
                $answer->setContent($answerValue['content']);
                $answer->setCorrect($answerValue['correct']);
                $answer->setAnswerOrder($key);
                $manager->persist($answer);
                $question->addAnswer($answer);
            }
            $question->setContent($questionValues['content']);
            $question->setActive(1);
            $question->setQuestionLevel($questionValues['level']);
            $question->setSigleOrMulti($questionValues['multi']);
            $manager->persist($question);
        }

        $manager->flush();
    }
}
