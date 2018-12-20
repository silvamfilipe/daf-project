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
 * MarkCorrectAnswerCommand
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class MarkCorrectAnswerCommand
{
    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * Creates a MarkCorrectAnswerCommand
     *
     * @param AnswerId $answerId
     */
    public function __construct(AnswerId $answerId)
    {
        $this->answerId = $answerId;
    }

    /**
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }
}
