<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;

/**
 * UpdateQuestionHandler
 *
 * @package App\Application\QuestionManagement\Question
 */
final class UpdateQuestionHandler
{
    /**
     * @var QuestionsRepository
     */
    private $questions;

    /**
     * Creates a UpdateQuestionHandler
     *
     * @param QuestionsRepository $questions
     */
    public function __construct(QuestionsRepository $questions)
    {
        $this->questions = $questions;
    }

    public function handle(UpdateQuestionCommand $command): Question
    {
        $question = $this->questions->withQuestionId($command->questionId());
        $question->update($command->title(), $command->body());
        return $this->questions->update($question);
    }
}
