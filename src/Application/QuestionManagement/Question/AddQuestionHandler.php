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
 * AddQuestionHandler
 *
 * @package App\Application\QuestionManagement\Question
 */
final class AddQuestionHandler
{
    /**
     * @var QuestionsRepository
     */
    private $questions;

    use TagRelatedMethods;

    /**
     * Creates a AddQuestionHandler
     *
     * @param QuestionsRepository $questions
     */
    public function __construct(QuestionsRepository $questions)
    {
        $this->questions = $questions;
    }

    /**
     * @param AddQuestionCommand $command
     *
     * @return Question
     *
     * @throws \Exception
     */
    public function handle(AddQuestionCommand $command): Question
    {
        $question = new Question(
            $command->user(),
            $command->title(),
            $command->body(),
            $this->normalizeTags($command->tags())
        );
        return $this->questions->add($question);
    }

    /**
     * Returns the questions repository
     *
     * @return QuestionsRepository
     */
    protected function questionsRepository(): QuestionsRepository
    {
        return $this->questions;
    }
}
