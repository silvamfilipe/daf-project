<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Answer;

use App\Domain\AnswersRepository;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\QuestionsRepository;

/**
 * AddAnswerHandler
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class AddAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answersRepository;
    /**
     * @var QuestionsRepository
     */
    private $questionsRepository;

    /**
     * Creates a AddAnswerHandler
     *
     * @param AnswersRepository $answersRepository
     * @param QuestionsRepository $questionsRepository
     */
    public function __construct(AnswersRepository $answersRepository, QuestionsRepository $questionsRepository)
    {
        $this->answersRepository = $answersRepository;
        $this->questionsRepository = $questionsRepository;
    }

    /**
     * @param AddAnswerCommand $command
     * @return Answer
     * @throws \Exception
     */
    public function handle(AddAnswerCommand $command): Answer
    {
        $question = $this->questionsRepository->withQuestionId($command->questionId());
        $answer = new Answer($command->user(),$question, $command->body());
        return $this->answersRepository->add($answer);
    }
}
