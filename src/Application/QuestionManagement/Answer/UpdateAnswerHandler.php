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
     * Creates a UpdateAnswerHandler
     *
     * @param AnswersRepository $answersRepository
     */
    public function __construct(AnswersRepository $answersRepository)
    {
        $this->answersRepository = $answersRepository;
    }

    public function handle(UpdateAnswerCommand $command): Answer
    {
        $answer = $this->answersRepository->withAnswerId($command->answerId());
        $answer->updateBody($command->body());
        return $this->answersRepository->update($answer);
    }
}
