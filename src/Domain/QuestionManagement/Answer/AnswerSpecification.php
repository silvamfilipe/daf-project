<?php
/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Answer;

use App\Domain\QuestionManagement\Answer;

/**
 * AnswerSpecification
 *
 * @package App\Domain\QuestionManagement\Answer
 */
interface AnswerSpecification
{

    /**
     * Verify if passed answer satisfies current specification
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool;
}
