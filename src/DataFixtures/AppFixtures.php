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
