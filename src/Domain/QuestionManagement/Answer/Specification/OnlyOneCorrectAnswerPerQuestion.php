<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Answer\Specification;

use App\Domain\QuestionManagement\Answer;
use App\Domain\QuestionManagement\Answer\AnswerSpecification;

/**
 * OnlyOneCorrectAnswerPerQuestion
 *
 * @package App\Domain\QuestionManagement\Answer\Specification
 */
class OnlyOneCorrectAnswerPerQuestion implements AnswerSpecification
{
    /**
     * Verify if passed answer satisfies current specification
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        $question = $answer->question();
        foreach ($question->answers() as $qAnswer) {
            if ($qAnswer->equalsTo($answer)) {
                continue;
            }

            if ($qAnswer->isCorrectAnswer()) {
                return false;
            }
        }
        return true;
    }
}
