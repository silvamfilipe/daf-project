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
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Answer
 *
 * @package App\Domain\QuestionManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="answers")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 * @IgnoreAnnotation("OA\Items")
 *
 * @OA\Schema(
 *     title="Answer",
 *     description="Answer",
 * )
 */
class Answer implements JsonSerializable
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
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\QuestionManagement\Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     *
     * @OA\Property(
     *     description="Question identifer",
     *     example="06b116fe-e749-4f95-937d-94c5c4adcfbc",
     *     type="string",
     *     property="questionId"
     * )
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @OA\Property(
     *     description="Answer body",
     *     example="A simple and powerfull answer!",
     * )
     */
    private $body;

    /**
     * @var AnswerId
     *
     * @ORM\Id()
     * @ORM\Column(type="AnswerId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="Answer identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private $answerId;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", name="date_published")
     *
     * @OA\Property(ref="#/components/schemas/DateTime")
     */
    private $datePublished;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="correct_answer")
     *
     * @OA\Property(
     *     description="Correct answer",
     *     example=true
     * )
     */
    private $correctAnswer = false;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", name="positive_votes")
     *
     * @OA\Property(
     *     description="Positive votes",
     *     example=35
     * )
     */
    private $positiveVotes = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", name="negative_votes")
     *
     * @OA\Property(
     *     description="Negative votes",
     *     example=6
     * )
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

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by json_encode(),
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'answerId' => $this->answerId,
            'questionId' => $this->question->questionId(),
            'body' => $this->body,
            'isCorrectAnswer' => $this->correctAnswer,
            'positiveVotes' => $this->positiveVotes,
            'negativeVotes' => $this->negativeVotes,
            'datePublished' => $this->datePublished,
            'user' => $this->user
        ];
    }
}
