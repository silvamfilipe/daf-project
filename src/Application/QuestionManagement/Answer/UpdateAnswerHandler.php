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
use App\Domain\QuestionManagement\Answer\Specification\UserOwnsAnswer;

/**
 * UpdateAnswerHandler
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class UpdateAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answersRepository;
    /**
     * @var UserOwnsAnswer
     */
    private $userOwnsAnswer;

    /**
     * Creates a UpdateAnswerHandler
     *
     * @param AnswersRepository $answersRepository
     * @param UserOwnsAnswer $userOwnsAnswer
     */
    public function __construct(AnswersRepository $answersRepository, UserOwnsAnswer $userOwnsAnswer)
    {
        $this->answersRepository = $answersRepository;
        $this->userOwnsAnswer = $userOwnsAnswer;
    }

    public function handle(UpdateAnswerCommand $command): Answer
    {
        $answer = $this->answersRepository->withAnswerId($command->answerId());
        if (! $this->userOwnsAnswer->isSatisfiedBy($answer)) {
            throw new SpecificationFailureException(
                "Cannot update answer. Only the answer owner can update it."
            );
        }

        $answer->updateBody($command->body());
        return $this->answersRepository->update($answer);
    }
}
