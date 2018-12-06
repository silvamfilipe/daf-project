<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Answer;

/**
 * Vote
 *
 * @package App\Domain\QuestionManagement\Answer
 */
final class Vote
{

    private CONST NEGATIVE = 0;
    private CONST POSITIVE = 1;

    /**
     * @var bool
     */
    private $value;

    private function __construct(bool $value)
    {
        $this->value = $value;
    }

    public static function negative(): Vote
    {
        $vote = new Vote(self::NEGATIVE);
        return $vote;
    }

    public static function positive(): Vote
    {
        $vote = new Vote(self::POSITIVE);
        return $vote;
    }

    public function isPositive(): bool
    {
        return $this->value;
    }

    public function isNegative(): bool
    {
        return !$this->value;
    }
}
