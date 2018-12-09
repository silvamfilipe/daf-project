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
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Tag
 *
 * @package App\Domain\QuestionManagement\Question
 *
 * @ORM\Entity()
 * @ORM\Table(name="tags")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 *
 * @OA\Schema(
 *     title="Tag",
 *     description="Tag",
 * )
 */
class Tag implements Stringable, JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Tag description",
     *     example="HTML"
     * )
     */
    private $description;

    /**
     * @var TagId
     *
     * @ORM\Id()
     * @ORM\Column(type="TagId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="Tag identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
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
