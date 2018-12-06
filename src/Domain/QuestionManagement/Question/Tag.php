<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question\Tag\TagId;
use App\Domain\Stringable;
use JsonSerializable;

/**
 * Tag
 *
 * @package App\Domain\QuestionManagement\Question
 */
final class Tag implements Stringable, JsonSerializable
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var TagId
     */
    private $tagId;

    /**
     * Creates a Tag
     *
     * @param string $description
     * @throws \Exception
     */
    public function __construct(string $description)
    {
        $this->description = $description;
        $this->tagId = new TagId();
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * Returns a text version of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->description;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by json_encode,
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'tagId' => $this->tagId,
            'description' => $this->description
        ];
    }
}
