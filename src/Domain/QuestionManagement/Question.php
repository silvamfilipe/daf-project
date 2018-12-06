<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\Question\Tag;
use App\Domain\UserManagement\User;
use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Question
 *
 * @package App\Domain\QuestionManagement
 */
class Question
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
     * @var Tag[]
     */
    private $tags = [];

    /**
     * @var QuestionId
     */
    private $questionId;

    /**
     * @var DateTimeImmutable
     */
    private $datePublished;

    /**
     * Creates a question
     *
     * @param User   $user
     * @param string $title
     * @param string $body
     * @param Tag[]  $tags
     *
     * @throws \Exception
     */
    public function __construct(User $user, string $title, string $body, array $tags = [])
    {
        $this->questionId = new QuestionId();
        $this->datePublished = new DateTimeImmutable();
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
        $this->addTags($tags);
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function datePublished(): DateTimeImmutable
    {
        return $this->datePublished;
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

    /**
     * @return Tag[]
     */
    public function tags(): array
    {
        return $this->tags;
    }

    public function update(string $title, string $body): Question
    {
        $this->body = $body;
        $this->title = $title;
        return $this;
    }

    public function addTags(array $tags): Question
    {
        $newTags = $this->tags;

        foreach ($tags as $tag) {
            if (!$tag instanceof Tag) {
                throw new InvalidArgumentException(
                    "One of the list items isn't a Tag."
                );
            }

            $newTags[] = $tag;
        }

        $this->tags = $newTags;
        return $this;
    }
}
