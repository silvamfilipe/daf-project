<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement\Question\Specification;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\QuestionSpecification;
use App\Domain\UserManagement\UserIdentifier;

/**
 * UserIsQuestionOwner
 *
 * @package App\Domain\QuestionManagement\Question\Specification
 */
class UserIsQuestionOwner implements QuestionSpecification
{
    /**
     * @var UserIdentifier
     */
    private $identifier;

    /**
     * Creates a UserIsQuestionOwner
     *
     * @param UserIdentifier $identifier
     */
    public function __construct(UserIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Check if passer question satisfies current specification
     *
     * @param Question $question
     * @return bool
     */
    public function isSatisfiedBy(Question $question): bool
    {
        return $this->identifier->currentUser()->equalsTo($question->user());
    }
}
