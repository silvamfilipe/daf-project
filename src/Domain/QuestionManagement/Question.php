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
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use InvalidArgumentException;
use JsonSerializable;

/**
 * Question
 *
 * @package App\Domain\QuestionManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="questions")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 * @IgnoreAnnotation("OA\Items")
 *
 * @OA\Schema(
 *     title="Question",
 *     description="Question",
 * )
 */
class Question implements JsonSerializable
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\UserManagement\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @OA\Property(
     *     description="User relation",
     *     title="User",
     * )
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Question title",
     *     example="An example question"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @OA\Property(
     *     description="Question body",
     *     example="How can we create an API with Symfony 4?"
     * )
     */
    private $body;

    /**
     * @var array|Tag[]
     *
     * @ORM\ManyToMany(targetEntity="App\Domain\QuestionManagement\Question\Tag", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinTable(name="question_tags",
     *      joinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     *
     * @OA\Property(
     *     description="Question tags",
     *     title="Tags",
     *     @OA\Items(ref="#/components/schemas/Tag")
     * )
     */
    private $tags = [];

    /**
     * @var QuestionId
     *
     * @ORM\Id()
     * @ORM\Column(type="QuestionId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     *  @OA\Property(
     *     type="string",
     *     description="Question identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private $questionId;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", name="date_published")
     *
     * @OA\Property(ref="#/components/schemas/DateTime")
     */
    private $datePublished;

    /**
     * @var Answer[]
     *
     * ORM\OneToMany(targetEntity="App\Domain\QuestionManagement\Answer", mappedBy="question")
     *
     */
    private $answers = [];

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
        if ($this->tags instanceof PersistentCollection) {
            $this->tags = $this->tags->toArray();
        }
        return $this->tags;
    }

    /**
     * @param string $title
     * @param string $body
     *
     * @return Question
     */
    public function update(string $title, string $body): Question
    {
        $this->body = $body;
        $this->title = $title;
        return $this;
    }

    /**
     * @param array $tags
     *
     * @return Question
     */
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

    /**
     * @return Answer[]
     */
    public function answers(): array
    {
        return $this->answers;
    }

    /**
     * @param Answer $answer
     *
     * @return Question
     */
    public function addAnswer(Answer $answer): Question
    {
        $this->answers[(string) $answer->answerId()] = $answer;
        return $this;
    }

    /**
     * @param Answer $answer
     * @return Question
     */
    public function removeAnswer(Answer $answer): Question
    {
        $copy = $this->answers;
        $new = [];
        foreach ($copy as $current) {
            if ($current->answerId()->equalsTo($answer->answerId())) {
                continue;
            }
            $new[(string) $current->answerId()] = $current;
        }
        $this->answers = $new;
        return $this;
    }

    public function correctAnswer(): ?Answer
    {
        foreach ($this->answers as $answer) {
            if ($answer->isCorrectAnswer()) {
                return $answer;
            }
        }

        return null;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by json_encode(),
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'questionId' => $this->questionId,
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags(),
            'datePublished' => $this->datePublished,
            'user' => $this->user,
            'correctAnswer' => $this->correctAnswer()
        ];
    }
}
