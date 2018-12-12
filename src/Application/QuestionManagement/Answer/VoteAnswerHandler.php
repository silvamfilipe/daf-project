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

/**
 * VoteAnswerHandler
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class VoteAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answersRepository;

    /**
     * Creates a VoteAnswerHandler
     *
     * @param AnswersRepository $answersRepository
     */
    public function __construct(AnswersRepository $answersRepository)
    {
        $this->answersRepository = $answersRepository;
    }

    public function handle(VoteAnswerCommand $command): Answer
    {
        $answer = $this->answersRepository->withAnswerId($command->answerId());
        return $this->answersRepository->update(
            $answer->addVote($command->vote())
        );
    }
}
