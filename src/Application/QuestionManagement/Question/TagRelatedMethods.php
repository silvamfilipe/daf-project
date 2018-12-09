<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question\Tag;
use App\Domain\QuestionManagement\Question\Tag\TagId;
use App\Domain\QuestionManagement\QuestionsRepository;
use Ramsey\Uuid\Uuid;

/**
 * TagRelatedMethods
 *
 * @package App\Application\QuestionManagement\Question
 */
trait TagRelatedMethods
{

    /**
     * Returns the questions repository
     *
     * @return QuestionsRepository
     */
    abstract protected function questionsRepository(): QuestionsRepository;

    /**
     * Search for existing tags or create new ones given a list of tags as string
     *
     * @param array $tags
     *
     * @return array
     * @throws \Exception
     */
    protected function normalizeTags(array $tags): array
    {
        $newTags = [];
        foreach ($tags as $tag) {

            if ($tag instanceof Tag) {
                $newTags[] = $tag;
                continue;
            }

            $existing = $this->parseArrayOrObject($tag);

            $newTags[] = $existing ?: new Tag($tag);
        }

        return $newTags;
    }


    /**
     * @param $tag
     * @return Tag|null
     * @throws \Exception
     */
    protected function parseArrayOrObject($tag): ?Tag
    {
        if (is_array($tag) || is_object($tag)) {
            $tag = (object) $tag;
            if (property_exists($tag, 'tagId')) {
                $existing = $this->retrieveByTagId($tag);
                if ($existing) {
                    return $existing;
                }
            }
            $tag = $this->retrieveNextPropertyValue($tag);
        }

        return $tag ? $this->parseString($tag) : null;
    }

    protected function parseString(string $tag): ?Tag
    {
        $existing = $this->questionsRepository()->tag($tag);
        if ($existing) {
            return $existing;
        }

        return null;
    }

    protected function retrieveNextPropertyValue($object): ?string
    {
        foreach ($object as $key => $value) {
            if ($key !== 'tagId') {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param $tag
     * @return Tag|null
     * @throws \Exception
     */
    protected function retrieveByTagId($tag): ?Tag
    {
        if (!Uuid::isValid($tag->tagId)) {
            return null;
        }
        $existing = $this->questionsRepository()->tagWithId(new TagId($tag->tagId));
        return $existing;
    }
}
