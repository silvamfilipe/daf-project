<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Answer;

use App\Domain\QuestionManagement\Answer\AnswerId;

/**
 * UpdateAnswerCommand
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class UpdateAnswerCommand
{
    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * @var string
     */
    private $body;

    /**
     * Creates a UpdateAnswerCommand
     *
     * @param AnswerId $answerId
     * @param string $body
     */
    public function __construct(AnswerId $answerId, string $body)
    {
        $this->answerId = $answerId;
        $this->body = $body;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function body(): string
    {
        return $this->body;
    }
}
