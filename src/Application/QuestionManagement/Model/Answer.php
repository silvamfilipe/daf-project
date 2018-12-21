<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Model;

use App\Domain\UserManagement\User;

/**
 * Answer
 *
 * @package App\Application\QuestionManagement\Model
 *
 * @OA\Schema(
 *     schema="ListingAnswer",
 *     title="Answer",
 *     description="A Flat Answer used in lisings",
 * )
 */
final class Answer
{

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Answer ID",
     *     title="Answer ID",
     * )
     */
    public $answerId;

    /**
     * @var object
     *
     *  @OA\Property(ref="#/components/schemas/QuestionTitle")
     */
    public $question;

    /**
     * @var User
     *
     * @OA\Property(
     *     description="Answer owner",
     *     title="User",
     * )
     */
    public $user;

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Answer body",
     *     example="An example answer body"
     * )
     */
    public $body;

    /**
     * @var \DateTimeImmutable
     *
     * @OA\Property(ref="#/components/schemas/DateTime")
     */
    public $datePublished;

    /**
     * @var bool
     *
     * @OA\Property(
     *     description="Correct answer",
     *     example=true
     * )
     */
    public $correctAnswer;

    /**
     * @var integer
     *
     * @OA\Property(
     *     description="Positive votes",
     *     example=35
     * )
     */
    public $positiveVotes;

    /**
     * @var integer
     *
     * @OA\Property(
     *     description="Negative votes",
     *     example=6
     * )
     */
    public $negativeVotes;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        $this->datePublished = new \DateTimeImmutable($this->datePublished);
        $this->user = (object) [
            'userId' => $data['userId'],
            'name' => $data['name'],
            'email' => $data['email']
        ];
        $this->question = (object) [
            'questionId' => $data['questionId'],
            'title' => $data['title'],
        ];
        $this->correctAnswer = (bool) $this->correctAnswer;
    }
}

/**
 * /**
 * @OA\Schema(
 *     schema="QuestionTitle",
 *     type="object",
 *     @OA\Property(property="questionId", type="string", example="06b116fe-e749-4f95-937d-94c5c4adcfbc"),
 *     @OA\Property(property="title", type="string", example="Why are you doing it?")
 * )
 */
