<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Answer;

use App\Domain\AnswersRepository;
use App\Domain\Exception\SpecificationFailureException;
use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\Specification\OnlyOneCorrectAnswerPerQuestion;
use App\Domain\QuestionManagement\Question\Specification\UserIsQuestionOwner;

/**
 * MarkCorrectAnswerHandler
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class MarkCorrectAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answersRepository;

    /**
     * @var UserIsQuestionOwner
     */
    private $isQuestionOwner;

    /**
     * @var OnlyOneCorrectAnswerPerQuestion
     */
    private $oneCorrectAnswerPerQuestion;

    /**
     * Creates a MarkCorrectAnswerHandler
     *
     * @param AnswersRepository $answersRepository
     * @param UserIsQuestionOwner $isQuestionOwner
     * @param OnlyOneCorrectAnswerPerQuestion $oneCorrectAnswerPerQuestion
     */
    public function __construct(
        AnswersRepository $answersRepository,
        UserIsQuestionOwner $isQuestionOwner,
        OnlyOneCorrectAnswerPerQuestion $oneCorrectAnswerPerQuestion
    ) {
        $this->answersRepository = $answersRepository;
        $this->isQuestionOwner = $isQuestionOwner;
        $this->oneCorrectAnswerPerQuestion = $oneCorrectAnswerPerQuestion;
    }

    public function handle(MarkCorrectAnswerCommand $command): Answer
    {
        $answer = $this->answersRepository->withAnswerId($command->answerId());

        if (!$this->isQuestionOwner->isSatisfiedBy($answer->question())) {
            throw new SpecificationFailureException(
                "Current user don't owns that answer's question. Only question's owner " .
                "can mark this answer as correct."
            );
        }

        if (!$this->oneCorrectAnswerPerQuestion->isSatisfiedBy($answer)) {
            throw new SpecificationFailureException(
                "Cannot mark answer as correct. Question's answer already have a correct answer."
            );
        }
        return $this->answersRepository->update($answer->setAsCorrect());
    }
}
