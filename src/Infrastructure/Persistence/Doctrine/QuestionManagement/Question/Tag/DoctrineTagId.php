<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question\Tag;

use App\Domain\QuestionManagement\Question\Tag\TagId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * DoctrineTagId
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question\Tag
 */
final class DoctrineTagId extends StringType
{

    /**
     * @inheritdoc
     *
     * @param TagId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new TagId($value);
    }

    public function getName()
    {
        return 'TagId';
    }
}
