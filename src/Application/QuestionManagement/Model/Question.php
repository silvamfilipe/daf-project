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
 * Question
 *
 * @package App\Application\QuestionManagement\Model
 *
 * @OA\Schema(
 *     schema="ListingQuestion",
 *     title="Question",
 *     description="A Flat Question used in lisings",
 * )
 */
final class Question
{

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Question ID",
     *     title="Question ID",
     * )
     */
    public $questionId;

    /**
     * @var User
     *
     * @OA\Property(
     *     description="Question owner",
     *     title="User",
     * )
     */
    public $user;

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Question title",
     *     example="An example question"
     * )
     */
    public $title;

    /**
     * @var array
     *
     * @OA\Property(
     *     description="Question tags",
     *     title="Tags",
     *     @OA\Items(type="string")
     * )
     */
    public $tags;

    /**
     * @var \DateTimeImmutable
     *
     * @OA\Property(ref="#/components/schemas/DateTime")
     */
    public $datePublished;

    /**
     * @var int
     *
     * @OA\Property(
     *     description="Answers given",
     *     example="The number of answers given"
     * )
     */
    public $answersGiven;

    public function __construct(array $data)
    {
        $this->questionId = $data['questionId'];
        $this->user = (object) [
            'userId' => $data['questionId'],
            'name' => $data['name'],
            'email' => $data['email'],
        ];
        $this->title = $data['title'];
        $this->tags = $data['tags'] ? explode(', ', $data['tags']) : [];
        $this->answersGiven = (int) $data['answers'];
        $this->datePublished = new \DateTimeImmutable($data['datePublished']);
    }
}
