<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Answer;

use App\Domain\AnswersRepository;

/**
 * DeleteAnswerHandler
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class DeleteAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answersRepository;

    /**
     * DeleteAnswerHandler constructor.
     * @param AnswersRepository $answersRepository
     */
    public function __construct(AnswersRepository $answersRepository)
    {
        $this->answersRepository = $answersRepository;
    }

    public function handle(DeleteAnswerCommand $command)
    {
        $answer = $this->answersRepository->withAnswerId($command->answerId());
        $this->answersRepository->remove($answer);
        return $answer;
    }
}
