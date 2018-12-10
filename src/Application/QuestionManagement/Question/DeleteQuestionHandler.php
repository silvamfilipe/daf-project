<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Question;

use App\Domain\QuestionManagement\QuestionsRepository;

/**
 * DeleteQuestionHandler
 *
 * @package App\Application\QuestionManagement\Question
 */
final class DeleteQuestionHandler
{
    /**
     * @var QuestionsRepository
     */
    private $questionsRepository;

    /**
     * Creates a DeleteQuestionHandler
     *
     * @param QuestionsRepository $questionsRepository
     */
    public function __construct(QuestionsRepository $questionsRepository)
    {
        $this->questionsRepository = $questionsRepository;
    }

    public function handle(DeleteQuestionCommand $command): void
    {
        $question = $this->questionsRepository->withQuestionId($command->questionId());
        $this->questionsRepository->remove($question);
    }
}
