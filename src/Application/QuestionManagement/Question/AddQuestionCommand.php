<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Question;

use App\Domain\UserManagement\User;

/**
 * AddQuestionCommand
 *
 * @package App\Application\QuestionManagement\Question
 */
final class AddQuestionCommand
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $tags;

    /**
     * Creates a AddQuestionCommand
     *
     * @param User $user
     * @param string $title
     * @param string $body
     * @param array $tags
     */
    public function __construct(User $user, string $title, string $body, array $tags = [])
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
        $this->tags = $tags;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function tags(): array
    {
        return $this->tags;
    }
}
