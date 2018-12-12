<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Answer;

use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\UserManagement\User;

/**
 * AddAnswerCommand
 *
 * @package App\Application\QuestionManagement\Answer
 */
final class AddAnswerCommand
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var QuestionId
     */
    private $questionId;

    /**
     * @var string
     */
    private $body;

    /**
     * Creates an AddAnswerCommand
     *
     * @param User $user
     * @param QuestionId $questionId
     * @param string $body
     */
    public function __construct(User $user, QuestionId $questionId, string $body)
    {
        $this->user = $user;
        $this->questionId = $questionId;
        $this->body = $body;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function body(): string
    {
        return $this->body;
    }
}
