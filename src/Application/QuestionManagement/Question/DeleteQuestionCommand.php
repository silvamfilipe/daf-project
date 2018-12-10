<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question\QuestionId;

/**
 * DeleteQuestionCommand
 *
 * @package App\Application\QuestionManagement\Question
 */
final class DeleteQuestionCommand
{
    /**
     * @var QuestionId
     */
    private $questionId;

    /**
     * Creates a DeleteQuestionCommand
     *
     * @param QuestionId $questionId
     */
    public function __construct(QuestionId $questionId)
    {
        $this->questionId = $questionId;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}
