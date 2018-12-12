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
 * DeleteAnswerCommand
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class DeleteAnswerCommand
{
    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * DeleteAnswerCommand constructor.
     * @param AnswerId $answerId
     */
    public function __construct(AnswerId $answerId)
    {
        $this->answerId = $answerId;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }
}
