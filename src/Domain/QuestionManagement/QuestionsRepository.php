<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement;

use App\Domain\Exception\QuestionNotFoundException;
use App\Domain\QuestionManagement\Question\QuestionId;

/**
 * QuestionsRepository
 *
 * @package App\Domain\QuestionManagement
 */
interface QuestionsRepository
{
    /**
     * Adds a question to de repository
     *
     * @param Question $question
     *
     * @return Question
     */
    public function add(Question $question): Question;

    /**
     * Persists question changes
     *
     * @param Question $question
     *
     * @return Question
     */
    public function update(Question $question): Question;

    /**
     * Remove question from repository
     *
     * @param Question $question
     */
    public function remove(Question $question): void;

    /**
     * @param QuestionId $questionId
     * @return Question
     *
     * @throws QuestionNotFoundException if no question was not found with provided ID
     */
    public function withQuestionId(QuestionId $questionId): Question;
}
