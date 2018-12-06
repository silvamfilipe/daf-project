<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Answer\AnswerId;
use App\Domain\QuestionManagement\Answer\Vote;
use App\Domain\UserManagement\User;
use DateTimeImmutable;

/**
 * Answer
 *
 * @package App\Domain\QuestionManagement
 */
class Answer
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var string
     */
    private $body;

    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * @var DateTimeImmutable
     */
    private $datePublished;

    /**
     * @var bool
     */
    private $correctAnswer = false;

    /**
     * @var int
     */
    private $positiveVotes = 0;

    /**
     * @var int
     */
    private $negativeVotes = 0;

    /**
     * Creates an Answer
     *
     * @param User     $user
     * @param Question $question
     * @param string   $body
     *
     * @throws \Exception
     */
    public function __construct(User $user, Question $question, string $body)
    {
        $this->answerId = new AnswerId();
        $this->datePublished = new DateTimeImmutable();
        $this->user = $user;
        $this->question = $question;
        $this->body = $body;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function datePublished(): DateTimeImmutable
    {
        return $this->datePublished;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function question(): Question
    {
        return $this->question;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function updateBody(string $body): Answer
    {
        $this->body = $body;
        return $this;
    }

    public function isCorrectAnswer(): bool
    {
        return $this->correctAnswer;
    }

    public function setAsCorrect(): Answer
    {
        $this->correctAnswer = true;
        return $this;
    }

    public function addVote(Vote $vote): Answer
    {
        if ($vote->isPositive()) {
            $this->positiveVotes++;
            return $this;
        }

        $this->negativeVotes++;
        return $this;
    }

    public function positiveVotes(): int
    {
        return $this->positiveVotes;
    }

    public function negativeVotes(): int
    {
        return $this->negativeVotes;
    }
}
