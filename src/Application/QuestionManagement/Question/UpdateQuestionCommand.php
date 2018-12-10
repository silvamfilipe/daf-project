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
 * UpdateQuestionCommand
 *
 * @package App\Application\QuestionManagement\Question
 */
final class UpdateQuestionCommand
{
    /**
     * @var QuestionId
     */
    private $questionId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $body;

    /**
     * Creates a UpdateQuestionCommand
     *
     * @param QuestionId $questionId
     * @param string $title
     * @param string $body
     */
    public function __construct(QuestionId $questionId, string $title, string $body)
    {
        $this->questionId = $questionId;
        $this->title = $title;
        $this->body = $body;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }
}
