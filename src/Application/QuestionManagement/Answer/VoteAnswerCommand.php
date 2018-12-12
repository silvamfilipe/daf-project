<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Answer;

use App\Domain\QuestionManagement\Answer\AnswerId;
use App\Domain\QuestionManagement\Answer\Vote;

/**
 * VoteAnswerCommand
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class VoteAnswerCommand
{
    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * @var Vote
     */
    private $vote;

    /**
     * Creates a VoteAnswerCommand
     *
     * @param AnswerId $answerId
     * @param Vote $vote
     */
    public function __construct(AnswerId $answerId, Vote $vote)
    {
        $this->answerId = $answerId;
        $this->vote = $vote;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function vote(): Vote
    {
        return $this->vote;
    }
}
