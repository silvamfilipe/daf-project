<?php

/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement\Answer;

use App\Domain\QuestionManagement\Answer\AnswerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * DoctrineAnswerId
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement\Answer
 */
final class DoctrineAnswerId extends StringType
{

    /**
     * @inheritdoc
     *
     * @param AnswerId $value
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
        return new AnswerId($value);
    }

    public function getName()
    {
        return 'AnswerId';
    }
}
