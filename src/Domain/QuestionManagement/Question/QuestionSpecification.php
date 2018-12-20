<?php
/**
 * This file is part of Forum project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Question;

use App\Domain\QuestionManagement\Question;

/**
 * QuestionSpecification
 *
 * @package App\Domain\QuestionManagement\Question
 */
interface QuestionSpecification
{

    /**
     * Check if passer question satisfies current specification
     *
     * @param Question $question
     * @return bool
     */
    public function isSatisfiedBy(Question $question): bool;
}
